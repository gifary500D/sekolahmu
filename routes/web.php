<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Halaman Utama / Beranda
Route::get('/', [PageController::class, 'index'])->name('home');

// Halaman Pendaftaran
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');

// Proses Form Pendaftaran
Route::post('/proses-pendaftaran', [PageController::class, 'prosesPendaftaran'])->name('proses-pendaftaran');