<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// use Illuminate\Support\Facades\Route;

Route::get('/halo', function () {
    return 'Halo Suclyn, siap ngoding Laravel 12!';
});
