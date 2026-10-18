<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'tingkat',
        'program',
        'wali_kelas_id',
    ];

    public function siswa()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }

    public function rosters()
    {
        return $this->hasMany(Roster::class, 'kelas_id');
    }
}
