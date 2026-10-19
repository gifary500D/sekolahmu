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
        
        // Ambil daftar tugas khusus untuk kelas siswa tersebut atau tugas umum (kelas_id null)
        $tugasList = Tugas::where(function($q) use ($user) {
            $q->where('kelas_id', $user->kelas_id)->orWhereNull('kelas_id');
        })->orderBy('tenggat', 'asc')->get();
        
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

        if (now()->greaterThan(\Carbon\Carbon::parse($tugas->tenggat))) {
            return redirect()->back()->with('error', 'Maaf, tenggat waktu pengumpulan tugas ini telah terlewat. Anda tidak dapat mengunggah berkas.');
        }

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
        $user = auth()->user()->load('kelas');
        $className = $user->kelas?->nama;
        
        // Ambil data absensi khusus kelas siswa tersebut
        $absensiList = $className ? Absensi::where('kelas', $className)->orderBy('tanggal', 'desc')->get() : collect();

        return view('siswa.absensi', compact('absensiList', 'user'));
    }

    /**
     * Tampilkan transkrip rekapitulasi nilai tugas siswa
     */
    public function transkripNilai()
    {
        $user = auth()->user();
        $submissions = TugasSiswa::with('tugas')->where('siswa_id', $user->id)->orderBy('updated_at', 'desc')->get();
        return view('siswa.nilai', compact('submissions'));
    }

    /**
     * Tampilkan jadwal pelajaran (roster) kelas siswa
     */
    public function roster()
    {
        $user = auth()->user()->load('kelas');
        $rosters = $user->kelas_id ? \App\Models\Roster::with('guru')->where('kelas_id', $user->kelas_id)->orderBy('hari')->orderBy('jam_mulai')->get() : collect();
        return view('siswa.roster', compact('rosters', 'user'));
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
