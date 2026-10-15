<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// use Illuminate\Support\Facades\Route;

Route::get('/halo', function () {
    return 'Halo Suclyn, siap ngoding Laravel 12!';
});

use App\Http\Controllers\PageController;

Route::get('/daftar', [PageController::class, 'daftar'])->name('daftar');
Route::post('/proses-pendaftaran', [PageController::class, 'prosesPendaftaran']);