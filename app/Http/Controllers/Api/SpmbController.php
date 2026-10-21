<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use App\Models\User;
use App\Support\Teks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SpmbController extends Controller
{
    /**
     * Endpoint untuk menerima pendaftaran SPMB baru (POST /api/spmb/daftar)
     */
    public function daftar(Request $request)
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
            'nisn' => 'required|digits:10|unique:spmb,nisn',
            'nik' => 'required|digits:16|unique:spmb,nik',
            'agama' => 'required|string|max:50',
            'email' => 'required|email|max:255',
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $uploadedFiles = [];

        try {
            return DB::transaction(function () use ($request, $validator, &$uploadedFiles) {
                $data = $validator->validated();

                // Simpan berkas lampiran di private storage ('local') demi perlindungan privasi data siswa
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

                // Generate nomor pendaftaran unik & terurut
                $data['nomor_pendaftaran'] = Spmb::generateNomorPendaftaran();
                $data['status'] = 'Menunggu Verifikasi';

                $spmb = Spmb::create($data);

                // Sinkronisasi otomatis akun User Siswa
                $user = User::where('nisn', $data['nisn'])->orWhere('email', $data['email'])->first();
                if (! $user) {
                    $tempPassword = 'Sp-'.Str::random(8).'!';
                    User::create([
                        'name' => $data['nama_lengkap'],
                        'email' => $data['email'],
                        'nisn' => $data['nisn'],
                        'password' => Hash::make($tempPassword),
                        'role' => 'siswa',
                        'password_changed' => false,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Pendaftaran berhasil disimpan!',
                    'data' => [
                        'nomor_pendaftaran' => $spmb->nomor_pendaftaran,
                        'nama_lengkap' => $spmb->nama_lengkap,
                        'jalur_pendaftaran' => $spmb->jalur_pendaftaran,
                        'status' => $spmb->status,
                        'created_at' => $spmb->created_at,
                    ],
                ], 201);
            });
        } catch (\Throwable $e) {
            // Rollback fisik seluruh berkas yang sempat diunggah saat transaksi gagal
            foreach ($uploadedFiles as $path) {
                Storage::disk('local')->delete($path);
            }

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server saat memproses pendaftaran.',
            ], 500);
        }
    }

    /**
     * Endpoint untuk memeriksa status pendaftaran tanpa login (GET /api/spmb/status/{nomor})
     * Mencegah kebocoran PII melalui masking nama dan penyembunyian identitas sensitif.
     */
    public function cekStatus(Request $request, $nomor)
    {
        $nomorBersih = strtoupper(trim((string) $nomor));

        $validator = Validator::make(
            ['nomor' => $nomorBersih],
            ['nomor' => ['required', 'string', 'regex:/^SPMB-\d{4}-\d{4,}$/']]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Format nomor pendaftaran tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $pendaftar = Spmb::where('nomor_pendaftaran', $nomorBersih)->first();

        if (! $pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor pendaftaran tidak ditemukan. Periksa kembali nomor Anda.',
            ], 404);
        }

        if ($request->filled('nisn') && $request->input('nisn') !== $pendaftar->nisn) {
            return response()->json([
                'success' => false,
                'message' => 'Data verifikasi tidak sesuai.',
            ], 403);
        }

        if ($request->filled('tanggal_lahir') && $request->input('tanggal_lahir') !== (string) $pendaftar->tanggal_lahir) {
            return response()->json([
                'success' => false,
                'message' => 'Data verifikasi tidak sesuai.',
            ], 403);
        }

        $user = $request->user('sanctum') ?? auth()->user();
        $namaTampil = ($user && $user->isAdmin()) ? $pendaftar->nama_lengkap : Teks::maskNama($pendaftar->nama_lengkap);

        return response()->json([
            'success' => true,
            'message' => 'Detail status pendaftaran ditemukan',
            'data' => [
                'nomor_pendaftaran' => $pendaftar->nomor_pendaftaran,
                'nama_lengkap' => $namaTampil,
                'status' => $pendaftar->status,
            ],
        ], 200);
    }

    /**
     * Endpoint untuk memperbarui status pendaftaran (PUT /api/spmb/status/{id})
     * Memerlukan autentikasi Sanctum dan otorisasi admin/panitia.
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. Otorisasi: Hanya user dengan role admin / izin yang berhak mengubah status
        $user = $request->user();
        if (! $user || ! Gate::allows('update-spmb-status', $user)) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki otorisasi untuk memperbarui status pendaftaran.',
            ], 403);
        }

        // 2. Validasi status
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:Menunggu Verifikasi,Sedang Diverifikasi,Terverifikasi,Diterima,Ditolak,Diverifikasi,Perlu Perbaikan,Lulus,Tidak Lulus',
            'kelas_id' => 'nullable|exists:kelas,id',
            'note' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // 3. Cari data pendaftar
        $pendaftar = Spmb::find($id);

        if (! $pendaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Data pendaftar tidak ditemukan.',
            ], 404);
        }

        // 4. Update status secara persisten
        $pendaftar->status = $request->status;
        if ($request->has('note')) {
            $pendaftar->note = $request->note;
        }
        $pendaftar->save();

        // 5. Sinkronisasi akun User saat status dinyatakan Diterima / Lulus
        if (in_array($request->status, ['Diterima', 'Lulus'], true)) {
            $user = User::where('nisn', $pendaftar->nisn)
                ->orWhere('email', $pendaftar->email)
                ->first();

            if (! $user) {
                $tempPassword = 'Sp-'.Str::random(8).'!';
                User::create([
                    'name' => $pendaftar->nama_lengkap,
                    'email' => $pendaftar->email,
                    'nisn' => $pendaftar->nisn,
                    'password' => Hash::make($tempPassword),
                    'role' => 'siswa',
                    'kelas_id' => $request->kelas_id,
                    'password_changed' => false,
                ]);
            } else {
                $updateData = [
                    'name' => $pendaftar->nama_lengkap,
                    'email' => $pendaftar->email,
                    'nisn' => $pendaftar->nisn,
                    'role' => 'siswa',
                ];
                if ($request->filled('kelas_id')) {
                    $updateData['kelas_id'] = $request->kelas_id;
                }
                $user->update($updateData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pendaftaran berhasil diperbarui.',
            'data' => [
                'id' => $pendaftar->id,
                'nomor_pendaftaran' => $pendaftar->nomor_pendaftaran,
                'nama_lengkap' => $pendaftar->nama_lengkap,
                'status' => $pendaftar->status,
                'updated_at' => $pendaftar->updated_at,
            ],
        ], 200);
    }
}
