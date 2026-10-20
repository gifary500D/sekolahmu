<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Halaman publik. Pendaftaran dan cek status memanggil REST API (/api/v1/spmb/...).
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');
Route::get('/cek-status', [PageController::class, 'cekStatus'])->name('cek-status');
