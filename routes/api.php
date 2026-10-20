<?php

use App\Http\Controllers\Api\V1\AbsensiController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SpmbController;
use Illuminate\Support\Facades\Route;

/*
| REST API v1 (prefix otomatis /api). Semua jawaban berformat JSON.
| Autentikasi: header "Authorization: Bearer <token>" dari POST /api/v1/auth/login (Laravel Sanctum).
*/
Route::prefix('v1')->group(function () {

    // ---- Publik (tanpa login) ----
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('spmb/daftar', [SpmbController::class, 'daftar'])->middleware('throttle:10,1');
    Route::get('spmb/status/{nomor}', [SpmbController::class, 'cekStatus'])->middleware('throttle:30,1');

    // ---- Modul tugas dan konten: berita, agenda, galeri (publik), tugas, notifikasi, pengelolaan konten ----
    require __DIR__ . '/tugas_konten.php';

    // ---- Terautentikasi ----
    Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // PPDB / SPMB
        Route::get('spmb/statistik', [SpmbController::class, 'statistik'])->middleware('role:admin,kepala_sekolah');
        Route::middleware('role:admin')->group(function () {
            Route::get('spmb', [SpmbController::class, 'index']);
            Route::get('spmb/{spmb}', [SpmbController::class, 'show'])->whereNumber('spmb');
            Route::put('spmb/{spmb}/status', [SpmbController::class, 'updateStatus'])->whereNumber('spmb');
            Route::get('absensi/export/{kelas}', [AbsensiController::class, 'exportCsv'])->whereNumber('kelas');
        });

        // Absensi
        Route::middleware('role:guru,admin,kepala_sekolah')->group(function () {
            Route::get('kelas', [AbsensiController::class, 'kelas']);
            Route::get('kelas/{kelas}/siswa', [AbsensiController::class, 'siswa'])->whereNumber('kelas');
            Route::get('absensi', [AbsensiController::class, 'index']);
            Route::get('absensi/rekap/{kelas}', [AbsensiController::class, 'rekap'])->whereNumber('kelas');
        });
        Route::post('absensi', [AbsensiController::class, 'simpan'])->middleware('role:guru,admin');
        Route::get('absensi/saya', [AbsensiController::class, 'saya'])->middleware('role:siswa');
    });
});
