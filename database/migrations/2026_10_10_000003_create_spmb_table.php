<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spmb', function (Blueprint $table) {
            $table->id();
            // 8 karakter acak agar sulit ditebak (bagian 6 dan 7 blueprint)
            $table->string('nomor_pendaftaran', 8)->unique();

            // Data pribadi
            $table->string('nama_lengkap');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nisn', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('agama', 50);

            // Kontak dan alamat
            $table->string('email');
            $table->string('telepon', 20);
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('provinsi', 100);

            // Orang tua
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('telepon_ortu', 20);

            // Pendidikan dan jalur
            $table->string('asal_sekolah');
            $table->decimal('nilai_rata', 5, 2);
            $table->unsignedSmallInteger('tahun_lulus');
            $table->enum('program', ['ipa', 'ips', 'bahasa']);
            $table->enum('jalur_pendaftaran', ['Zonasi', 'Afirmasi', 'Prestasi', 'Perpindahan Tugas']);

            // Berkas (belum ada fitur unggah; kolom disiapkan)
            $table->string('berkas_ijazah_skl')->nullable();
            $table->string('berkas_kk')->nullable();
            $table->string('berkas_rapor')->nullable();

            // Alur status: menunggu, diverifikasi, perlu_perbaikan, lulus, tidak_lulus
            $table->enum('status', ['menunggu', 'diverifikasi', 'perlu_perbaikan', 'lulus', 'tidak_lulus'])
                ->default('menunggu')->index();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmb');
    }
};
