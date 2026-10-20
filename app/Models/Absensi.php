<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    public const STATUS = ['hadir', 'izin', 'sakit', 'alpa'];

    protected $table = 'absensi';

    protected $fillable = ['kelas_id', 'tanggal', 'dicatat_oleh'];

    // 'tanggal' sengaja tidak di-cast agar selalu berupa string Y-m-d (aman di MySQL dan SQLite).

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function pencatat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(AbsensiDetail::class, 'absensi_id');
    }
}
