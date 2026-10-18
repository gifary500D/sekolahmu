<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\SpmbController;
use App\Http\Controllers\Api\TugasController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------atal
| Rute Publik (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
// Modul SPMB (Calon siswa mendaftar & cek status)
Route::post('/spmb/daftar', [SpmbController::class, 'daftar']);
Route::get('/spmb/status/{nomor}', [SpmbController::class, 'cekStatus']);

/*
|--------------------------------------------------------------------------
| Rute Terproteksi (Memerlukan Autentikasi / Login via Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Modul SPMB (Hanya Admin yang boleh verifikasi/ubah status)
    Route::put('/spmb/status/{id}', [SpmbController::class, 'updateStatus']);

    // Modul Absensi (Guru/Admin yang menyimpan dan merekap)
    Route::post('/absensi/simpan', [AbsensiController::class, 'simpanAbsensi']);
    Route::get('/absensi/rekap/{kelas}', [AbsensiController::class, 'rekapAbsensi']);
    Route::get('/absensi/export/{kelas}', [AbsensiController::class, 'exportCsv']);

    // Modul Manajemen Tugas (Guru yang membuat/menghapus tugas)
    Route::post('/tugas/buat', [TugasController::class, 'buatTugas']);
    Route::get('/tugas/kelas/{kelas}', [TugasController::class, 'daftarTugas']);
    Route::delete('/tugas/{id}', [TugasController::class, 'hapusTugas']);

});
