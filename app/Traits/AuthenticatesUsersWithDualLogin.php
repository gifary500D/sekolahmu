<?php

namespace App\Traits;

use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

trait AuthenticatesUsersWithDualLogin
{
    /**
     * Temukan pengguna berdasarkan Email (case-insensitive) atau NISN.
     */
    protected function findUserByLogin(string $loginInput): ?User
    {
        $loginInput = trim($loginInput);
        if ($loginInput === '') {
            return null;
        }

        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            return User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
        }

        // Cari berdasarkan NISN terlebih dahulu
        $user = User::where('nisn', $loginInput)->first();
        if ($user) {
            return $user;
        }

        // Fallback jika input format email non-standar atau string email
        return User::whereRaw('LOWER(email) = ?', [strtolower($loginInput)])->first();
    }

    /**
     * Auto-provisioning akun demo cepat (Admin Suclyn, Guru Rina S.Pd, Siswa Alya)
     * sebelum autentikasi dijalankan, agar 100% berfungsi di cPanel tanpa seed database manual.
     */
    protected function provisionDemoAccountIfNeeded(string $loginField, string $password): void
    {
        $normalizedLogin = strtolower(trim($loginField));
        $hashedPassword = Hash::make($password ?: 'password');

        // 1. Admin Suclyn (suclyn@sekolah.sch.id)
        if (in_array($normalizedLogin, ['suclyn@sekolah.sch.id', 'admin@sekolahmu.sch.id', 'admin@sekolah.sch.id'], true)) {
            $admin = User::where('email', 'suclyn@sekolah.sch.id')->first();
            if (! $admin) {
                User::create([
                    'name' => 'Admin Suclyn',
                    'email' => 'suclyn@sekolah.sch.id',
                    'password' => $hashedPassword,
                    'role' => 'admin',
                    'password_changed' => true,
                ]);
            } else {
                $admin->update([
                    'name' => 'Admin Suclyn',
                    'password' => $hashedPassword,
                    'role' => 'admin',
                    'password_changed' => true,
                ]);
            }

            return;
        }

        // 2. Guru Rina S.Pd (rina.kartika@demo.sch.id)
        if (in_array($normalizedLogin, ['rina.kartika@demo.sch.id', 'rina.spd@demo.sch.id', 'rina@sekolah.sch.id', 'rina@demo.sch.id'], true)) {
            $demoKelas = Kelas::firstOrCreate(
                ['nama' => 'X-MIPA-1'],
                [
                    'tingkat' => '10',
                    'program' => 'ipa',
                ]
            );

            $guru = User::where('email', 'rina.kartika@demo.sch.id')->first();
            if (! $guru) {
                $guru = User::create([
                    'name' => 'Rina Kartika, S.Pd.',
                    'email' => 'rina.kartika@demo.sch.id',
                    'password' => $hashedPassword,
                    'role' => 'guru',
                    'password_changed' => true,
                ]);
            } else {
                $guru->update([
                    'name' => 'Rina Kartika, S.Pd.',
                    'password' => $hashedPassword,
                    'role' => 'guru',
                    'password_changed' => true,
                ]);
            }

            if (! $demoKelas->wali_kelas_id || $demoKelas->wali_kelas_id === $guru->id) {
                $demoKelas->update(['wali_kelas_id' => $guru->id]);
            }

            return;
        }

        // 3. Siswa Alya beserta NISN-nya
        $demoAlyaEmail = 'alya.murid@demo.sch.id';
        $demoAlyaNisn = '0081234567';

        if (in_array($normalizedLogin, [$demoAlyaEmail, $demoAlyaNisn, 'alya@sekolah.sch.id', 'alya@demo.sch.id'], true)) {
            $demoKelas = Kelas::firstOrCreate(
                ['nama' => 'X-MIPA-1'],
                [
                    'tingkat' => '10',
                    'program' => 'ipa',
                ]
            );

            $siswa = User::where('email', $demoAlyaEmail)
                ->orWhere('nisn', $demoAlyaNisn)
                ->first();

            if (! $siswa) {
                $siswa = User::create([
                    'name' => 'Alya Murid',
                    'email' => $demoAlyaEmail,
                    'nisn' => $demoAlyaNisn,
                    'password' => $hashedPassword,
                    'role' => 'siswa',
                    'kelas_id' => $demoKelas->id,
                    'password_changed' => true,
                ]);
            } else {
                $siswa->update([
                    'name' => 'Alya Murid',
                    'email' => $demoAlyaEmail,
                    'nisn' => $demoAlyaNisn,
                    'password' => $hashedPassword,
                    'role' => 'siswa',
                    'kelas_id' => $siswa->kelas_id ?: $demoKelas->id,
                    'password_changed' => true,
                ]);
            }

            if (Schema::hasTable('spmb')) {
                $spmbData = [
                    'nama_lengkap' => 'Alya Murid',
                    'gender' => 'perempuan',
                    'tempat_lahir' => 'Bahorok',
                    'tanggal_lahir' => '2008-05-15',
                    'nisn' => $demoAlyaNisn,
                    'nik' => '1207010101080099',
                    'agama' => 'Islam',
                    'email' => $demoAlyaEmail,
                    'telepon' => '081234567800',
                    'alamat' => 'Jl. Pendidikan No. 10 Bahorok',
                    'kota' => 'Langkat',
                    'provinsi' => 'Sumatera Utara',
                    'nama_ayah' => 'Bapak Alya',
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Ibu Alya',
                    'pekerjaan_ibu' => 'Guru',
                    'telepon_ortu' => '081234567801',
                    'asal_sekolah' => 'SMP Negeri 1 Bahorok',
                    'nilai_rata' => 91.5,
                    'tahun_lulus' => 2026,
                    'program' => 'ipa',
                    'jalur_pendaftaran' => 'Zonasi',
                    'status' => 'Diterima',
                ];

                if (Schema::hasColumn('spmb', 'note')) {
                    $spmbData['note'] = 'Akun demo siswa resmi terverifikasi dan diterima.';
                }

                $spmb = Spmb::where('nisn', $demoAlyaNisn)->orWhere('email', $demoAlyaEmail)->first();
                if (! $spmb) {
                    $spmbData['nomor_pendaftaran'] = 'SPMB-DEMO-001';
                    Spmb::create($spmbData);
                } else {
                    $spmb->update($spmbData);
                }
            }

            return;
        }
    }
}
