<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('kelas', 50);          // Contoh: "2SI/B"
            $table->date('tanggal');              // Tanggal absensi
            $table->json('data_kehadiran');       // Menyimpan daftar siswa & statusnya dalam format JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};