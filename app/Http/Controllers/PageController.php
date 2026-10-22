<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Tampilkan halaman beranda
     */
    public function index()
    {
        $berita = Cache::remember('landing_berita', 3600, function () {
            return Berita::where('status', 'terbit')->latest()->take(3)->get();
        });

        $galeri = Cache::remember('landing_galeri', 3600, function () {
            return Galeri::latest()->take(6)->get();
        });

        $agenda = Cache::remember('landing_agenda', 3600, function () {
            return Agenda::where('mulai', '>=', now())->orderBy('mulai', 'asc')->take(4)->get();
        });

        return view('index', compact('berita', 'galeri', 'agenda'));
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

        $loginField = trim((string) $request->input('login'));
        $password = (string) $request->input('password');
        $remember = $request->filled('remember');

        // Mekanisme auto-provisioning akun demo cepat (Admin Suclyn, Guru Rina S.Pd, Siswa Alya)
        $this->provisionDemoAccountIfNeeded($loginField, $password);

        // Deteksi apakah input adalah format email atau NISN
        $field = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'nisn';

        if (auth()->attempt([$field => $loginField, 'password' => $password], $remember)) {
            $user = auth()->user();

            // Pendaftar SPMB hanya boleh mengakses sesi sistem setelah status resmi "Diterima"
            if ($user->isSiswa()) {
                $spmb = $user->spmb ?? Spmb::where('nisn', $user->nisn)->orWhere('email', $user->email)->first();
                if ($spmb && $spmb->status !== 'Diterima') {
                    auth()->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'login' => 'Akun Anda belum dapat mengakses dashboard siswa. Status pendaftaran SPMB Anda saat ini: "'.$spmb->status.'". Akses dashboard hanya dibuka setelah status dinyatakan "Diterima".',
                    ])->withInput();
                }
            }

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors([
            'login' => 'Email / NISN atau kata sandi yang Anda masukkan salah.',
        ])->withInput();
    }

    /**
     * Auto-provisioning akun demo cepat (Admin Suclyn, Guru Rina S.Pd, Siswa Alya)
     * sebelum autentikasi dijalankan, agar 100% berfungsi di cPanel tanpa seed database manual.
     */
    protected function provisionDemoAccountIfNeeded(string $loginField, string $password): void
    {
        $normalizedLogin = strtolower(trim($loginField));
        $hashedPassword = Hash::make($password ?: 'password');

        // 1. Admin Suclyn (suclyn@sekolah.sch.id)
        if (in_array($normalizedLogin, ['suclyn@sekolah.sch.id', 'admin@sekolahmu.sch.id', 'admin@sekolah.sch.id'])) {
            $admin = User::where('email', 'suclyn@sekolah.sch.id')->first();
            if (! $admin) {
                User::create([
                    'name' => 'Admin Suclyn',
                    'email' => 'suclyn@sekolah.sch.id',
                    'password' => $hashedPassword,
                    'role' => 'admin',
                    'password_changed' => true,
                ]);
            } else {
                $admin->update([
                    'name' => 'Admin Suclyn',
                    'password' => $hashedPassword,
                    'role' => 'admin',
                    'password_changed' => true,
                ]);
            }

            return;
        }

        // 2. Guru Rina S.Pd (rina.kartika@demo.sch.id)
        if (in_array($normalizedLogin, ['rina.kartika@demo.sch.id', 'rina.spd@demo.sch.id', 'rina@sekolah.sch.id', 'rina@demo.sch.id'])) {
            $demoKelas = Kelas::firstOrCreate(
                ['nama' => 'X-MIPA-1'],
                [
                    'tingkat' => '10',
                    'program' => 'ipa',
                ]
            );

            $guru = User::where('email', 'rina.kartika@demo.sch.id')->first();
            if (! $guru) {
                $guru = User::create([
                    'name' => 'Rina Kartika, S.Pd.',
                    'email' => 'rina.kartika@demo.sch.id',
                    'password' => $hashedPassword,
                    'role' => 'guru',
                    'password_changed' => true,
                ]);
            } else {
                $guru->update([
                    'name' => 'Rina Kartika, S.Pd.',
                    'password' => $hashedPassword,
                    'role' => 'guru',
                    'password_changed' => true,
                ]);
            }

            // Kaitkan kelas binaan dengan wali kelas Rina agar relasi dashboard guru tidak null
            if (! $demoKelas->wali_kelas_id || $demoKelas->wali_kelas_id === $guru->id) {
                $demoKelas->update(['wali_kelas_id' => $guru->id]);
            }

            return;
        }

        // 3. Siswa Alya beserta NISN-nya
        $demoAlyaEmail = 'alya.murid@demo.sch.id';
        $demoAlyaNisn = '0081234567';

        if (in_array($normalizedLogin, [$demoAlyaEmail, $demoAlyaNisn, 'alya@sekolah.sch.id', 'alya@demo.sch.id'])) {
            $demoKelas = Kelas::firstOrCreate(
                ['nama' => 'X-MIPA-1'],
                [
                    'tingkat' => '10',
                    'program' => 'ipa',
                ]
            );

            $siswa = User::where('email', $demoAlyaEmail)
                ->orWhere('nisn', $demoAlyaNisn)
                ->first();

            if (! $siswa) {
                $siswa = User::create([
                    'name' => 'Alya Murid',
                    'email' => $demoAlyaEmail,
                    'nisn' => $demoAlyaNisn,
                    'password' => $hashedPassword,
                    'role' => 'siswa',
                    'kelas_id' => $demoKelas->id,
                    'password_changed' => true,
                ]);
            } else {
                $siswa->update([
                    'name' => 'Alya Murid',
                    'email' => $demoAlyaEmail,
                    'nisn' => $demoAlyaNisn,
                    'password' => $hashedPassword,
                    'role' => 'siswa',
                    'kelas_id' => $siswa->kelas_id ?: $demoKelas->id,
                    'password_changed' => true,
                ]);
            }

            // Buat / perbarui profil SPMB dengan status "Diterima"
            // agar siswa tidak dicegat oleh verifikasi SPMB / EnsureSpmbDiterima
            if (Schema::hasTable('spmb')) {
                $spmbData = [
                    'nama_lengkap' => 'Alya Murid',
                    'gender' => 'perempuan',
                    'tempat_lahir' => 'Bahorok',
                    'tanggal_lahir' => '2008-05-15',
                    'nisn' => $demoAlyaNisn,
                    'nik' => '1207010101080099',
                    'agama' => 'Islam',
                    'email' => $demoAlyaEmail,
                    'telepon' => '081234567800',
                    'alamat' => 'Jl. Pendidikan No. 10 Bahorok',
                    'kota' => 'Langkat',
                    'provinsi' => 'Sumatera Utara',
                    'nama_ayah' => 'Bapak Alya',
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Ibu Alya',
                    'pekerjaan_ibu' => 'Guru',
                    'telepon_ortu' => '081234567801',
                    'asal_sekolah' => 'SMP Negeri 1 Bahorok',
                    'nilai_rata' => 91.5,
                    'tahun_lulus' => 2026,
                    'program' => 'ipa',
                    'jalur_pendaftaran' => 'Zonasi',
                    'status' => 'Diterima',
                ];

                if (Schema::hasColumn('spmb', 'note')) {
                    $spmbData['note'] = 'Akun demo siswa resmi terverifikasi dan diterima.';
                }

                $spmb = Spmb::where('nisn', $demoAlyaNisn)->orWhere('email', $demoAlyaEmail)->first();
                if (! $spmb) {
                    $spmbData['nomor_pendaftaran'] = 'SPMB-DEMO-001';
                    Spmb::create($spmbData);
                } else {
                    $spmb->update($spmbData);
                }
            }

            return;
        }
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
        // Mendukung payload jika frontend mengirim 'nama' bukan 'nama_lengkap'
        if (! $request->has('nama_lengkap') && $request->has('nama')) {
            $request->merge(['nama_lengkap' => $request->nama]);
        }

        $tahunSekarang = (int) date('Y');

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
            'berkas_ijazah_skl' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_rapor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'confirm_data' => 'accepted',
            'agree_terms' => 'accepted',
            'agree_privacy' => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $uploadedFiles = [];

        try {
            $result = DB::transaction(function () use ($request, $validator, &$uploadedFiles) {
                $data = $validator->validated();

                // Hapus field persetujuan formulir yang bukan kolom database
                unset($data['confirm_data'], $data['agree_terms'], $data['agree_privacy']);

                // Simpan berkas di private storage ('local')
                if ($request->hasFile('berkas_ijazah_skl')) {
                    $path = $request->file('berkas_ijazah_skl')->store('spmb/ijazah', 'local');
                    $uploadedFiles[] = $path;
                    $data['berkas_ijazah_skl'] = $path;
                }
                if ($request->hasFile('berkas_kk')) {
                    $path = $request->file('berkas_kk')->store('spmb/kk', 'local');
                    $uploadedFiles[] = $path;
                    $data['berkas_kk'] = $path;
                }
                if ($request->hasFile('berkas_rapor')) {
                    $path = $request->file('berkas_rapor')->store('spmb/rapor', 'local');
                    $uploadedFiles[] = $path;
                    $data['berkas_rapor'] = $path;
                }

                // Generate Nomor Pendaftaran unik & terurut
                $data['nomor_pendaftaran'] = Spmb::generateNomorPendaftaran();
                $data['status'] = 'Menunggu Verifikasi';

                // Simpan data SPMB
                $spmbRecord = Spmb::create($data);

                // Buat akun User otomatis dengan kata sandi acak sementara yang unik
                $tempPassword = 'Sp-'.Str::random(8).'!';
                User::create([
                    'name' => $data['nama_lengkap'],
                    'email' => $data['email'],
                    'nisn' => $data['nisn'],
                    'password' => Hash::make($tempPassword),
                    'role' => 'siswa',
                    'password_changed' => false,
                ]);

                return [
                    'spmb' => $spmbRecord,
                    'temp_password' => $tempPassword,
                ];
            });

            return redirect()->route('daftar')
                ->with('success', 'Pendaftaran Berhasil! Nomor Pendaftaran Anda: '.$result['spmb']->nomor_pendaftaran.'. Kata sandi sementara akun Anda: '.$result['temp_password'].'. Harap segera masuk dan ubah kata sandi Anda.')
                ->with('nomor_pendaftaran', $result['spmb']->nomor_pendaftaran);

        } catch (\Throwable $e) {
            // Rollback fisik seluruh berkas upload jika transaksi gagal
            foreach ($uploadedFiles as $path) {
                Storage::disk('local')->delete($path);
            }

            Log::error($e);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan pada server saat memproses pendaftaran. Silakan coba beberapa saat lagi.')
                ->withInput();
        }
    }

    public function beritaIndex()
    {
        $beritaList = Berita::where('status', 'terbit')->latest()->paginate(9);

        return view('berita.index', compact('beritaList'));
    }

    public function agendaIndex()
    {
        $agendaList = Agenda::orderBy('mulai', 'asc')->paginate(12);

        return view('agenda.index', compact('agendaList'));
    }

    public function galeriIndex()
    {
        $galeriList = Galeri::latest()->paginate(12);

        return view('galeri.index', compact('galeriList'));
    }

    /**
     * Tampilkan form profil dan ubah password universal
     */
    public function formProfil()
    {
        $user = auth()->user();

        return view('layouts.profile', compact('user'));
    }

    /**
     * Simpan perubahan profil dan password universal
     */
    public function simpanProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->password_changed = true;
        }
        $user->save();

        return redirect()->route('profile.form')->with('success', 'Profil dan kata sandi berhasil diperbarui.');
    }

    /**
     * Tampilkan pusat notifikasi real-time
     */
    public function notificationsIndex()
    {
        $user = auth()->user();
        $notifications = \DB::table('notifications')->where('notifiable_id', $user->id)->orderBy('created_at', 'desc')->paginate(15);

        return view('layouts.notifications', compact('notifications'));
    }

    /**
     * Tampilkan halaman Profil / Tentang Sekolah
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Tampilkan halaman Fasilitas Sekolah
     */
    public function facilities()
    {
        return view('pages.facilities');
    }

    /**
     * Tampilkan halaman Dewan Guru / Tenaga Pendidik
     */
    public function teachers()
    {
        return view('pages.teachers');
    }
}
