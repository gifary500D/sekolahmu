<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama'];

    public function siswa(): HasMany
    {
        return $this->hasMany(User::class, 'kelas_id')->where('role', 'siswa');
    }
}
