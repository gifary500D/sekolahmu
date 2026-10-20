<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Akun, kelas, pendaftar PPDB, dan absensi demonstrasi. SELURUH DATA FIKTIF, tanpa emoji.
 * Kata sandi semua akun demo: "password". Aman dijalankan berulang.
 */
class DemoSekolahSeeder extends Seeder
{
    private const SISWA = [
        'X IPA 1' => ['Adi Pratama', 'Bunga Lestari', 'Citra Maharani', 'Dimas Saputra', 'Eka Wulandari', 'Fajar Ramadhan'],
        'X IPA 2' => ['Gita Permata', 'Hadi Kurniawan', 'Indah Safitri', 'Joko Santoso', 'Kartika Dewi', 'Lukman Hakim'],
    ];

    public function run(): void
    {
        $kelas = collect(array_keys(self::SISWA))->mapWithKeys(
            fn ($nama) => [$nama => Kelas::firstOrCreate(['nama' => $nama])]
        );

        $this->staf();
        $this->siswa($kelas);
        $this->spmb();
        $this->absensi($kelas);
    }

    private function staf(): void
    {
        $akun = [
            ['Admin Sekolah', 'admin@sekolahku.test', 'admin'],
            ['Kepala Sekolah Contoh', 'kepsek@sekolahku.test', 'kepala_sekolah'],
            ['Guru Matematika Contoh', 'guru1@sekolahku.test', 'guru'],
            ['Guru Bahasa Contoh', 'guru2@sekolahku.test', 'guru'],
        ];

        foreach ($akun as [$nama, $email, $role]) {
            User::updateOrCreate(['email' => $email], [
                'name' => $nama, 'password' => 'password', 'role' => $role, 'kelas_id' => null,
                'email_verified_at' => now(),
            ]);
        }
    }

    private function siswa($kelas): void
    {
        foreach (self::SISWA as $namaKelas => $daftar) {
            foreach ($daftar as $i => $nama) {
                $email = 'siswa' . ($namaKelas === 'X IPA 1' ? '1' : '2') . ($i + 1) . '@sekolahku.test';
                User::updateOrCreate(['email' => $email], [
                    'name' => $nama, 'password' => 'password', 'role' => 'siswa',
                    'kelas_id' => $kelas[$namaKelas]->id, 'email_verified_at' => now(),
                ]);
            }
        }
    }

    private function spmb(): void
    {
        // [nama, gender, program, jalur, status, catatan]
        $data = [
            ['Rina Anggraini', 'perempuan', 'ipa', 'Zonasi', 'menunggu', null],
            ['Samuel Hutapea', 'laki-laki', 'ips', 'Prestasi', 'diverifikasi', null],
            ['Tiara Nasution', 'perempuan', 'bahasa', 'Afirmasi', 'perlu_perbaikan', 'Lengkapi data pekerjaan orang tua.'],
            ['Umar Siregar', 'laki-laki', 'ipa', 'Zonasi', 'lulus', 'Silakan daftar ulang sesuai jadwal.'],
            ['Vina Marpaung', 'perempuan', 'ips', 'Perpindahan Tugas', 'tidak_lulus', null],
            ['Wahyu Hidayat', 'laki-laki', 'ipa', 'Prestasi', 'menunggu', null],
        ];

        foreach ($data as $n => [$nama, $gender, $program, $jalur, $status, $catatan]) {
            $urut = $n + 1;
            $nisn = sprintf('00812%05d', $urut);

            $spmb = Spmb::firstOrNew(['nisn' => $nisn]);
            if (! $spmb->exists) {
                $spmb->nomor_pendaftaran = Spmb::buatNomor();
            }
            $spmb->fill([
                'nama_lengkap' => $nama, 'gender' => $gender, 'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2011-0' . (($urut % 9) + 1) . '-1' . $urut,
                'nik' => sprintf('1275%012d', $urut), 'agama' => 'Islam',
                'email' => 'pendaftar' . $urut . '@contoh.test', 'telepon' => '0812000000' . $urut,
                'alamat' => 'Jl. Contoh No. ' . $urut . ', Medan', 'kota' => 'Medan', 'provinsi' => 'Sumatera Utara',
                'nama_ayah' => 'Ayah ' . explode(' ', $nama)[0], 'pekerjaan_ayah' => 'Wiraswasta',
                'nama_ibu' => 'Ibu ' . explode(' ', $nama)[0], 'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon_ortu' => '0813000000' . $urut, 'asal_sekolah' => 'SMP Negeri ' . $urut . ' Medan',
                'nilai_rata' => 80 + $urut * 2.5, 'tahun_lulus' => (int) date('Y'),
                'program' => $program, 'jalur_pendaftaran' => $jalur,
                'status' => $status, 'catatan' => $catatan,
            ])->save();
        }
    }

    private function absensi($kelas): void
    {
        $pola = ['hadir', 'hadir', 'hadir', 'hadir', 'izin', 'hadir', 'sakit', 'hadir', 'hadir', 'alpa', 'hadir', 'hadir'];
        $guru = User::where('email', 'guru1@sekolahku.test')->value('id');

        foreach ($kelas as $k) {
            $siswa = User::where('role', 'siswa')->where('kelas_id', $k->id)->orderBy('id')->get();
            $hari = 0;
            $selisih = 1;

            // 5 hari sekolah terakhir (Senin sampai Jumat)
            while ($hari < 5) {
                $tanggal = Carbon::today()->subDays($selisih++);
                if ($tanggal->isWeekend()) {
                    continue;
                }

                $sesi = Absensi::updateOrCreate(
                    ['kelas_id' => $k->id, 'tanggal' => $tanggal->toDateString()],
                    ['dicatat_oleh' => $guru]
                );
                foreach ($siswa as $i => $s) {
                    $sesi->detail()->updateOrCreate(
                        ['siswa_id' => $s->id],
                        ['status' => $pola[($i * 3 + $hari) % count($pola)]]
                    );
                }
                $hari++;
            }
        }
    }
}
