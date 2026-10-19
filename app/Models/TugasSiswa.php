<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasSiswa extends Model
{
    protected $table = 'tugas_siswa';

    protected $fillable = ['tugas_id', 'siswa_id', 'status', 'file_path', 'nilai', 'catatan', 'diselesaikan_pada', 'pengingat_dikirim_pada'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    protected function casts(): array
    {
        return [
            'diselesaikan_pada' => 'datetime',
            'pengingat_dikirim_pada' => 'datetime',
        ];
    }
}
