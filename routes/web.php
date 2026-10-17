<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Halaman Utama / Beranda
Route::get('/', [PageController::class, 'index'])->name('home');

// Halaman Pendaftaran
Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');

// Proses Form Pendaftaran
Route::post('/proses-pendaftaran', [PageController::class, 'prosesPendaftaran'])->name('proses-pendaftaran');

// --- Tambahan Rute Baru ---
// Halaman About (URL bahasa Indonesia)
Route::get('/tentang', [PageController::class, 'about'])->name('about');

// Halaman Facilities (URL bahasa Indonesia)
Route::get('/fasilitas', [PageController::class, 'facilities'])->name('facilities');

// Halaman Teachers (URL bahasa Indonesia)
Route::get('/guru', [PageController::class, 'teachers'])->name('teachers');

// Halaman Berita
Route::get('/berita', [PageController::class, 'berita'])->name('berita');