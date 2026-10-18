<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar tugas siswa
     */
    public function tugas()
    {
        $user = auth()->user();
        
        // Ambil daftar tugas diurutkan berdasarkan tenggat
        $tugasList = Tugas::orderBy('tenggat', 'asc')->get();
        
        // Ambil status pengerjaan tugas oleh siswa ini
        $submitted = TugasSiswa::where('siswa_id', $user->id)->get()->keyBy('tugas_id');

        return view('siswa.tugas', compact('tugasList', 'submitted'));
    }

    /**
     * Proses pengumpulan tugas oleh siswa dengan unggah berkas (PDF, Foto, Dokumen)
     */
    public function kumpulkanTugas(Request $request, $id)
    {
        $user = auth()->user();
        
        $request->validate([
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // max 10MB
        ], [
            'berkas.required' => 'Harap unggah file tugas (PDF, Foto, atau Dokumen).',
            'berkas.mimes' => 'Format file harus berupa PDF, JPG, PNG, DOC, atau DOCX.',
            'berkas.max' => 'Ukuran file maksimal adalah 10 MB.',
        ]);

        $tugas = Tugas::findOrFail($id);

        $filePath = null;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $filename = time() . '_' . $user->id . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('tugas_terkumpul', $filename, 'public');
        }

        TugasSiswa::updateOrCreate(
            [
                'tugas_id' => $tugas->id,
                'siswa_id' => $user->id,
            ],
            [
                'status' => 'selesai',
                'file_path' => $filePath,
                'diselesaikan_pada' => now(),
            ]
        );

        return redirect()->route('siswa.tugas')->with('success', 'Tugas dan berkas berhasil diunggah dan dikumpulkan.');
    }

    /**
     * Batalkan atau hapus pengumpulan tugas
     */
    public function batalkanTugas($id)
    {
        $user = auth()->user();
        
        $submission = TugasSiswa::where('tugas_id', $id)->where('siswa_id', $user->id)->first();
        if ($submission) {
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }
            $submission->delete();
        }

        return redirect()->route('siswa.tugas')->with('success', 'Pengumpulan tugas berhasil dibatalkan. Anda dapat mengunggah ulang.');
    }

    /**
     * Tampilkan rekapitulasi absensi siswa
     */
    public function absensi()
    {
        $user = auth()->user();
        
        // Ambil data absensi kelas siswa
        $absensiList = Absensi::orderBy('tanggal', 'desc')->get();

        return view('siswa.absensi', compact('absensiList'));
    }

    /**
     * Tampilkan form ubah password wajib untuk siswa baru
     */
    public function formUbahPassword()
    {
        return view('siswa.ubah-password');
    }

    /**
     * Simpan perubahan password wajib
     */
    public function simpanUbahPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kata sandi berhasil diperbarui. Selamat datang di Portal Siswa!');
    }
}
