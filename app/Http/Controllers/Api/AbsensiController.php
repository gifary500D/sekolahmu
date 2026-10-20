<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Support\Teks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AbsensiController extends Controller
{
    // 1. Guru menyimpan/mencatat absensi per kelas
    public function simpanAbsensi(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'data_kehadiran' => 'required|array', // Contoh format: [{"nama": "Budi", "status": "Hadir"}, ...]
        ]);

        $user = $request->user();
        if ($user && $user->isGuru() && ! $user->canManageKelas($request->kelas)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak mengelola absensi kelas ini.',
            ], 403);
        }

        $absensi = Absensi::create([
            'kelas' => $request->kelas,
            'tanggal' => $request->tanggal,
            'data_kehadiran' => $request->data_kehadiran,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi kelas berhasil disimpan.',
            'data' => $absensi,
        ], 201);
    }

    // 2. Melihat rekap absensi berdasarkan kelas
    public function rekapAbsensi(Request $request, $kelas)
    {
        $user = $request->user();

        // Validasi otorisasi peran
        if ($user) {
            if ($user->isSiswa()) {
                $userKelasNama = $user->kelas?->nama;
                if ($userKelasNama !== $kelas && (string) $user->kelas_id !== (string) $kelas) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak berhak melihat absensi kelas lain.',
                    ], 403);
                }
            } elseif ($user->isGuru() && ! $user->canManageKelas($kelas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki hak mengakses rekap absensi kelas ini.',
                ], 403);
            }
        }

        $escaped = Teks::escapeLike((string) $kelas);
        $dataAbsensi = Absensi::where('kelas', 'LIKE', "%{$escaped}%")->orderBy('tanggal', 'DESC')->get();

        if ($dataAbsensi->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data absensi untuk kelas tersebut.',
            ], 404);
        }

        // Jika peran adalah siswa, filter data_kehadiran agar siswa HANYA melihat datanya sendiri
        if ($user && $user->isSiswa()) {
            $dataAbsensi = $dataAbsensi->map(function ($item) use ($user) {
                $kehadiranList = $item->data_kehadiran;
                $filteredKehadiran = [];

                if (is_array($kehadiranList)) {
                    if (array_is_list($kehadiranList)) {
                        // Format list: [['nama' => '...', 'status' => '...'], ...]
                        foreach ($kehadiranList as $row) {
                            if (is_array($row)) {
                                $matchId = isset($row['siswa_id']) && (int) $row['siswa_id'] === (int) $user->id;
                                $matchName = isset($row['nama']) && strtolower(trim((string) $row['nama'])) === strtolower(trim((string) $user->name));
                                if ($matchId || $matchName) {
                                    $filteredKehadiran[] = $row;
                                }
                            }
                        }
                    } else {
                        // Format asosiatif: [siswa_id => 'Hadir'|'Sakit'|...]
                        if (isset($kehadiranList[$user->id])) {
                            $filteredKehadiran[$user->id] = $kehadiranList[$user->id];
                        }
                    }
                }

                $clone = clone $item;
                $clone->data_kehadiran = $filteredKehadiran;
                return $clone;
            });
        }

        return response()->json([
            'success' => true,
            'message' => 'Data rekap absensi ditemukan.',
            'data' => $dataAbsensi,
        ], 200);
    }

    // 3. Ekspor Data Absensi ke Format CSV yang Rapi per Siswa (Terproteksi dari Formula Injection)
    public function exportCsv(Request $request, $kelas)
    {
        $user = $request->user();

        if ($user) {
            if ($user->isSiswa()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak memiliki izin untuk mengekspor absensi.',
                ], 403);
            }

            if ($user->isGuru() && ! $user->canManageKelas($kelas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki hak mengekspor absensi kelas ini.',
                ], 403);
            }
        }

        $escaped = Teks::escapeLike((string) $kelas);
        $dataAbsensi = Absensi::where('kelas', 'LIKE', "%{$escaped}%")->get();

        if ($dataAbsensi->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan untuk diekspor'], 404);
        }

        $filename = 'rekap-absensi-'.str_replace(' ', '-', strtolower($kelas)).'-'.date('Y-m-d').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($dataAbsensi) {
            $file = fopen('php://output', 'w');

            // Header kolom CSV yang bersih dan terstruktur
            fputcsv($file, ['No', 'Kelas', 'Tanggal', 'Nama Siswa', 'Status Kehadiran']);

            $no = 1;
            foreach ($dataAbsensi as $absen) {
                $kehadiranList = $absen->data_kehadiran;

                if (is_array($kehadiranList)) {
                    foreach ($kehadiranList as $key => $siswa) {
                        $nama = is_array($siswa) ? ($siswa['nama'] ?? '-') : ('Siswa ID #' . $key);
                        $status = is_array($siswa) ? ($siswa['status'] ?? '-') : (string) $siswa;

                        // Mitigasi Formula Injection (CSV Injection)
                        fputcsv($file, [
                            $no++,
                            Teks::amankanFormulaCsv($absen->kelas),
                            Teks::amankanFormulaCsv($absen->tanggal),
                            Teks::amankanFormulaCsv($nama),
                            Teks::amankanFormulaCsv($status),
                        ]);
                    }
                }
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

