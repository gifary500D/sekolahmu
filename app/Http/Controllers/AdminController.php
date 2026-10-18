<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spmb;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Absensi;
use App\Models\Roster;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $applicants = Spmb::orderBy('created_at', 'desc')->get();
        return view('admin.spmb.index', compact('applicants'));
    }

    /**
     * Ekspor Data SPMB ke Spreadsheet Excel (.xls) berborder rapi
     */
    public function spmbExport()
    {
        AuditLog::record('EXPORT_SPMB', 'Mengekspor data pendaftar SPMB ke format spreadsheet berborder.');
        
        $applicants = Spmb::orderBy('created_at', 'desc')->get();
        $filename = 'data-spmb-' . date('Y-m-d') . '.xls';
        
        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
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
        $html .= '<div class="subtitle">SMA PEMDA BAHOROK · Tanggal Unduh: ' . date('d F Y, H:i') . ' WIB</div>';
        
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
            $html .= '<td class="center">' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($app->nomor_pendaftaran) . '</td>';
            $html .= '<td>' . htmlspecialchars($app->nama_lengkap) . '</td>';
            $html .= '<td class="center">\'' . htmlspecialchars($app->nisn) . '</td>';
            $html .= '<td class="center">\'' . htmlspecialchars($app->nik) . '</td>';
            $html .= '<td>' . htmlspecialchars($app->asal_sekolah) . '</td>';
            $html .= '<td class="center">' . htmlspecialchars($app->jalur_pendaftaran) . '</td>';
            $html .= '<td class="center">' . strtoupper(htmlspecialchars($app->program)) . '</td>';
            $html .= '<td class="center">' . number_format($app->nilai_rata, 2) . '</td>';
            $html .= '<td class="center"><b>' . htmlspecialchars($app->status) . '</b></td>';
            $html .= '<td class="center">' . $app->created_at->format('d/m/Y H:i') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<br><p><i>* Pernyataan Konfirmasi Keabsahan Data (BRL-16): Laporan ini dihasilkan secara otomatis dan sah oleh Sistem SekolahKu Digital.</i></p>';
        $html .= '</body></html>';
        
        return response($html, 200, $headers);
    }

    /**
     * Update status pendaftar SPMB (Verifikasi / Diterima / Ditolak)
     */
    public function spmbUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Verifikasi,Sedang Diverifikasi,Terverifikasi,Diterima,Ditolak',
            'note' => 'nullable|string|max:255',
        ]);

        $applicant = Spmb::findOrFail($id);
        $oldStatus = $applicant->status;
        $applicant->update([
            'status' => $request->status,
            'note' => $request->note,
        ]);

        AuditLog::record('UPDATE_SPMB_STATUS', 'Memperbarui status pendaftar ' . $applicant->nama_lengkap . ' dari "' . $oldStatus . '" ke "' . $request->status . '".');

        return redirect()->route('admin.spmb.index')->with('success', 'Status pendaftar ' . $applicant->nama_lengkap . ' berhasil diperbarui.');
    }

    /**
     * Manajemen Pengguna Sistem (Admin, Guru, Siswa)
     */
    public function usersIndex()
    {
        $users = User::with('kelas')->orderBy('created_at', 'desc')->get();
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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kelas_id' => $request->kelas_id,
            'password_changed' => true,
        ]);

        AuditLog::record('CREATE_USER', 'Menambahkan pengguna baru: ' . $user->name . ' (' . $user->role . ').');

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
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

        AuditLog::record('DELETE_USER', 'Menghapus pengguna: ' . $name . '.');

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Manajemen Data Siswa Khusus
     */
    public function siswaIndex()
    {
        $siswaList = User::with('kelas')->where('role', 'siswa')->orderBy('created_at', 'desc')->get();
        $kelasList = Kelas::all();
        return view('admin.siswa.index', compact('siswaList', 'kelasList'));
    }

    /**
     * Manajemen Data Guru & Staf Khusus
     */
    public function guruIndex()
    {
        $guruList = User::whereIn('role', ['guru', 'admin'])->orderBy('created_at', 'desc')->get();
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

        $roster = Roster::create($request->all());

        AuditLog::record('CREATE_ROSTER', 'Menambahkan jadwal pelajaran ' . $roster->mata_pelajaran . ' untuk kelas ID ' . $roster->kelas_id);

        return redirect()->route('admin.roster.index')->with('success', 'Jadwal pelajaran (roster) berhasil ditambahkan.');
    }

    public function rosterDelete($id)
    {
        $roster = Roster::findOrFail($id);
        $subject = $roster->mata_pelajaran;
        $roster->delete();

        AuditLog::record('DELETE_ROSTER', 'Menghapus jadwal pelajaran ' . $subject);

        return redirect()->route('admin.roster.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
    }
}
