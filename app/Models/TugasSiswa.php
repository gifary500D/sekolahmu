<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSiswa extends Model
{
    protected $table = 'tugas_siswa';

    protected $fillable = ['tugas_id', 'siswa_id', 'status', 'file_path', 'nilai', 'catatan', 'diselesaikan_pada', 'pengingat_dikirim_pada'];

    protected function casts(): array
    {
        return [
            'diselesaikan_pada' => 'datetime',
            'pengingat_dikirim_pada' => 'datetime',
        ];
    }
}
