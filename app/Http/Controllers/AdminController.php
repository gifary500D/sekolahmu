<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Berita;
use App\Models\Kelas;
use App\Models\Roster;
use App\Models\Spmb;
use App\Models\User;
use App\Support\Teks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard utama administrator
     */
    public function dashboard()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalKelas = Kelas::count();
        $totalSpmb = Spmb::count();
        $pendingSpmb = Spmb::where('status', 'Menunggu Verifikasi')->count();
        $acceptedSpmb = Spmb::where('status', 'Diterima')->count();

        $recentSpmb = Spmb::orderBy('created_at', 'desc')->take(5)->get();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalAdmin', 'totalKelas', 'totalSpmb', 'pendingSpmb', 'acceptedSpmb', 'recentSpmb', 'recentUsers'
        ));
    }

    /**
     * Manajemen Pendaftar SPMB
     */
    public function spmbIndex()
    {
        $applicants = Spmb::with('user.kelas')->orderBy('created_at', 'desc')->paginate(15);
        $kelasList = Kelas::orderBy('tingkat')->orderBy('nama')->get();

        return view('admin.spmb.index', compact('applicants', 'kelasList'));
    }

    /**
     * Ekspor Data SPMB ke Spreadsheet Excel (.xls) berborder rapi
     */
    public function spmbExport()
    {
        AuditLog::record('EXPORT_SPMB', 'Mengekspor data pendaftar SPMB ke format spreadsheet berborder.');

        $applicants = Spmb::orderBy('created_at', 'desc')->get();
        $filename = 'data-spmb-'.date('Y-m-d').'.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $html = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        $html .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $html .= '<style>
            table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
            th { background-color: #1e3a8a; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #000000; text-align: center; }
            td { padding: 8px; border: 1px solid #94a3b8; }
            .center { text-align: center; }
            .title { font-size: 16pt; font-weight: bold; text-align: center; margin-bottom: 5px; }
            .subtitle { font-size: 10pt; text-align: center; color: #475569; margin-bottom: 20px; }
        </style></head><body>';

        $html .= '<div class="title">LAPORAN DATA PENDAFTARAN SPMB</div>';
        $html .= '<div class="subtitle">SMA/SMK PEMDA BAHOROK · Tanggal Unduh: '.date('d F Y, H:i').' WIB</div>';

        $html .= '<table>';
        $html .= '<thead><tr>
            <th>No</th>
            <th>No. Pendaftaran</th>
            <th>Nama Lengkap</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Asal Sekolah</th>
            <th>Jalur</th>
            <th>Program</th>
            <th>Nilai Rata-rata</th>
            <th>Status Seleksi</th>
            <th>Tanggal Daftar</th>
        </tr></thead><tbody>';

        foreach ($applicants as $index => $app) {
            $html .= '<tr>';
            $html .= '<td class="center">'.($index + 1).'</td>';
            $html .= '<td>'.htmlspecialchars(Teks::amankanFormulaCsv($app->nomor_pendaftaran)).'</td>';
            $html .= '<td>'.htmlspecialchars(Teks::amankanFormulaCsv($app->nama_lengkap)).'</td>';
            $html .= '<td class="center">\''.htmlspecialchars(Teks::amankanFormulaCsv($app->nisn)).'</td>';
            $html .= '<td class="center">\''.htmlspecialchars(Teks::amankanFormulaCsv($app->nik)).'</td>';
            $html .= '<td>'.htmlspecialchars(Teks::amankanFormulaCsv($app->asal_sekolah)).'</td>';
            $html .= '<td class="center">'.htmlspecialchars(Teks::amankanFormulaCsv($app->jalur_pendaftaran)).'</td>';
            $html .= '<td class="center">'.strtoupper(htmlspecialchars(Teks::amankanFormulaCsv($app->program))).'</td>';
            $html .= '<td class="center">'.number_format($app->nilai_rata, 2).'</td>';
            $html .= '<td class="center"><b>'.htmlspecialchars(Teks::amankanFormulaCsv($app->status)).'</b></td>';
            $html .= '<td class="center">'.$app->created_at->format('d/m/Y H:i').'</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<br><p><i>* Pernyataan Konfirmasi Keabsahan Data (BRL-16): Laporan ini dihasilkan secara otomatis dan sah oleh Sistem SekolahKu Digital.</i></p>';
        $html .= '</body></html>';

        return response($html, 200, $headers);
    }

    /**
     * Unduh berkas fisik SPMB dari storage privat ('local')
     */
    public function spmbDownloadBerkas($id, $jenis)
    {
        $applicant = Spmb::findOrFail($id);

        $allowed = [
            'ijazah' => 'berkas_ijazah_skl',
            'kk' => 'berkas_kk',
            'rapor' => 'berkas_rapor',
        ];

        if (! isset($allowed[$jenis])) {
            abort(404, 'Jenis berkas tidak valid.');
        }

        $field = $allowed[$jenis];
        $path = $applicant->{$field};

        if (! $path) {
            abort(404, 'Berkas belum diunggah oleh pendaftar.');
        }

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        }

        abort(404, 'File berkas fisik tidak ditemukan di server.');
    }

    /**
     * Update status pendaftar SPMB (Verifikasi / Diterima / Ditolak)
     */
    public function spmbUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Verifikasi,Sedang Diverifikasi,Terverifikasi,Diterima,Ditolak',
            'note' => 'nullable|string|max:255',
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $applicant = Spmb::findOrFail($id);
        $oldStatus = $applicant->status;
        $applicant->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        $tempPassword = null;

        // Sinkronisasi akun User saat status "Diterima"
        if ($request->status === 'Diterima') {
            $user = User::where('nisn', $applicant->nisn)
                ->orWhere('email', $applicant->email)
                ->first();

            if (! $user) {
                $tempPassword = 'Sp-'.Str::random(8).'!';
                $user = User::create([
                    'name' => $applicant->nama_lengkap,
                    'email' => $applicant->email,
                    'nisn' => $applicant->nisn,
                    'password' => Hash::make($tempPassword),
                    'role' => 'siswa',
                    'kelas_id' => $request->kelas_id,
                    'password_changed' => false,
                ]);
            } else {
                $updateData = [
                    'name' => $applicant->nama_lengkap,
                    'email' => $applicant->email,
                    'nisn' => $applicant->nisn,
                    'role' => 'siswa',
                ];
                if ($request->filled('kelas_id')) {
                    $updateData['kelas_id'] = $request->kelas_id;
                }
                $user->update($updateData);
            }
        }

        AuditLog::record('UPDATE_SPMB_STATUS', 'Memperbarui status pendaftar '.$applicant->nama_lengkap.' dari "'.$oldStatus.'" ke "'.$request->status.'".');

        $msg = 'Status pendaftar '.$applicant->nama_lengkap.' berhasil diperbarui menjadi '.$request->status.'.';
        if ($tempPassword) {
            $msg .= ' Akun siswa berhasil disinkronkan dengan kata sandi sementara: '.$tempPassword;
        }

        return redirect()->route('admin.spmb.index')->with('success', $msg);
    }

    /**
     * Tetapkan atau ubah rombongan belajar (kelas) siswa
     */
    public function siswaUpdateKelas(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'nullable|exists:kelas,id',
        ]);

        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->update([
            'kelas_id' => $request->kelas_id,
        ]);

        $kelasNama = $siswa->kelas ? $siswa->kelas->nama : 'Belum Ditentukan';
        AuditLog::record('UPDATE_SISWA_KELAS', 'Menetapkan kelas '.$kelasNama.' untuk siswa '.$siswa->name.'.');

        return redirect()->back()->with('success', 'Kelas untuk siswa '.$siswa->name.' berhasil diperbarui menjadi '.$kelasNama.'.');
    }

    /**
     * Reset kata sandi sementara untuk siswa
     */
    public function resetSiswaPassword($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $newTempPassword = 'Sp-'.Str::random(8).'!';

        $siswa->update([
            'password' => Hash::make($newTempPassword),
            'password_changed' => false,
        ]);

        AuditLog::record('RESET_PASSWORD_SISWA', 'Mereset kata sandi sementara untuk siswa: '.$siswa->name.'.');

        return redirect()->back()->with('success', 'Kata sandi sementara untuk siswa '.$siswa->name.' berhasil direset: '.$newTempPassword.'. Siswa wajib mengganti kata sandi ini saat pertama kali masuk.');
    }

    /**
     * Manajemen Pengguna Sistem (Admin, Guru, Siswa)
     */
    public function usersIndex()
    {
        $users = User::with('kelas')->orderBy('created_at', 'desc')->paginate(20);
        $kelasList = Kelas::all();

        return view('admin.users.index', compact('users', 'kelasList'));
    }

    /**
     * Simpan pengguna baru (Guru / Admin)
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,guru,siswa',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nisn' => 'nullable|string|unique:users,nisn',
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nisn' => $request->nisn,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'kelas_id' => $request->kelas_id,
                'password_changed' => true,
            ]);

            AuditLog::record('CREATE_USER', 'Menambahkan pengguna baru: '.$user->name.' ('.$user->role.').');

            return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
        });
    }

    /**
     * Perbarui data pengguna (termasuk penempatan kelas siswa)
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,guru,siswa',
            'kelas_id' => 'nullable|exists:kelas,id',
            'nisn' => 'nullable|string|unique:users,nisn,'.$user->id,
        ]);

        return DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nisn' => $request->nisn,
                'role' => $request->role,
                'kelas_id' => $request->kelas_id,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);

            AuditLog::record('UPDATE_USER', 'Memperbarui data pengguna: '.$user->name);

            return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
        });
    }

    /**
     * Hapus pengguna
     */
    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        AuditLog::record('DELETE_USER', 'Menghapus pengguna: '.$name.'.');

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Manajemen Data Siswa Khusus
     */
    public function siswaIndex()
    {
        $siswaList = User::with('kelas')->where('role', 'siswa')->orderBy('created_at', 'desc')->paginate(20);
        $kelasList = Kelas::all();

        return view('admin.siswa.index', compact('siswaList', 'kelasList'));
    }

    /**
     * Manajemen Data Guru & Staf Khusus
     */
    public function guruIndex()
    {
        $guruList = User::whereIn('role', ['guru', 'admin'])->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.guru.index', compact('guruList'));
    }

    /**
     * Manajemen Roster / Jadwal Pelajaran
     */
    public function rosterIndex()
    {
        $rosters = Roster::with(['kelas', 'guru'])->orderBy('kelas_id')->orderBy('hari')->get();
        $kelasList = Kelas::all();
        $guruList = User::where('role', 'guru')->get();

        return view('admin.roster.index', compact('rosters', 'kelasList', 'guruList'));
    }

    public function rosterStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran' => 'required|string|max:255',
            'guru_id' => 'nullable|exists:users,id',
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $roster = Roster::create($request->only([
            'kelas_id', 'mata_pelajaran', 'guru_id', 'hari', 'jam_mulai', 'jam_selesai', 'tahun_ajaran', 'semester',
        ]));

        AuditLog::record('CREATE_ROSTER', 'Menambahkan jadwal pelajaran '.$roster->mata_pelajaran.' untuk kelas ID '.$roster->kelas_id);

        return redirect()->route('admin.roster.index')->with('success', 'Jadwal pelajaran (roster) berhasil ditambahkan.');
    }

    public function rosterDelete($id)
    {
        $roster = Roster::findOrFail($id);
        $subject = $roster->mata_pelajaran;
        $roster->delete();

        AuditLog::record('DELETE_ROSTER', 'Menghapus jadwal pelajaran '.$subject);

        return redirect()->route('admin.roster.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }

    /**
     * CRUD Master Kelas
     */
    public function kelasIndex()
    {
        $kelasList = Kelas::with('waliKelas')->withCount('siswa')->get();
        $guruList = User::where('role', 'guru')->get();

        return view('admin.kelas.index', compact('kelasList', 'guruList'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama',
            'tingkat' => 'required|in:10,11,12',
            'program' => 'required|in:ipa,ips,bahasa',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas = Kelas::create($request->only(['nama', 'tingkat', 'program', 'wali_kelas_id']));
        AuditLog::record('CREATE_KELAS', 'Menambahkan kelas baru: '.$kelas->nama);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama,'.$kelas->id,
            'tingkat' => 'required|in:10,11,12',
            'program' => 'required|in:ipa,ips,bahasa',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $kelas->update($request->only(['nama', 'tingkat', 'program', 'wali_kelas_id']));
        AuditLog::record('UPDATE_KELAS', 'Memperbarui kelas: '.$kelas->nama);

        return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function kelasDelete($id)
    {
        $kelas = Kelas::findOrFail($id);
        $nama = $kelas->nama;
        $kelas->delete();

        AuditLog::record('DELETE_KELAS', 'Menghapus kelas: '.$nama);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    /**
     * CMS Konten Portal (Berita)
     */
    public function cmsIndex()
    {
        $beritaList = Berita::latest()->get();

        return view('admin.cms.index', compact('beritaList'));
    }

    public function cmsBeritaStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'konten' => 'required|string',
            'status' => 'required|in:terbit,arsip',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('berita', 'public');
        }

        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => Berita::slugUnik($request->judul),
            'ringkasan' => Str::limit(strip_tags($request->konten), 200),
            'konten' => $request->konten,
            'status' => $request->status === 'arsip' ? 'draf' : 'terbit',
            'gambar_path' => $gambarPath,
            'diterbitkan_pada' => now(),
            'penulis_id' => auth()->id(),
        ]);

        AuditLog::record('CREATE_BERITA', 'Mempublikasikan berita portal: '.$berita->judul);

        return redirect()->route('admin.cms.index')->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function cmsBeritaDelete($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        AuditLog::record('DELETE_BERITA', 'Menghapus berita portal.');

        return redirect()->route('admin.cms.index')->with('success', 'Berita berhasil dihapus.');
    }
}
