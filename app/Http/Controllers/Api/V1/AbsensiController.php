<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\Kelas;
use App\Models\User;
use App\Support\Csv;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AbsensiController extends Controller
{
    /** Daftar kelas (guru, admin, kepala sekolah). */
    public function kelas(): JsonResponse
    {
        return response()->json(['data' => Kelas::orderBy('nama')->get(['id', 'nama'])]);
    }

    /** Daftar siswa satu kelas, dipakai guru saat mengisi absensi. */
    public function siswa(Kelas $kelas): JsonResponse
    {
        $siswa = $this->siswaKelas($kelas->id);

        return response()->json(['data' => $siswa->map(fn ($s) => ['id' => $s->id, 'nama' => $s->name])->values()]);
    }

    /** Guru atau admin mencatat absensi satu kelas pada satu tanggal (menyimpan ulang = memperbarui). */
    public function simpan(Request $request): JsonResponse
    {
        $data = $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'kehadiran' => ['required', 'array', 'min:1', 'max:100'],
            'kehadiran.*.siswa_id' => ['required', 'integer', 'distinct'],
            'kehadiran.*.status' => ['required', 'in:' . implode(',', Absensi::STATUS)],
            'kehadiran.*.keterangan' => ['nullable', 'string', 'max:150'],
        ]);

        $anggota = $this->siswaKelas((int) $data['kelas_id'])->pluck('id')->all();
        $asing = array_diff(array_column($data['kehadiran'], 'siswa_id'), $anggota);
        if ($asing) {
            throw ValidationException::withMessages([
                'kehadiran' => ['Ada siswa yang bukan anggota kelas ini.'],
            ]);
        }

        $tanggal = Carbon::parse($data['tanggal'])->toDateString();

        $absensi = DB::transaction(function () use ($data, $tanggal, $request) {
            $sesi = Absensi::updateOrCreate(
                ['kelas_id' => $data['kelas_id'], 'tanggal' => $tanggal],
                ['dicatat_oleh' => $request->user()->id]
            );
            $sesi->detail()->delete();
            $sesi->detail()->createMany(array_map(fn (array $k) => [
                'siswa_id' => (int) $k['siswa_id'],
                'status' => $k['status'],
                'keterangan' => isset($k['keterangan']) ? trim(strip_tags($k['keterangan'])) : null,
            ], $data['kehadiran']));

            return $sesi;
        });

        return response()->json(['data' => [
            'id' => $absensi->id,
            'kelas_id' => (int) $data['kelas_id'],
            'tanggal' => $tanggal,
            'ringkasan' => $this->ringkas(collect($data['kehadiran'])),
        ]], 201);
    }

    /** Daftar sesi absensi satu kelas (guru, admin, kepala sekolah). */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'dari' => ['sometimes', 'date'],
            'sampai' => ['sometimes', 'date'],
        ]);

        $sesi = Absensi::with('detail:id,absensi_id,status')
            ->where('kelas_id', $request->integer('kelas_id'))
            ->when($request->filled('dari'), fn ($q) => $q->where('tanggal', '>=', Carbon::parse($request->query('dari'))->toDateString()))
            ->when($request->filled('sampai'), fn ($q) => $q->where('tanggal', '<=', Carbon::parse($request->query('sampai'))->toDateString()))
            ->orderByDesc('tanggal')
            ->paginate(20)
            ->through(fn (Absensi $a) => [
                'id' => $a->id,
                'tanggal' => $a->tanggal,
                'ringkasan' => $this->ringkas($a->detail),
            ]);

        return response()->json($sesi);
    }

    /** Rekap per siswa untuk satu kelas (guru, admin, kepala sekolah). */
    public function rekap(Request $request, Kelas $kelas): JsonResponse
    {
        $request->validate(['dari' => ['sometimes', 'date'], 'sampai' => ['sometimes', 'date']]);
        [$dari, $sampai] = $this->rentang($request);

        $hitung = AbsensiDetail::query()
            ->join('absensi', 'absensi.id', '=', 'absensi_detail.absensi_id')
            ->where('absensi.kelas_id', $kelas->id)
            ->when($dari, fn ($q) => $q->where('absensi.tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->where('absensi.tanggal', '<=', $sampai))
            ->selectRaw('absensi_detail.siswa_id as siswa_id, absensi_detail.status as status, COUNT(*) as total')
            ->groupBy('absensi_detail.siswa_id', 'absensi_detail.status')
            ->get()
            ->groupBy('siswa_id');

        $baris = $this->siswaKelas($kelas->id)->map(function ($s) use ($hitung) {
            $per = ($hitung->get($s->id) ?? collect())->pluck('total', 'status');
            $r = ['siswa_id' => $s->id, 'nama' => $s->name];
            foreach (Absensi::STATUS as $st) {
                $r[$st] = (int) ($per[$st] ?? 0);
            }
            $r['total'] = array_sum(array_intersect_key($r, array_flip(Absensi::STATUS)));
            $r['persen_hadir'] = $r['total'] > 0 ? round($r['hadir'] / $r['total'] * 100, 1) : null;

            return $r;
        })->values();

        $pertemuan = Absensi::where('kelas_id', $kelas->id)
            ->when($dari, fn ($q) => $q->where('tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->where('tanggal', '<=', $sampai))
            ->count();

        return response()->json([
            'data' => $baris,
            'meta' => ['kelas' => $kelas->nama, 'jumlah_pertemuan' => $pertemuan, 'dari' => $dari, 'sampai' => $sampai],
        ]);
    }

    /** Siswa melihat rekap kehadirannya sendiri. */
    public function saya(Request $request): JsonResponse
    {
        $request->validate(['dari' => ['sometimes', 'date'], 'sampai' => ['sometimes', 'date']]);
        [$dari, $sampai] = $this->rentang($request);

        $riwayat = AbsensiDetail::query()
            ->join('absensi', 'absensi.id', '=', 'absensi_detail.absensi_id')
            ->where('absensi_detail.siswa_id', $request->user()->id)
            ->when($dari, fn ($q) => $q->where('absensi.tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->where('absensi.tanggal', '<=', $sampai))
            ->orderByDesc('absensi.tanggal')
            ->limit(200)
            ->get(['absensi.tanggal as tanggal', 'absensi_detail.status as status', 'absensi_detail.keterangan as keterangan']);

        return response()->json([
            'data' => $riwayat,
            'ringkasan' => $this->ringkas($riwayat),
        ]);
    }

    /** Admin mengekspor rekap absensi satu kelas ke CSV. */
    public function exportCsv(Request $request, Kelas $kelas): StreamedResponse
    {
        $request->validate(['dari' => ['sometimes', 'date'], 'sampai' => ['sometimes', 'date']]);
        [$dari, $sampai] = $this->rentang($request);

        $baris = AbsensiDetail::query()
            ->join('absensi', 'absensi.id', '=', 'absensi_detail.absensi_id')
            ->join('users', 'users.id', '=', 'absensi_detail.siswa_id')
            ->where('absensi.kelas_id', $kelas->id)
            ->when($dari, fn ($q) => $q->where('absensi.tanggal', '>=', $dari))
            ->when($sampai, fn ($q) => $q->where('absensi.tanggal', '<=', $sampai))
            ->orderBy('absensi.tanggal')
            ->orderBy('users.name')
            ->get(['absensi.tanggal as tanggal', 'users.name as nama', 'absensi_detail.status as status', 'absensi_detail.keterangan as keterangan']);

        $namaBerkas = 'rekap-absensi-' . Str::slug($kelas->nama) . '-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($baris, $kelas) {
            echo "\xEF\xBB\xBF"; // BOM agar Excel membaca UTF-8
            $f = fopen('php://output', 'w');
            fputcsv($f, ['No', 'Kelas', 'Tanggal', 'Nama Siswa', 'Status', 'Keterangan']);
            foreach ($baris as $i => $b) {
                fputcsv($f, [
                    $i + 1,
                    Csv::aman($kelas->nama),
                    $b->tanggal,
                    Csv::aman($b->nama),
                    Csv::aman($b->status),
                    Csv::aman($b->keterangan),
                ]);
            }
            fclose($f);
        }, $namaBerkas, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function siswaKelas(int $kelasId): Collection
    {
        return User::where('role', 'siswa')->where('kelas_id', $kelasId)->orderBy('name')->get(['id', 'name']);
    }

    /** @return array{0: ?string, 1: ?string} */
    private function rentang(Request $request): array
    {
        return [
            $request->filled('dari') ? Carbon::parse($request->query('dari'))->toDateString() : null,
            $request->filled('sampai') ? Carbon::parse($request->query('sampai'))->toDateString() : null,
        ];
    }

    /** Hitung jumlah per status dari kumpulan baris yang memiliki kunci/atribut "status". */
    private function ringkas(Collection $baris): array
    {
        $per = $baris->map(fn ($b) => is_array($b) ? $b['status'] : $b->status)->countBy();
        $hasil = [];
        foreach (Absensi::STATUS as $st) {
            $hasil[$st] = (int) ($per[$st] ?? 0);
        }
        $hasil['total'] = array_sum($hasil);

        return $hasil;
    }
}
