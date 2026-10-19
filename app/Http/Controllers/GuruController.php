<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard guru (Real-time data)
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $tugasList = Tugas::where('guru_id', $user->id)->orderBy('tenggat', 'asc')->get();
        $totalSiswa = User::where('role', 'siswa')->count();
        $kelasBinaan = Kelas::with('siswa')->get();

        return view('guru.dashboard', compact('tugasList', 'totalSiswa', 'kelasBinaan'));
    }

    /**
     * Daftar tugas yang dibuat guru
     */
    public function tugasIndex()
    {
        $user = auth()->user();
        $tugasList = Tugas::where('guru_id', $user->id)->with('kelas')->orderBy('tenggat', 'desc')->get();

        return view('guru.tugas.index', compact('tugasList'));
    }

    /**
     * Form buat tugas baru
     */
    public function tugasCreate()
    {
        $kelasList = Kelas::all();
        return view('guru.tugas.create', compact('kelasList'));
    }

    /**
     * Simpan tugas baru
     */
    public function tugasStore(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'judul' => 'required|string|max:150',
            'mata_pelajaran' => 'required|string|max:100',
            'kelas_id' => 'required|exists:kelas,id',
            'tenggat' => 'required|date',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'deskripsi' => 'nullable|string',
        ]);

        $tugas = Tugas::create([
            'judul' => $request->judul,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas_id' => $request->kelas_id,
            'guru_id' => $user->id,
            'tenggat' => $request->tenggat,
            'prioritas' => $request->prioritas,
            'deskripsi' => $request->deskripsi,
        ]);

        AuditLog::record('CREATE_TUGAS', 'Guru membuat tugas baru: ' . $tugas->judul . ' (' . $tugas->mata_pelajaran . ').');

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dibuat dan dibagikan ke siswa.');
    }

    /**
     * Lihat pengumpulan tugas oleh siswa
     */
    public function tugasSubmissions($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);
        
        // Ambil siswa di kelas terkait dan pengumpulannya
        $kelasId = $tugas->kelas_id;
        $siswaList = User::where('role', 'siswa')->where('kelas_id', $kelasId)->get();
        
        $submissions = TugasSiswa::where('tugas_id', $id)->get()->keyBy('siswa_id');

        return view('guru.tugas.submissions', compact('tugas', 'siswaList', 'submissions'));
    }

    /**
     * Berikan nilai dan catatan untuk pengumpulan tugas siswa
     */
    public function beriNilai(Request $request, $submissionId)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string|max:500',
        ]);

        $submission = TugasSiswa::with(['tugas', 'siswa'])->findOrFail($submissionId);
        $submission->update([
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'status' => 'selesai',
        ]);

        AuditLog::record('GRADE_TUGAS', 'Guru memberi nilai ' . $request->nilai . ' untuk tugas ' . $submission->tugas?->judul . ' siswa ' . $submission->siswa?->name);

        return redirect()->back()->with('success', 'Nilai dan catatan evaluasi berhasil disimpan.');
    }

    /**
     * Unduh berkas tugas siswa secara aman melalui controller
     */
    public function downloadBerkas($submissionId)
    {
        $submission = TugasSiswa::findOrFail($submissionId);

        if (! $submission->file_path || ! Storage::disk('public')->exists($submission->file_path)) {
            return redirect()->back()->with('error', 'Berkas lampiran tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($submission->file_path);
    }

    /**
     * Kelola absensi (Pilih kelas untuk menampilkan daftar siswa)
     */
    public function absensiIndex(Request $request)
    {
        $kelasList = Kelas::all();
        $selectedKelasId = $request->input('kelas_id', $kelasList->first()?->id);
        
        $selectedKelas = Kelas::find($selectedKelasId);
        $siswaList = $selectedKelas ? User::where('role', 'siswa')->where('kelas_id', $selectedKelas->id)->get() : collect();

        $absensiList = Absensi::orderBy('tanggal', 'desc')->get();

        return view('guru.absensi', compact('absensiList', 'kelasList', 'selectedKelas', 'siswaList', 'selectedKelasId'));
    }

    /**
     * Simpan absensi per siswa untuk kelas tertentu
     */
    public function absensiStore(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'tanggal' => 'required|date',
            'status_kehadiran' => 'required|array',
        ]);

        Absensi::updateOrCreate(
            [
                'kelas' => $request->kelas,
                'tanggal' => $request->tanggal,
            ],
            [
                'data_kehadiran' => $request->input('status_kehadiran'), // [siswa_id => 'Hadir'|'Sakit'|'Izin'|'Alpa']
            ]
        );

        AuditLog::record('SAVE_ABSENSI', 'Guru menyimpan absensi kelas ' . $request->kelas . ' tanggal ' . $request->tanggal);

        return redirect()->route('guru.absensi')->with('success', 'Absensi harian untuk kelas ' . $request->kelas . ' berhasil disimpan.');
    }

    /**
     * Ekspor Rekapitulasi Absensi ke Spreadsheet Excel (.xls) berborder rapi
     */
    public function exportAbsensi(Request $request)
    {
        $kelasName = $request->input('kelas', 'Semua Kelas');
        AuditLog::record('EXPORT_ABSENSI', 'Guru mengekspor rekapitulasi absensi kelas: ' . $kelasName);

        $absensiRecords = Absensi::when($request->filled('kelas'), function($q) use ($request) {
            $q->where('kelas', $request->kelas);
        })->orderBy('tanggal', 'desc')->get();

        $filename = 'rekap-absensi-' . \Illuminate\Support\Str::slug($kelasName) . '-' . date('Y-m-d') . '.xls';

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
            th { background-color: #047857; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #000000; text-align: center; }
            td { padding: 8px; border: 1px solid #94a3b8; }
            .center { text-align: center; }
            .title { font-size: 16pt; font-weight: bold; text-align: center; margin-bottom: 5px; }
            .subtitle { font-size: 10pt; text-align: center; color: #475569; margin-bottom: 20px; }
        </style></head><body>';

        $html .= '<div class="title">REKAPITULASI KEHADIRAN SISWA - KELAS ' . strtoupper(htmlspecialchars($kelasName)) . '</div>';
        $html .= '<div class="subtitle">SMA PEMDA BAHOROK · Tanggal Ekspor: ' . date('d F Y, H:i') . ' WIB</div>';

        $html .= '<table>';
        $html .= '<thead><tr>
            <th>No</th>
            <th>Tanggal Absensi</th>
            <th>Kelas</th>
            <th>Nama Siswa</th>
            <th>Status Kehadiran</th>
        </tr></thead><tbody>';

        $no = 1;
        $absensiRecords = $absensiRecords->all();
        
        // Ambil semua ID siswa yang ada di data kehadiran untuk batch loading
        $allSiswaIds = [];
        foreach ($absensiRecords as $rec) {
            $allSiswaIds = array_merge($allSiswaIds, array_keys($rec->data_kehadiran ?? []));
        }
        $siswaCache = User::whereIn('id', array_unique($allSiswaIds))->get()->keyBy('id');

        foreach ($absensiRecords as $rec) {
            $dataKehadiran = $rec->data_kehadiran ?? [];
            foreach ($dataKehadiran as $siswaId => $status) {
                $siswa = $siswaCache->get($siswaId);
                $siswaName = $siswa ? $siswa->name : 'Siswa ID #' . $siswaId;
                
                $html .= '<tr>';
                $html .= '<td class="center">' . $no++ . '</td>';
                $html .= '<td class="center">' . htmlspecialchars($rec->tanggal) . '</td>';
                $html .= '<td class="center">' . htmlspecialchars($rec->kelas) . '</td>';
                $html .= '<td>' . htmlspecialchars($siswaName) . '</td>';
                $html .= '<td class="center"><b>' . htmlspecialchars($status) . '</b></td>';
                $html .= '</tr>';
            }
        }

        $html .= '</tbody></table>';
        $html .= '<br><p><i>* Pernyataan Konfirmasi Keabsahan Data (BRL-16): Rekapitulasi absensi sah diverifikasi oleh wali kelas / guru pengampu.</i></p>';
        $html .= '</body></html>';

        return response($html, 200, $headers);
    }

    /**
     * Ekspor Rekap Nilai Tugas ke Spreadsheet Excel (.xls) berborder rapi
     */
    public function exportTugas($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);
        AuditLog::record('EXPORT_TUGAS', 'Guru mengekspor nilai tugas: ' . $tugas->judul . ' (' . $tugas->mata_pelajaran . ')');

        $submissions = TugasSiswa::with('siswa')->where('tugas_id', $id)->get();
        $filename = 'nilai-tugas-' . \Illuminate\Support\Str::slug($tugas->judul) . '-' . date('Y-m-d') . '.xls';

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

        $html .= '<div class="title">DAFTAR NILAI & EVALUASI TUGAS SISWA</div>';
        $html .= '<div class="subtitle">' . strtoupper(htmlspecialchars($tugas->judul)) . ' · MAPEL: ' . strtoupper(htmlspecialchars($tugas->mata_pelajaran)) . ' · KELAS: ' . strtoupper(htmlspecialchars($tugas->kelas?->nama ?? '-')) . '</div>';

        $html .= '<table>';
        $html .= '<thead><tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>NISN</th>
            <th>Status Pengerjaan</th>
            <th>Nilai (0-100)</th>
            <th>Catatan Evaluasi Guru</th>
            <th>Waktu Pengumpulan</th>
        </tr></thead><tbody>';

        foreach ($submissions as $index => $sub) {
            $html .= '<tr>';
            $html .= '<td class="center">' . ($index + 1) . '</td>';
            $html .= '<td>' . htmlspecialchars($sub->siswa?->name ?? '-') . '</td>';
            $html .= '<td class="center">\'' . htmlspecialchars($sub->siswa?->nisn ?? '-') . '</td>';
            $html .= '<td class="center">' . ($sub->status === 'selesai' ? 'Sudah Dikumpulkan' : 'Belum') . '</td>';
            $html .= '<td class="center"><b>' . ($sub->nilai !== null ? number_format($sub->nilai, 1) : '-') . '</b></td>';
            $html .= '<td>' . htmlspecialchars($sub->catatan ?? '-') . '</td>';
            $html .= '<td class="center">' . ($sub->diselesaikan_pada ? $sub->diselesaikan_pada->format('d/m/Y H:i') : '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<br><p><i>* Pernyataan Konfirmasi Keabsahan Data (BRL-16): Nilai dan feedback tugas dievaluasi langsung oleh guru pengampu mata pelajaran.</i></p>';
        $html .= '</body></html>';

        return response($html, 200, $headers);
    }

    public function tugasDelete($id)
    {
        $user = auth()->user();
        $tugas = Tugas::where('id', $id)->where('guru_id', $user->id)->firstOrFail();
        $judul = $tugas->judul;
        $tugas->delete();

        AuditLog::record('DELETE_TUGAS', 'Guru menghapus penugasan: ' . $judul);

        return redirect()->route('guru.tugas.index')->with('success', 'Penugasan berhasil dihapus.');
    }
}
