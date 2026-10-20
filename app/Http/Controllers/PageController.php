<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /** Beranda. Route: / */
    public function index()
    {
        return view('index');
    }

    /** Formulir pendaftaran. Data dikirim ke POST /api/v1/spmb/daftar. */
    public function daftar()
    {
        return view('daftar');
    }

    /** Cek status pendaftaran tanpa login. Memakai GET /api/v1/spmb/status/{nomor}. */
    public function cekStatus()
    {
        return view('cek-status');
    }
}
