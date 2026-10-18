<?php

namespace App\Http\Controllers;

use App\Models\Spmb;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Tampilkan halaman login
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Tampilkan halaman pendaftaran
     */
    public function daftar()
    {
        return view('daftar');
    }

    /**
     * Proses login user (Mendukung Email atau NISN)
     */
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ], [
            'login.required' => 'Email atau NISN wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');
        $remember = $request->filled('remember');

        // Deteksi apakah input adalah format email atau NISN
        $field = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'nisn';

        if (auth()->attempt([$field => $loginField, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors([
            'login' => 'Email / NISN atau kata sandi yang Anda masukkan salah.',
        ])->withInput();
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Proses pendaftaran siswa baru (Otomatis mendaftarkan akun User Siswa dengan NISN)
     */
    public function prosesPendaftaran(Request $request)
    {
        $tahunSekarang = date('Y');
        
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'gender' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nisn' => 'required|digits:10|unique:spmb,nisn|unique:users,nisn',
            'nik' => 'required|digits:16|unique:spmb,nik',
            'agama' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'nama_ayah' => 'required|string|max:255',
            'pekerjaan_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ibu' => 'required|string|max:255',
            'telepon_ortu' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'nilai_rata' => 'required|numeric|min:0|max:100',
            'tahun_lulus' => "required|numeric|min:2020|max:{$tahunSekarang}",
            'program' => 'required|in:ipa,ips,bahasa',
            'jalur_pendaftaran' => 'required|in:Zonasi,Afirmasi,Prestasi,Perpindahan Tugas',
            'confirm_data' => 'accepted',
            'agree_terms' => 'accepted',
            'agree_privacy' => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $validator->validated();
            
            // Remove boolean fields that are not in database
            unset($data['confirm_data'], $data['agree_terms'], $data['agree_privacy']);

            // Generate Nomor Pendaftaran
            $tahunDaftar = date('Y');
            $lastSpmb = Spmb::orderBy('id', 'desc')->first();
            $nextId = $lastSpmb ? $lastSpmb->id + 1 : 1;
            $data['nomor_pendaftaran'] = 'SPMB-'.$tahunDaftar.'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $data['status'] = 'Menunggu Verifikasi';

            // Simpan data SPMB
            $spmb = Spmb::create($data);

            // Buat akun User otomatis untuk siswa (agar bisa login dengan NISN dan password default 'password')
            User::create([
                'name' => $data['nama_lengkap'],
                'email' => $data['email'],
                'nisn' => $data['nisn'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            return redirect()->back()->with('success', 'Pendaftaran Berhasil! Nomor Pendaftaran Anda: ' . $spmb->nomor_pendaftaran . '. Anda sekarang dapat login menggunakan NISN Anda dan password default: password');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
