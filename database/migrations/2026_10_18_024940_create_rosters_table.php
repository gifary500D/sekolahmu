<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->string('mata_pelajaran');
            $table->foreignId('guru_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('hari'); // Senin, Selasa, Rabu, Kamis, Jumat, Sabtu
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('tahun_ajaran')->default('2026/2027');
            $table->string('semester')->default('Ganjil');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rosters');
    }
};
