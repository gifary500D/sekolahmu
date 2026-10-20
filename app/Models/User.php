<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'nisn',
        'password',
        'role',
        'kelas_id',
        'password_changed',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is guru
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is siswa
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function daftarTugasSiswa()
    {
        return $this->hasMany(TugasSiswa::class, 'siswa_id');
    }

    public function tugasYangDibuat()
    {
        return $this->hasMany(Tugas::class, 'guru_id');
    }

    /**
     * Ambil koleksi kelas yang dikelola atau menjadi tanggung jawab pengguna.
     */
    public function managedKelas(): \Illuminate\Support\Collection
    {
        if ($this->isAdmin()) {
            return Kelas::all();
        }

        if ($this->isGuru()) {
            $wali = Kelas::where('wali_kelas_id', $this->id)->get();
            $dariRoster = Kelas::whereHas('rosters', fn ($q) => $q->where('guru_id', $this->id))->get();
            return $wali->merge($dariRoster)->unique('id')->values();
        }

        if ($this->isSiswa() && $this->kelas_id) {
            return Kelas::where('id', $this->kelas_id)->get();
        }

        return collect();
    }

    /**
     * Periksa apakah pengguna memiliki hak otorisasi untuk mengelola kelas tertentu.
     */
    public function canManageKelas(mixed $kelas): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->isGuru()) {
            return false;
        }

        if ($kelas instanceof Kelas) {
            $kelasModel = $kelas;
        } elseif (is_numeric($kelas)) {
            $kelasModel = Kelas::find($kelas);
        } elseif (is_string($kelas) && $kelas !== '') {
            $kelasModel = Kelas::where('nama', $kelas)->first();
        } else {
            return false;
        }

        if (! $kelasModel) {
            return false;
        }

        if ($kelasModel->wali_kelas_id && (int) $kelasModel->wali_kelas_id === (int) $this->id) {
            return true;
        }

        return Roster::where('kelas_id', $kelasModel->id)
            ->where('guru_id', $this->id)
            ->exists();
    }
}

