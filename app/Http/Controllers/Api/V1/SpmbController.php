<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Support\Teks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpmbController extends Controller
{
    private const JALUR = ['Zonasi', 'Afirmasi', 'Prestasi', 'Perpindahan Tugas'];
    private const PROGRAM = ['ipa', 'ips', 'bahasa'];

    /** Publik: calon siswa mendaftar. */
    public function daftar(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'tempat_lahir' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'nisn' => ['required', 'digits:10', 'unique:spmb,nisn'],
            'nik' => ['required', 'digits:16', 'unique:spmb,nik'],
            'agama' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['required', 'string', 'max:20'],
            'alamat' => ['required', 'string', 'max:1000'],
            'kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['required', 'string', 'max:100'],
            'nama_ayah' => ['required', 'string', 'max:255'],
            'pekerjaan_ayah' => ['required', 'string', 'max:255'],
            'nama_ibu' => ['required', 'string', 'max:255'],
            'pekerjaan_ibu' => ['required', 'string', 'max:255'],
            'telepon_ortu' => ['required', 'string', 'max:20'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'nilai_rata' => ['required', 'numeric', 'between:0,100'],
            'tahun_lulus' => ['required', 'integer', 'between:2020,' . date('Y')],
            'program' => ['required', 'in:' . implode(',', self::PROGRAM)],
            'jalur_pendaftaran' => ['required', 'in:' . implode(',', self::JALUR)],
            // Data hanya dikumpulkan dengan persetujuan pendaftar (bagian 7 blueprint)
            'persetujuan' => ['accepted'],
        ]);
        unset($data['persetujuan']);

        $data = Teks::bersih($data, [
            'nama_lengkap', 'tempat_lahir', 'agama', 'telepon', 'alamat', 'kota', 'provinsi',
            'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu', 'telepon_ortu', 'asal_sekolah',
        ]);

        $spmb = Spmb::create($data + [
            'nomor_pendaftaran' => Spmb::buatNomor(),
            'status' => 'menunggu',
        ]);

        return response()->json(['data' => [
            'nomor_pendaftaran' => $spmb->nomor_pendaftaran,
            'nama_lengkap' => $spmb->nama_lengkap,
            'program' => $spmb->program,
            'jalur_pendaftaran' => $spmb->jalur_pendaftaran,
            'status' => $spmb->status,
            'label_status' => Spmb::LABEL_STATUS[$spmb->status],
            'tanggal_daftar' => $spmb->created_at->toIso8601String(),
        ]], 201);
    }

    /** Publik: cek status tanpa login. Hanya data minimal yang ditampilkan. */
    public function cekStatus(string $nomor): JsonResponse
    {
        $nomor = strtoupper(trim($nomor));
        $spmb = preg_match('/^[A-Z0-9]{8}$/', $nomor)
            ? Spmb::where('nomor_pendaftaran', $nomor)->first()
            : null;

        if (! $spmb) {
            return response()->json(['message' => 'Nomor pendaftaran tidak ditemukan.'], 404);
        }

        return response()->json(['data' => [
            'nomor_pendaftaran' => $spmb->nomor_pendaftaran,
            'nama' => $this->samarkan($spmb->nama_lengkap),
            'program' => $spmb->program,
            'status' => $spmb->status,
            'label_status' => Spmb::LABEL_STATUS[$spmb->status],
            'catatan' => $spmb->catatan,
            'diperbarui_pada' => $spmb->updated_at->toIso8601String(),
        ]]);
    }

    /** Admin: daftar pendaftar. */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => ['sometimes', 'in:' . implode(',', Spmb::STATUS)],
            'program' => ['sometimes', 'in:' . implode(',', self::PROGRAM)],
            'jalur' => ['sometimes', 'in:' . implode(',', self::JALUR)],
            'cari' => ['sometimes', 'string', 'max:100'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
        ]);

        $q = Spmb::query()->latest('id');
        foreach (['status', 'program'] as $kolom) {
            if ($request->filled($kolom)) {
                $q->where($kolom, $request->query($kolom));
            }
        }
        if ($request->filled('jalur')) {
            $q->where('jalur_pendaftaran', $request->query('jalur'));
        }
        if ($cari = $request->query('cari')) {
            $like = '%' . addcslashes($cari, '%_\\') . '%';
            $q->where(fn ($w) => $w->where('nama_lengkap', 'like', $like)->orWhere('nomor_pendaftaran', 'like', $like));
        }

        $halaman = $q->paginate($request->integer('per_page', 15))->through(fn (Spmb $s) => [
            'id' => $s->id,
            'nomor_pendaftaran' => $s->nomor_pendaftaran,
            'nama_lengkap' => $s->nama_lengkap,
            'program' => $s->program,
            'jalur_pendaftaran' => $s->jalur_pendaftaran,
            'asal_sekolah' => $s->asal_sekolah,
            'nilai_rata' => $s->nilai_rata,
            'status' => $s->status,
            'label_status' => Spmb::LABEL_STATUS[$s->status],
            'tanggal_daftar' => $s->created_at->toIso8601String(),
        ]);

        return response()->json($halaman);
    }

    /** Admin: detail lengkap satu pendaftar (data pribadi hanya dapat dibaca admin). */
    public function show(Spmb $spmb): JsonResponse
    {
        return response()->json(['data' => $spmb->toArray() + [
            'label_status' => Spmb::LABEL_STATUS[$spmb->status],
        ]]);
    }

    /** Admin: verifikasi dan ubah status. Perubahan langsung terlihat di halaman cek status. */
    public function updateStatus(Request $request, Spmb $spmb): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Spmb::STATUS)],
            'catatan' => ['nullable', 'required_if:status,perlu_perbaikan', 'string', 'max:500'],
        ]);
        $data = Teks::bersih($data, ['catatan']);

        $spmb->update(['status' => $data['status'], 'catatan' => $data['catatan'] ?? null]);

        return response()->json(['data' => [
            'id' => $spmb->id,
            'nomor_pendaftaran' => $spmb->nomor_pendaftaran,
            'status' => $spmb->status,
            'label_status' => Spmb::LABEL_STATUS[$spmb->status],
            'catatan' => $spmb->catatan,
        ]]);
    }

    /** Admin dan kepala sekolah: statistik pendaftaran. */
    public function statistik(): JsonResponse
    {
        $hitung = fn (string $kolom, array $daftar) => collect($daftar)->mapWithKeys(fn ($k) => [$k => 0])
            ->merge(Spmb::select($kolom, DB::raw('COUNT(*) as total'))->groupBy($kolom)->pluck('total', $kolom))
            ->map(fn ($n) => (int) $n);

        return response()->json(['data' => [
            'total' => Spmb::count(),
            'per_status' => $hitung('status', Spmb::STATUS),
            'per_program' => $hitung('program', self::PROGRAM),
            'per_jalur' => $hitung('jalur_pendaftaran', self::JALUR),
        ]]);
    }

    /** "Budi Santoso" menjadi "B*** S******". */
    private function samarkan(string $nama): string
    {
        $kata = preg_split('/\s+/u', trim($nama), -1, PREG_SPLIT_NO_EMPTY);

        return implode(' ', array_map(function (string $k) {
            $panjang = mb_strlen($k);

            return $panjang <= 1 ? $k : mb_substr($k, 0, 1) . str_repeat('*', $panjang - 1);
        }, $kata));
    }
}
