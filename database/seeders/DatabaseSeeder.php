<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: akun dan kelas dulu, baru tugas dan konten.
        $this->call([
            DemoSekolahSeeder::class,
            TugasKontenSeeder::class,
        ]);
    }
}
