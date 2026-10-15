<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Tampilkan halaman beranda
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Tampilkan halaman pendaftaran
     */
    public function daftar()
    {
        return view('daftar');
    }
}