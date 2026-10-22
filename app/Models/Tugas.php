<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tugas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tugas';

    protected $fillable = [
        'judul',
        'deskripsi',
        'mata_pelajaran',
        'kelas_id',
        'guru_id',
        'tenggat',
        'prioritas',
    ];

    protected function casts(): array
    {
        return [
            'tenggat' => 'datetime',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function pengumpulan()
    {
        return $this->hasMany(TugasSiswa::class, 'tugas_id');
    }

    public function statusSiswa()
    {
        return $this->hasMany(TugasSiswa::class, 'tugas_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
