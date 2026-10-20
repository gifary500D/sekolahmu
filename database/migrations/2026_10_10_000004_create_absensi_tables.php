<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Satu baris = satu sesi absensi (satu kelas pada satu tanggal)
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->date('tanggal');
            $table->foreignId('dicatat_oleh')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['kelas_id', 'tanggal']);
        });

        // Satu baris = status kehadiran satu siswa pada satu sesi
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained('absensi')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
            $table->string('keterangan', 150)->nullable();
            $table->timestamps();
            $table->unique(['absensi_id', 'siswa_id']);
            $table->index('siswa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_detail');
        Schema::dropIfExists('absensi');
    }
};
