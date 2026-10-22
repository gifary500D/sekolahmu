<?php

namespace Database\Factories;

use App\Models\Spmb;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spmb>
 */
class SpmbFactory extends Factory
{
    protected $model = Spmb::class;

    public function definition(): array
    {
        return [
            'nomor_pendaftaran' => Spmb::generateNomorPendaftaran(),
            'nama_lengkap' => fake()->name(),
            'gender' => fake()->randomElement(['laki-laki', 'perempuan']),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->dateTimeBetween('-20 years', '-12 years')->format('Y-m-d'),
            'nisn' => fake()->unique()->numerify('##########'),
            'nik' => fake()->unique()->numerify('################'),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'email' => fake()->unique()->safeEmail(),
            'telepon' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'kota' => fake()->city(),
            'provinsi' => fake()->state(),
            'nama_ayah' => fake()->name('male'),
            'pekerjaan_ayah' => fake()->jobTitle(),
            'nama_ibu' => fake()->name('female'),
            'pekerjaan_ibu' => fake()->jobTitle(),
            'telepon_ortu' => fake()->numerify('08##########'),
            'asal_sekolah' => fake()->company().' School',
            'nilai_rata' => fake()->randomFloat(2, 60, 100),
            'tahun_lulus' => fake()->numberBetween(2020, (int) date('Y')),
            'program' => fake()->randomElement(['ipa', 'ips', 'bahasa']),
            'jalur_pendaftaran' => fake()->randomElement([
                'Zonasi',
                'Afirmasi',
                'Prestasi',
                'Perpindahan Tugas',
            ]),
            'berkas_ijazah_skl' => null,
            'berkas_kk' => null,
            'berkas_rapor' => null,
            'status' => 'menunggu',
        ];
    }
}
