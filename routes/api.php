<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SpmbController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
// Modul Autentikasi API (Mendukung Email / NISN)
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Modul SPMB (Calon siswa mendaftar & cek status)
Route::post('/spmb/daftar', [SpmbController::class, 'daftar'])->middleware('throttle:10,1');
Route::get('/spmb/status/{nomor}', [SpmbController::class, 'cekStatus'])->middleware('throttle:30,1');

/*
|--------------------------------------------------------------------------
| Rute Terproteksi (Memerlukan Autentikasi / Login via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Manajemen Sesi & Profil Pengguna
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/ubah-password', [AuthController::class, 'ubahPassword']);

    // Modul SPMB (Hanya Admin yang boleh verifikasi/ubah status)
    Route::put('/spmb/status/{id}', [SpmbController::class, 'updateStatus'])->middleware('role:admin');

    // Modul Absensi (Guru/Admin yang menyimpan dan merekap)
    Route::post('/absensi/simpan', [AbsensiController::class, 'simpanAbsensi'])->middleware('role:guru,admin');
    Route::get('/absensi/rekap/{kelas}', [AbsensiController::class, 'rekapAbsensi']);
    Route::get('/absensi/export/{kelas}', [AbsensiController::class, 'exportCsv'])->middleware('role:guru,admin');

    // Modul Manajemen Tugas (Guru/Admin yang membuat/menghapus tugas)
    Route::post('/tugas/buat', [TugasController::class, 'buatTugas'])->middleware('role:guru,admin');
    Route::get('/tugas/kelas/{kelas}', [TugasController::class, 'daftarTugas']);
    Route::delete('/tugas/{id}', [TugasController::class, 'hapusTugas'])->middleware('role:guru,admin');

});
