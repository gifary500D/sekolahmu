<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Berita;
use App\Models\Roster;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Tampilkan dashboard utama siswa
     */
    public function dashboard()
    {
        $user = auth()->user()->load('kelas');

        // Siswa wajib ganti kata sandi bawaan jika belum diubah
        if (! $user->password_changed) {
            return redirect()->route('siswa.password.form');
        }

        $tugasList = Tugas::where(function ($q) use ($user) {
            $q->where('kelas_id', $user->kelas_id)->orWhereNull('kelas_id');
        })->orderBy('tenggat', 'asc')->take(5)->get();

        $submitted = TugasSiswa::where('siswa_id', $user->id)->get()->keyBy('tugas_id');
        $pengumuman = Berita::where('status', 'terbit')->latest()->take(2)->get();

        $className = $user->kelas?->nama;
        $absensiRecords = $className ? Absensi::where('kelas', $className)->get() : collect();
        $totalHadir = 0;
        $totalAbsen = $absensiRecords->count();
        foreach ($absensiRecords as $record) {
            $data = $record->data_kehadiran ?? [];
            if (isset($data[$user->id]) && $data[$user->id] === 'Hadir') {
                $totalHadir++;
            }
        }
        $attendanceRate = $totalAbsen > 0 ? round(($totalHadir / $totalAbsen) * 100) : 100;

        return view('siswa.dashboard', compact('tugasList', 'submitted', 'pengumuman', 'attendanceRate'));
    }

    /**
     * Tampilkan daftar tugas siswa
     */
    public function tugas()
    {
        $user = auth()->user();

        // Ambil daftar tugas khusus untuk kelas siswa tersebut atau tugas umum (kelas_id null)
        $tugasList = Tugas::where(function ($q) use ($user) {
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

        if ($tugas->kelas_id && (int) $tugas->kelas_id !== (int) $user->kelas_id) {
            abort(403, 'Anda tidak berhak mengumpulkan tugas untuk kelas lain.');
        }

        if (now()->greaterThan(Carbon::parse($tugas->tenggat))) {
            return redirect()->back()->with('error', 'Maaf, tenggat waktu pengumpulan tugas ini telah terlewat. Anda tidak dapat mengunggah berkas.');
        }

        $filePath = null;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $filename = time().'_'.$user->id.'_'.preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('private/tugas', $filename, 'local');
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
            if ($submission->file_path && Storage::disk('local')->exists($submission->file_path)) {
                Storage::disk('local')->delete($submission->file_path);
            }
            $submission->delete();
        }

        return redirect()->route('siswa.tugas')->with('success', 'Pengumpulan tugas berhasil dibatalkan. Anda dapat mengunggah ulang.');
    }

    /**
     * Unduh berkas tugas siswa milik sendiri secara aman
     */
    public function downloadBerkas($submissionId)
    {
        $user = auth()->user();
        $submission = TugasSiswa::with('tugas')->findOrFail($submissionId);

        // Siswa hanya boleh mengunduh berkas tugasnya sendiri
        if ((int) $submission->siswa_id !== (int) $user->id) {
            abort(403, 'Anda tidak berhak mengunduh berkas tugas siswa lain.');
        }

        if (! $submission->file_path || ! Storage::disk('local')->exists($submission->file_path)) {
            return redirect()->back()->with('error', 'Berkas lampiran tidak ditemukan di server.');
        }

        return Storage::disk('local')->download($submission->file_path);
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
        $rosters = $user->kelas_id ? Roster::with('guru')->where('kelas_id', $user->kelas_id)->orderBy('hari')->orderBy('jam_mulai')->get() : collect();

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

        $user = auth()->user() ?? $request->user();
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed' => true,
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Kata sandi berhasil diperbarui. Selamat datang di Portal Siswa!',
                'data' => [
                    'password_changed' => true,
                ],
            ], 200);
        }

        return redirect()->route('dashboard')->with('success', 'Kata sandi berhasil diperbarui. Selamat datang di Portal Siswa!');
    }
}
