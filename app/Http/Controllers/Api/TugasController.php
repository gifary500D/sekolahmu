<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Support\Teks;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Guru membuat/menambahkan tugas baru
     */
    public function buatTugas(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $request->validate([
            'judul' => 'nullable|string|max:255',
            'judul_tugas' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'mata_pelajaran' => 'nullable|string|max:100',
            'kelas' => 'nullable|string|max:50',
            'kelas_id' => 'nullable|integer',
            'tenggat' => 'nullable|date',
            'tenggat_waktu' => 'nullable|date',
            'prioritas' => 'nullable|string',
        ]);

        $judul = $request->input('judul', $request->input('judul_tugas'));
        if (! $judul) {
            return response()->json([
                'success' => false,
                'message' => 'Judul tugas wajib diisi.',
            ], 422);
        }

        $tenggat = $request->input('tenggat', $request->input('tenggat_waktu', now()->addDays(7)->toDateTimeString()));

        // Cari atau validasi kelas_id
        $kelasId = $request->input('kelas_id');
        if (! $kelasId && $request->filled('kelas')) {
            $escaped = Teks::escapeLike((string) $request->kelas);
            $kelasObj = Kelas::where('nama', $request->kelas)->orWhere('nama', 'LIKE', "%{$escaped}%")->first();
            $kelasId = $kelasObj?->id;
        }

        if (! $kelasId) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        $kelasModel = Kelas::find($kelasId);
        if (! $kelasModel) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        // Cegah manipulasi kelas_id lintas kelas oleh guru
        if ($user->isGuru() && ! $user->canManageKelas($kelasId)) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak memiliki hak membuat tugas untuk kelas ini.',
            ], 403);
        }

        // Normalisasi nilai prioritas
        $prioritasInput = strtolower((string) $request->input('prioritas', 'sedang'));
        $prioritas = match ($prioritasInput) {
            'rendah' => 'rendah',
            'tinggi' => 'tinggi',
            default => 'sedang',
        };

        // Kunci guru_id ke user yang login (cegah manipulasi guru_id)
        $guruId = $user->id;

        $tugas = Tugas::create([
            'judul' => $judul,
            'deskripsi' => $request->deskripsi,
            'mata_pelajaran' => $request->input('mata_pelajaran', 'Umum'),
            'kelas_id' => $kelasId,
            'guru_id' => $guruId,
            'tenggat' => $tenggat,
            'prioritas' => $prioritas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dibuat dan dibagikan ke kelas.',
            'data' => $tugas->load('kelas:id,nama'),
        ], 201);
    }

    /**
     * Siswa atau Guru melihat daftar tugas berdasarkan kelas
     */
    public function daftarTugas(Request $request, $kelas)
    {
        $user = $request->user();

        // Otorisasi role: siswa hanya boleh akses kelasnya sendiri
        if ($user) {
            if ($user->isSiswa()) {
                $userKelasNama = $user->kelas?->nama;
                if ($userKelasNama !== $kelas && (string) $user->kelas_id !== (string) $kelas) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Siswa tidak memiliki akses melihat tugas kelas lain.',
                    ], 403);
                }
            } elseif ($user->isGuru() && ! $user->canManageKelas($kelas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guru tidak memiliki hak melihat tugas kelas ini.',
                ], 403);
            }
        }

        $escaped = Teks::escapeLike((string) $kelas);
        $kelasId = is_numeric($kelas) ? (int) $kelas : Kelas::where('nama', 'LIKE', "%{$escaped}%")->value('id');

        $query = Tugas::query()->with(['kelas:id,nama', 'guru:id,name']);

        if ($kelasId) {
            $query->where(function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId)->orWhereNull('kelas_id');
            });
        } else {
            $query->whereHas('kelas', function ($q) use ($escaped) {
                $q->where('nama', 'LIKE', "%{$escaped}%");
            });
        }

        $tugasList = $query->orderBy('tenggat', 'ASC')->get();

        if ($tugasList->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tugas aktif untuk kelas tersebut.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar tugas berhasil dimuat.',
            'data' => $tugasList,
        ], 200);
    }

    /**
     * Menghapus tugas (hanya pembuat atau admin yang berhak)
     */
    public function hapusTugas(Request $request, $id)
    {
        $user = $request->user();
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $tugas = Tugas::find($id);

        if (! $tugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.',
            ], 404);
        }

        if (! $user->isAdmin() && (int) $user->id !== (int) $tugas->guru_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak untuk menghapus tugas ini.',
            ], 403);
        }

        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus.',
        ], 200);
    }
}
