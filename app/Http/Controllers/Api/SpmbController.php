<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpmbController extends Controller
{
    /**
     * Endpoint untuk menerima pendaftaran SPMB via API (POST /api/spmb/daftar)
     */
    public function daftar(Request $request)
    {
        // 1. Validasi input dari payload frontend (Dinamis untuk tahun mendatang)
        $tahunSekarang = date('Y');
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
            'tahun_lulus' => "required|numeric|min:2020|max:{$tahunSekarang}", // Dinamis otomatis
            'program' => 'required|in:ipa,ips,bahasa',
            'jalur_pendaftaran' => 'required|in:Zonasi,Afirmasi,Prestasi,Perpindahan Tugas',
        ]);

        // Jika validasi gagal, kembalikan respons JSON error (status 422)
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $validator->validated();

            // 2. Generate Nomor Pendaftaran Unik (Dinamis berdasarkan tahun saat daftar)
            $tahunDaftar = date('Y');
            $lastSpmb = Spmb::orderBy('id', 'desc')->first();
            $nextId = $lastSpmb ? $lastSpmb->id + 1 : 1;
            $data['nomor_pendaftaran'] = 'SPMB-'.$tahunDaftar.'-'.str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // 3. Status awal
            $data['status'] = 'Menunggu Verifikasi';

            // 4. Simpan ke database
            $spmb = Spmb::create($data);

            // 5. Kembalikan respons sukses berformat JSON ke Frontend
            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil disimpan!',
                'data' => [
                    'nomor_pendaftaran' => $spmb->nomor_pendaftaran,
                    'nama_lengkap' => $spmb->nama_lengkap,
                    'status' => $spmb->status,
                ],
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
