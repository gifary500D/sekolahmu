<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spmb extends Model
{
    public const STATUS = ['menunggu', 'diverifikasi', 'perlu_perbaikan', 'lulus', 'tidak_lulus'];

    public const LABEL_STATUS = [
        'menunggu' => 'Menunggu',
        'diverifikasi' => 'Diverifikasi',
        'perlu_perbaikan' => 'Perlu perbaikan',
        'lulus' => 'Lulus',
        'tidak_lulus' => 'Tidak lulus',
    ];

    protected $table = 'spmb';

    protected $fillable = [
        'nomor_pendaftaran', 'nama_lengkap', 'gender', 'tempat_lahir', 'tanggal_lahir',
        'nisn', 'nik', 'agama', 'email', 'telepon', 'alamat', 'kota', 'provinsi',
        'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu', 'telepon_ortu',
        'asal_sekolah', 'nilai_rata', 'tahun_lulus', 'program', 'jalur_pendaftaran',
        'berkas_ijazah_skl', 'berkas_kk', 'berkas_rapor', 'status', 'catatan',
    ];

    protected function casts(): array
    {
        return ['tanggal_lahir' => 'date', 'nilai_rata' => 'decimal:2'];
    }

    /** Pembantu untuk seeder/tes: buat pendaftar lengkap dengan nomor acak dan status awal. */
    public static function factoryLessCreate(array $atribut): static
    {
        return static::create($atribut + ['nomor_pendaftaran' => static::buatNomor(), 'status' => 'menunggu']);
    }

    /** 8 karakter acak tanpa karakter yang mudah tertukar (0/O, 1/I). */
    public static function buatNomor(): string
    {
        $huruf = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

        do {
            $nomor = '';
            for ($i = 0; $i < 8; $i++) {
                $nomor .= $huruf[random_int(0, strlen($huruf) - 1)];
            }
        } while (static::where('nomor_pendaftaran', $nomor)->exists());

        return $nomor;
    }
}
