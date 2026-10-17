<?php

// Controller untuk menangani halaman-halaman statis

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Tampilkan halaman beranda
     * Route: /
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Tampilkan halaman pendaftaran
     * Route: /daftar
     */
    public function daftar()
    {
        return view('daftar');
    }

    /**
     * Proses form pendaftaran
     * Route: POST /proses-pendaftaran
     * 
     * Catatan: Untuk tahap ini, form hanya ditampilkan di frontend
     * Bagian backend akan ditambahkan nanti jika diperlukan
     */
    public function prosesPendaftaran(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            // Data Pribadi
            'nama' => 'required|string|max:255',
            'gender' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nisn' => 'required|digits:10',
            'agama' => 'required|string',
            
            // Data Kontak
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            
            // Data Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'telepon_ortu' => 'required|string|max:20',
            
            // Data Pendidikan
            'asal_sekolah' => 'required|string|max:255',
            'nilai_rata' => 'required|numeric|min:0|max:100',
            'tahun_lulus' => 'required|numeric|min:2020|max:2024',
            'program' => 'required|in:ipa,ips,bahasa',
            
            // Persetujuan
            'confirm_data' => 'required',
            'agree_terms' => 'required',
            'agree_privacy' => 'required',
        ]);

        // Simulasi penyimpanan data
        return redirect('/')
            ->with('success', 'Terima kasih! Data pendaftaran Anda telah diterima.');
    }

    /**
     * Tampilkan halaman About
     * Route: /about
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Tampilkan halaman Facilities
     * Route: /facilities
     */
    public function facilities()
    {
        return view('pages.facilities');
    }

    /**
     * Tampilkan halaman Teachers
     * Route: /teachers
     */
    public function teachers()
    {
        return view('pages.teachers');
    }

    /**
     * Tampilkan halaman Berita
     * Route: /berita
     */
    public function berita()
    {
        return view('pages.berita');
    }
}