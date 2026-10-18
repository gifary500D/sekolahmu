<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table = 'rosters';

    protected $fillable = [
        'kelas_id',
        'mata_pelajaran',
        'guru_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tahun_ajaran',
        'semester',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
