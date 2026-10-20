<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Halaman Publik / Company Profile & SPMB
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/berita', [PageController::class, 'beritaIndex'])->name('berita.index');
Route::get('/agenda', [PageController::class, 'agendaIndex'])->name('agenda.index');
Route::get('/galeri', [PageController::class, 'galeriIndex'])->name('galeri.index');

// Halaman Informasi Sekolah (Company Profile)
Route::get('/tentang', [PageController::class, 'about'])->name('about');
Route::get('/fasilitas', [PageController::class, 'facilities'])->name('facilities');
Route::get('/guru', [PageController::class, 'teachers'])->name('teachers');

Route::get('/halo', function () {
    return 'Halo Suclyn, siap ngoding Laravel 12!';
});

// Autentikasi Web (dengan pembatasan laju percobaan login)
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/proses-login', [PageController::class, 'prosesLogin'])->name('login.post')->middleware('throttle:5,1');
Route::get('/logout', [PageController::class, 'logout'])->name('logout');

// Form Pendaftaran SPMB Publik (dengan proteksi anti-spam submission)
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');
Route::post('/proses-pendaftaran', [PageController::class, 'prosesPendaftaran'])->name('proses-pendaftaran')->middleware('throttle:10,1');

/*
|--------------------------------------------------------------------------
| Area Terproteksi (Login Diperlukan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Utama: Pengalihan Berdasarkan Peran (Admin / Guru / Siswa)
    Route::get('/dashboard', function () {
        $user = auth()->user()->load('kelas');
        if ($user->isAdmin()) {
            return app(AdminController::class)->dashboard();
        }
        if ($user->isGuru()) {
            return app(GuruController::class)->dashboard();
        }
        
        // Siswa wajib ganti kata sandi bawaan jika belum diubah
        if ($user->isSiswa() && ! $user->password_changed) {
            return redirect()->route('siswa.password.form');
        }
        
        $tugasList = \App\Models\Tugas::where(function($q) use ($user) {
            $q->where('kelas_id', $user->kelas_id)->orWhereNull('kelas_id');
        })->orderBy('tenggat', 'asc')->take(5)->get();
        
        $submitted = \App\Models\TugasSiswa::where('siswa_id', $user->id)->get()->keyBy('tugas_id');
        $pengumuman = \App\Models\Berita::where('status', 'terbit')->latest()->take(2)->get();

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

    // Profil Universal & Notifikasi
    Route::get('/dashboard/profil', [PageController::class, 'formProfil'])->name('profile.form');
    Route::post('/dashboard/profil', [PageController::class, 'simpanProfil'])->name('profile.update');
    Route::get('/dashboard/notifikasi', [PageController::class, 'notificationsIndex'])->name('notifications.index');

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: Administrator
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->prefix('dashboard/admin')->name('admin.')->group(function () {
        // SPMB
        Route::get('/spmb', [AdminController::class, 'spmbIndex'])->name('spmb.index');
        Route::get('/spmb/export', [AdminController::class, 'spmbExport'])->name('spmb.export');
        Route::get('/spmb/{id}/berkas/{jenis}', [AdminController::class, 'spmbDownloadBerkas'])->name('spmb.berkas');
        Route::post('/spmb/{id}/status', [AdminController::class, 'spmbUpdateStatus'])->name('spmb.status');

        // Civitas Akademika
        Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa.index');
        Route::get('/guru', [AdminController::class, 'guruIndex'])->name('guru.index');

        // CRUD Kelas
        Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
        Route::post('/kelas/simpan', [AdminController::class, 'kelasStore'])->name('kelas.store');
        Route::put('/kelas/{id}/update', [AdminController::class, 'kelasUpdate'])->name('kelas.update');
        Route::delete('/kelas/{id}/hapus', [AdminController::class, 'kelasDelete'])->name('kelas.delete');

        // CMS Konten
        Route::get('/cms', [AdminController::class, 'cmsIndex'])->name('cms.index');
        Route::post('/cms/berita', [AdminController::class, 'cmsBeritaStore'])->name('cms.berita.store');
        Route::delete('/cms/berita/{id}', [AdminController::class, 'cmsBeritaDelete'])->name('cms.berita.delete');

        // Jadwal Roster
        Route::get('/roster', [AdminController::class, 'rosterIndex'])->name('roster.index');
        Route::post('/roster/simpan', [AdminController::class, 'rosterStore'])->name('roster.store');
        Route::delete('/roster/{id}/hapus', [AdminController::class, 'rosterDelete'])->name('roster.delete');

        // Manajemen Pengguna
        Route::get('/pengguna', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::post('/pengguna/simpan', [AdminController::class, 'userStore'])->name('users.store');
        Route::put('/pengguna/{id}/update', [AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/pengguna/{id}/hapus', [AdminController::class, 'userDelete'])->name('users.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: Guru & Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:guru,admin'])->prefix('dashboard/guru')->name('guru.')->group(function () {
        // Manajemen Tugas
        Route::get('/tugas', [GuruController::class, 'tugasIndex'])->name('tugas.index');
        Route::get('/tugas/buat', [GuruController::class, 'tugasCreate'])->name('tugas.create');
        Route::post('/tugas/simpan', [GuruController::class, 'tugasStore'])->name('tugas.store');
        Route::delete('/tugas/{id}/hapus', [GuruController::class, 'tugasDelete'])->name('tugas.delete');
        Route::get('/tugas/{id}/pengumpulan', [GuruController::class, 'tugasSubmissions'])->name('tugas.submissions');
        Route::get('/tugas/{id}/export', [GuruController::class, 'exportTugas'])->name('tugas.export');
        Route::post('/tugas/berkas/{id}/nilai', [GuruController::class, 'beriNilai'])->name('tugas.grade');
        Route::get('/tugas/berkas/{id}/unduh', [GuruController::class, 'downloadBerkas'])->name('tugas.download');

        // Presensi & Absensi
        Route::get('/absensi', [GuruController::class, 'absensiIndex'])->name('absensi');
        Route::get('/absensi/export', [GuruController::class, 'exportAbsensi'])->name('absensi.export');
        Route::post('/absensi/simpan', [GuruController::class, 'absensiStore'])->name('absensi.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: Portal Siswa
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/dashboard/ubah-password', [SiswaController::class, 'formUbahPassword'])->name('siswa.password.form');
        Route::post('/dashboard/ubah-password', [SiswaController::class, 'simpanUbahPassword'])->name('siswa.password.update');

        Route::get('/dashboard/tugas', [SiswaController::class, 'tugas'])->name('siswa.tugas');
        Route::post('/dashboard/tugas/{id}/kumpulkan', [SiswaController::class, 'kumpulkanTugas'])->name('siswa.tugas.submit');
        Route::delete('/dashboard/tugas/{id}/batalkan', [SiswaController::class, 'batalkanTugas'])->name('siswa.tugas.cancel');
        Route::get('/dashboard/absensi', [SiswaController::class, 'absensi'])->name('siswa.absensi');
        Route::get('/dashboard/jadwal', [SiswaController::class, 'roster'])->name('siswa.roster');
        Route::get('/dashboard/nilai', [SiswaController::class, 'transkripNilai'])->name('siswa.nilai');
    });
});
