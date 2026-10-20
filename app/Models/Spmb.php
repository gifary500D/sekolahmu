<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spmb extends Model
{
    use HasFactory;

    protected $table = 'spmb';

    protected $fillable = [
        'nomor_pendaftaran',
        'nama_lengkap',
        'gender',
        'tempat_lahir',
        'tanggal_lahir',
        'nisn',
        'nik',
        'agama',
        'email',
        'telepon',
        'alamat',
        'kota',
        'provinsi',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'telepon_ortu',
        'asal_sekolah',
        'nilai_rata',
        'tahun_lulus',
        'program',
        'jalur_pendaftaran',
        'berkas_ijazah_skl',
        'berkas_kk',
        'berkas_rapor',
        'status',
    ];

    /**
     * Generate Nomor Pendaftaran SPMB yang unik dan persisten.
     * Format: SPMB-YYYY-0001
     */
    public static function generateNomorPendaftaran(): string
    {
        $tahun = date('Y');
        $prefix = "SPMB-{$tahun}-";

        $lastRecord = static::where('nomor_pendaftaran', 'LIKE', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextSeq = 1;
        if ($lastRecord && preg_match('/SPMB-\d{4}-(\d+)/', $lastRecord->nomor_pendaftaran, $matches)) {
            $nextSeq = ((int) $matches[1]) + 1;
        }

        $nomor = $prefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

        while (static::where('nomor_pendaftaran', $nomor)->exists()) {
            $nextSeq++;
            $nomor = $prefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
        }

        return $nomor;
    }
}