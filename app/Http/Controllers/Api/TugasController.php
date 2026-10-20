<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Guru membuat/menambahkan tugas baru
     */
    public function buatTugas(Request $request)
    {
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
            $kelasObj = Kelas::where('nama', 'LIKE', "%{$request->kelas}%")->first();
            $kelasId = $kelasObj?->id;
        }
        if (! $kelasId) {
            $kelasId = Kelas::first()?->id ?? 1;
        }

        // Normalisasi nilai prioritas
        $prioritasInput = strtolower((string) $request->input('prioritas', 'sedang'));
        $prioritas = match ($prioritasInput) {
            'rendah' => 'rendah',
            'tinggi' => 'tinggi',
            default => 'sedang',
        };

        $user = $request->user();
        $guruId = $user?->id ?? 1;

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
    public function daftarTugas($kelas)
    {
        $kelasId = is_numeric($kelas) ? (int) $kelas : Kelas::where('nama', 'LIKE', "%{$kelas}%")->value('id');

        $query = Tugas::query()->with(['kelas:id,nama', 'guru:id,name']);

        if ($kelasId) {
            $query->where(function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId)->orWhereNull('kelas_id');
            });
        } else {
            $query->whereHas('kelas', function ($q) use ($kelas) {
                $q->where('nama', 'LIKE', "%{$kelas}%");
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
        $tugas = Tugas::find($id);

        if (! $tugas) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.',
            ], 404);
        }

        $user = $request->user();
        if ($user && ! $user->isAdmin() && $user->id !== $tugas->guru_id) {
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
