<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/halo', function () {
    return 'Halo Suclyn, siap ngoding Laravel 12!';
});

use App\Http\Controllers\PageController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;

Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/proses-login', [PageController::class, 'prosesLogin'])->name('login.post');
Route::get('/logout', [PageController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user()->load('kelas');
        if ($user->isAdmin()) {
            return app(AdminController::class)->dashboard();
        }
        if ($user->isGuru()) {
            return app(GuruController::class)->dashboard();
        }
        
        // Jika siswa belum mengubah password default, wajibkan ubah password
        if ($user->isSiswa() && ! $user->password_changed) {
            return redirect()->route('siswa.password.form');
        }
        
        // Dynamic tasks for student
        $tugasList = \App\Models\Tugas::where(function($q) use ($user) {
            $q->where('kelas_id', $user->kelas_id)->orWhereNull('kelas_id');
        })->orderBy('tenggat', 'asc')->take(5)->get();
        
        $submitted = \App\Models\TugasSiswa::where('siswa_id', $user->id)->get()->keyBy('tugas_id');
        
        // Dynamic announcements
        $pengumuman = \App\Models\Berita::where('status', 'terbit')->latest()->take(2)->get();

        // Dynamic attendance rate
        $className = $user->kelas?->nama;
        $absensiRecords = $className ? \App\Models\Absensi::where('kelas', $className)->get() : collect();
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
    })->name('dashboard');

    // Admin routes
    Route::get('/dashboard/admin/spmb', [AdminController::class, 'spmbIndex'])->name('admin.spmb.index');
    Route::get('/dashboard/admin/spmb/export', [AdminController::class, 'spmbExport'])->name('admin.spmb.export');
    Route::post('/dashboard/admin/spmb/{id}/status', [AdminController::class, 'spmbUpdateStatus'])->name('admin.spmb.status');
    
    Route::get('/dashboard/admin/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
    Route::get('/dashboard/admin/guru', [AdminController::class, 'guruIndex'])->name('admin.guru.index');
    
    Route::get('/dashboard/admin/roster', [AdminController::class, 'rosterIndex'])->name('admin.roster.index');
    Route::post('/dashboard/admin/roster/simpan', [AdminController::class, 'rosterStore'])->name('admin.roster.store');
    Route::delete('/dashboard/admin/roster/{id}/hapus', [AdminController::class, 'rosterDelete'])->name('admin.roster.delete');

    Route::get('/dashboard/admin/pengguna', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::post('/dashboard/admin/pengguna/simpan', [AdminController::class, 'userStore'])->name('admin.users.store');
    Route::delete('/dashboard/admin/pengguna/{id}/hapus', [AdminController::class, 'userDelete'])->name('admin.users.delete');

    // Student password change routes
    Route::get('/dashboard/ubah-password', [SiswaController::class, 'formUbahPassword'])->name('siswa.password.form');
    Route::post('/dashboard/ubah-password', [SiswaController::class, 'simpanUbahPassword'])->name('siswa.password.update');

    // Student routes
    Route::get('/dashboard/tugas', [SiswaController::class, 'tugas'])->name('siswa.tugas');
    Route::post('/dashboard/tugas/{id}/kumpulkan', [SiswaController::class, 'kumpulkanTugas'])->name('siswa.tugas.submit');
    Route::delete('/dashboard/tugas/{id}/batalkan', [SiswaController::class, 'batalkanTugas'])->name('siswa.tugas.cancel');
    Route::get('/dashboard/absensi', [SiswaController::class, 'absensi'])->name('siswa.absensi');

    // Teacher routes
    Route::get('/dashboard/guru/tugas', [GuruController::class, 'tugasIndex'])->name('guru.tugas.index');
    Route::get('/dashboard/guru/tugas/buat', [GuruController::class, 'tugasCreate'])->name('guru.tugas.create');
    Route::post('/dashboard/guru/tugas/simpan', [GuruController::class, 'tugasStore'])->name('guru.tugas.store');
    Route::get('/dashboard/guru/tugas/{id}/pengumpulan', [GuruController::class, 'tugasSubmissions'])->name('guru.tugas.submissions');
    Route::get('/dashboard/guru/tugas/{id}/export', [GuruController::class, 'exportTugas'])->name('guru.tugas.export');
    Route::post('/dashboard/guru/tugas/berkas/{id}/nilai', [GuruController::class, 'beriNilai'])->name('guru.tugas.grade');
    Route::get('/dashboard/guru/tugas/berkas/{id}/unduh', [GuruController::class, 'downloadBerkas'])->name('guru.tugas.download');
    Route::get('/dashboard/guru/absensi', [GuruController::class, 'absensiIndex'])->name('guru.absensi');
    Route::get('/dashboard/guru/absensi/export', [GuruController::class, 'exportAbsensi'])->name('guru.absensi.export');
    Route::post('/dashboard/guru/absensi/simpan', [GuruController::class, 'absensiStore'])->name('guru.absensi.store');
});

Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');
Route::post('/proses-pendaftaran', [PageController::class, 'prosesPendaftaran']);
