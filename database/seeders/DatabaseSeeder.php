<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with production-ready data (50 records per table).
     */
    public function run(): void
    {
        $this->call([
            ProductionSeeder::class,
        ]);
    }
}
