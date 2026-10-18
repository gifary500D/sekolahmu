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
}
