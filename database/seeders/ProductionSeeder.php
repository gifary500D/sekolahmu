<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Kelas;
use App\Models\Roster;
use App\Models\Spmb;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Kelas (10 Kelas)
        $tingkatList = ['10', '11', '12'];
        $programList = ['ipa', 'ips', 'bahasa'];
        $kelasList = [];

        for ($i = 1; $i <= 10; $i++) {
            $tingkat = $tingkatList[array_rand($tingkatList)];
            $program = $programList[array_rand($programList)];
            $nama = ($tingkat == '10' ? 'X' : ($tingkat == '11' ? 'XI' : 'XII')).' '.strtoupper($program).' '.(($i % 3) + 1);

            $kelas = Kelas::firstOrCreate(
                ['nama' => $nama],
                [
                    'tingkat' => $tingkat,
                    'program' => $program,
                ]
            );
            $kelasList[] = $kelas;
        }

        // 2. Seed Users (50 Users: 2 Admin, 8 Guru, 40 Siswa)
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@sekolahmu.sch.id'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'password_changed' => true,
            ]
        );
        User::updateOrCreate(
            ['email' => 'operator@sekolahmu.sch.id'],
            [
                'name' => 'Operator Sekolah',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'password_changed' => true,
            ]
        );

        // Guru (8 Guru)
        $namaGuru = [
            'Drs. H. Abdullah, M.Pd.', 'Siti Rahmawati, S.Pd.', 'Budi Santoso, M.Sc.',
            'Dewi Lestari, S.Pd.', 'Ahmad Fauzi, M.Pd.', 'Sri Wahyuni, S.Si.',
            'Eko Prasetyo, S.Kom.', 'Nurul Hidayah, M.Pd.',
        ];
        $guruList = [];
        foreach ($namaGuru as $index => $nama) {
            $guru = User::updateOrCreate(
                ['email' => 'guru'.($index + 1).'@sekolahmu.sch.id'],
                [
                    'name' => $nama,
                    'password' => Hash::make('password'),
                    'role' => 'guru',
                    'password_changed' => true,
                ]
            );
            $guruList[] = $guru;
        }

        // Siswa (40 Siswa)
        $namaSiswaDepan = ['Aditya', 'Bunga', 'Candra', 'Dinda', 'Eko', 'Fajar', 'Gita', 'Hadi', 'Indah', 'Joko', 'Kartika', 'Lestari', 'Muhammad', 'Nadia', 'Oki', 'Putri', 'Qori', 'Rizki', 'Siti', 'Taufik'];
        $namaSiswaBelakang = ['Pratama', 'Ramadhani', 'Saputra', 'Wulandari', 'Kurniawan', 'Utami', 'Santoso', 'Hidayat', 'Lestari', 'Nugroho'];

        for ($i = 1; $i <= 40; $i++) {
            $nama = $namaSiswaDepan[array_rand($namaSiswaDepan)].' '.$namaSiswaBelakang[array_rand($namaSiswaBelakang)];
            $nisn = '308'.str_pad($i, 7, '0', STR_PAD_LEFT);
            $kelas = $kelasList[array_rand($kelasList)];

            User::updateOrCreate(
                ['email' => 'siswa'.$i.'@sekolahmu.sch.id'],
                [
                    'name' => $nama,
                    'nisn' => $nisn,
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                    'kelas_id' => $kelas->id,
                    'password_changed' => true,
                ]
            );
        }

        // 3. Seed SPMB (50 Pendaftar)
        for ($i = 1; $i <= 50; $i++) {
            $nama = $namaSiswaDepan[array_rand($namaSiswaDepan)].' '.$namaSiswaBelakang[array_rand($namaSiswaBelakang)];
            $nomorPendaftaran = 'SPMB-2026-'.str_pad($i, 3, '0', STR_PAD_LEFT);

            Spmb::updateOrCreate(
                ['nomor_pendaftaran' => $nomorPendaftaran],
                [
                    'nama_lengkap' => $nama,
                    'gender' => $i % 2 == 0 ? 'perempuan' : 'laki-laki',
                    'tempat_lahir' => 'Bahorok',
                    'tanggal_lahir' => '2010-03-'.str_pad(($i % 28) + 1, 2, '0', STR_PAD_LEFT),
                    'nisn' => '987'.str_pad($i, 7, '0', STR_PAD_LEFT),
                    'nik' => '1207'.str_pad($i, 12, '0', STR_PAD_LEFT),
                    'agama' => 'Islam',
                    'email' => 'pendaftar'.$i.'@example.com',
                    'telepon' => '0812'.rand(10000000, 99999999),
                    'alamat' => 'Jl. Pembangunan No. '.$i.', Bahorok',
                    'kota' => 'Langkat',
                    'provinsi' => 'Sumatera Utara',
                    'nama_ayah' => 'Ayah '.$nama,
                    'pekerjaan_ayah' => 'Wiraswasta',
                    'nama_ibu' => 'Ibu '.$nama,
                    'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                    'telepon_ortu' => '0813'.rand(10000000, 99999999),
                    'asal_sekolah' => 'SMP Negeri '.(($i % 5) + 1).' Bahorok',
                    'nilai_rata' => rand(75, 98) + (rand(0, 99) / 100),
                    'tahun_lulus' => 2026,
                    'program' => $programList[array_rand($programList)],
                    'jalur_pendaftaran' => ['Zonasi', 'Prestasi', 'Afirmasi'][array_rand(['Zonasi', 'Prestasi', 'Afirmasi'])],
                    'status' => ['Menunggu Verifikasi', 'Terverifikasi', 'Diterima', 'Ditolak'][array_rand(['Menunggu Verifikasi', 'Terverifikasi', 'Diterima', 'Ditolak'])],
                ]
            );
        }

        // 4. Seed Berita (50 Berita)
        $adminUser = User::where('role', 'admin')->first();
        $adminId = $adminUser ? $adminUser->id : null;
        $topikBerita = ['Prestasi Gemilang', 'Kegiatan Ekstrakurikuler', 'Penyuluhan Kesehatan', 'Porseni Antar Kelas', 'Pelatihan Olimpiade Sains', 'Kunjungan Edukatif', 'Ujian Sekolah Berbasis Digital', 'Peringatan Hari Besar Nasional'];
        for ($i = 1; $i <= 50; $i++) {
            $judul = $topikBerita[array_rand($topikBerita)].' '.$i.' - SMA/SMK Pemda Bahorok';
            Berita::updateOrCreate(
                ['slug' => Str::slug($judul)],
                [
                    'judul' => $judul,
                    'ringkasan' => 'Ringkasan informasi dan dokumentasi kegiatan '.$judul.' yang sukses diselenggarakan di lingkungan sekolah.',
                    'konten' => 'Dokumentasi lengkap kegiatan '.$judul.' yang melibatkan seluruh siswa dan dewan guru. Acara berlangsung meriah dan penuh antusiasme dari awal hingga selesai.',
                    'status' => 'terbit',
                    'diterbitkan_pada' => now()->subDays(rand(1, 100)),
                    'penulis_id' => $adminId,
                ]
            );
        }

        // 5. Seed Agenda (50 Agenda)
        $kegiatanAgenda = ['Rapat Guru', 'Ujian Harian', 'Praktek Laboratorium', 'Bimbingan Konseling', 'Pramuka', 'Paskibra', 'Rohis', 'Ujian Praktik'];
        for ($i = 1; $i <= 50; $i++) {
            $judul = $kegiatanAgenda[array_rand($kegiatanAgenda)].' Periode '.$i;
            $mulai = now()->addDays($i - 25)->setTime(8, 0);
            Agenda::updateOrCreate(
                ['judul' => $judul],
                [
                    'deskripsi' => 'Kegiatan terjadwal resmi untuk mendukung pengembangan akademik dan karakter siswa.',
                    'lokasi' => 'Aula / Ruang Kelas / Lapangan Utama',
                    'mulai' => $mulai,
                    'selesai' => $mulai->copy()->addHours(2),
                ]
            );
        }

        // 6. Seed Galeri (50 Galeri Foto)
        $albumList = ['Kegiatan Sekolah', 'Fasilitas', 'Prestasi', 'Ekstrakurikuler'];
        for ($i = 1; $i <= 50; $i++) {
            Galeri::updateOrCreate(
                ['judul' => 'Dokumentasi Dokumentasi Kegiatan '.$i],
                [
                    'album' => $albumList[array_rand($albumList)],
                    'keterangan' => 'Foto dokumentasi resmi kegiatan sekolah tahun ajaran 2026/2027.',
                ]
            );
        }

        // 7. Seed Tugas (50 Tugas)
        $mapelList = ['Matematika', 'Fasilitas', 'Bahasa Indonesia', 'Bahasa Inggris', 'Biologi', 'Kimia', 'Fisika', 'Sejarah', 'Ekonomi', 'Geografi'];
        $guruFirst = $guruList[0];
        for ($i = 1; $i <= 50; $i++) {
            $kelas = $kelasList[array_rand($kelasList)];
            Tugas::updateOrCreate(
                ['judul' => 'Lembar Kerja Mandiri Bab '.$i, 'kelas_id' => $kelas->id],
                [
                    'deskripsi' => 'Kerjakan soal latihan secara teliti dan kumpulkan sebelum tenggat waktu berakhir.',
                    'mata_pelajaran' => $mapelList[array_rand($mapelList)],
                    'guru_id' => $guruFirst->id,
                    'prioritas' => ['rendah', 'sedang', 'tinggi'][array_rand(['rendah', 'sedang', 'tinggi'])],
                    'tenggat' => now()->addDays(rand(1, 14))->setTime(23, 59),
                ]
            );
        }

        // 8. Seed Roster (50 Roster Jadwal Pelajaran)
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        for ($i = 1; $i <= 50; $i++) {
            $kelas = $kelasList[array_rand($kelasList)];
            $guru = $guruList[array_rand($guruList)];
            Roster::updateOrCreate(
                [
                    'kelas_id' => $kelas->id,
                    'hari' => $hariList[array_rand($hariList)],
                    'jam_mulai' => '07:30',
                ],
                [
                    'mata_pelajaran' => $mapelList[array_rand($mapelList)],
                    'guru_id' => $guru->id,
                    'jam_selesai' => '09:00',
                    'tahun_ajaran' => '2026/2027',
                    'semester' => 'Genap',
                ]
            );
        }

        // 9. Seed Absensi (50 Absensi Kelas)
        for ($i = 1; $i <= 50; $i++) {
            $kelas = $kelasList[array_rand($kelasList)];
            $tanggal = now()->subDays($i)->format('Y-m-d');

            Absensi::updateOrCreate(
                [
                    'kelas' => $kelas->nama,
                    'tanggal' => $tanggal,
                ],
                [
                    'data_kehadiran' => [1 => 'Hadir', 2 => 'Sakit', 3 => 'Izin'],
                ]
            );
        }
    }
}
