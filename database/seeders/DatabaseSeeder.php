<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Spmb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with demo accounts for testing.
     */
    public function run(): void
    {
        // 1. Master Data Kelas
        $kelas1 = Kelas::firstOrCreate(['nama' => 'X IPA 1']);
        $kelas2 = Kelas::firstOrCreate(['nama' => 'X IPA 2']);
        $kelas3 = Kelas::firstOrCreate(['nama' => 'XI IPS 1']);

        // 2. Admin Accounts
        User::updateOrCreate(
            ['email' => 'suclyn@sekolah.sch.id'],
            [
                'name' => 'Suclyn Agus Tirta',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'password_changed' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'andi.admin@demo.sch.id'],
            [
                'name' => 'Andi Setiawan',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'password_changed' => true,
            ]
        );

        // 3. Teacher Accounts
        User::updateOrCreate(
            ['email' => 'rina.kartika@demo.sch.id'],
            [
                'name' => 'Rina Kartika, S.Pd.',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'password_changed' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi.hartono@demo.sch.id'],
            [
                'name' => 'Budi Hartono, M.Pd.',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'password_changed' => true,
            ]
        );

        // 4. Student Accounts
        User::updateOrCreate(
            ['email' => 'alya.murid@demo.sch.id'],
            [
                'name' => 'Alya Putri Ramadhani',
                'nisn' => '1234567890',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'kelas_id' => $kelas1->id,
                'password_changed' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'budi.santoso@demo.sch.id'],
            [
                'name' => 'Budi Santoso',
                'nisn' => '1234567891',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'kelas_id' => $kelas1->id,
                'password_changed' => true,
            ]
        );

        // 5. SPMB Applicants
        Spmb::updateOrCreate(
            ['nomor_pendaftaran' => 'SPMB-2026-001'],
            [
                'nama_lengkap' => 'Nadia Cahyani',
                'gender' => 'perempuan',
                'tempat_lahir' => 'Bahorok',
                'tanggal_lahir' => '2010-05-14',
                'nisn' => '9876543210',
                'nik' => '1207123456780001',
                'agama' => 'Islam',
                'email' => 'nadia.cahyani@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 12, Bahorok',
                'kota' => 'Langkat',
                'provinsi' => 'Sumatera Utara',
                'nama_ayah' => 'Slamet Riyadi',
                'pekerjaan_ayah' => 'Petani',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon_ortu' => '081234567891',
                'asal_sekolah' => 'SMP Negeri 1 Bahorok',
                'nilai_rata' => 88.50,
                'tahun_lulus' => 2026,
                'program' => 'ipa',
                'jalur_pendaftaran' => 'Zonasi',
                'status' => 'Menunggu Verifikasi',
            ]
        );

        Spmb::updateOrCreate(
            ['nomor_pendaftaran' => 'SPMB-2026-002'],
            [
                'nama_lengkap' => 'Reza Pratama',
                'gender' => 'laki-laki',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2010-08-20',
                'nisn' => '9876543211',
                'nik' => '1207123456780002',
                'agama' => 'Islam',
                'email' => 'reza.pratama@example.com',
                'telepon' => '081345678901',
                'alamat' => 'Jl. Pembangunan No. 5',
                'kota' => 'Medan',
                'provinsi' => 'Sumatera Utara',
                'nama_ayah' => 'Bambang Pratama',
                'pekerjaan_ayah' => 'Wiraswasta',
                'nama_ibu' => 'Dewi Lestari',
                'pekerjaan_ibu' => 'PNS',
                'telepon_ortu' => '081345678902',
                'asal_sekolah' => 'SMP Swasta Harapan',
                'nilai_rata' => 92.00,
                'tahun_lulus' => 2026,
                'program' => 'ips',
                'jalur_pendaftaran' => 'Prestasi',
                'status' => 'Diterima',
            ]
        );
    }
}
