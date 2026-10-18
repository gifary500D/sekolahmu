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
            $table->string('nomor_pendaftaran')->unique();

            // Data Pribadi
            $table->string('nama_lengkap');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nisn', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('agama');

            // Data Kontak & Alamat
            $table->string('email');
            $table->string('telepon', 20);
            $table->text('alamat');
            $table->string('kota');
            $table->string('provinsi');

            // Data Orang Tua
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('telepon_ortu', 20);

            // Data Pendidikan & Jalur
            $table->string('asal_sekolah');
            $table->decimal('nilai_rata', 5, 2);
            $table->year('tahun_lulus');
            $table->enum('program', ['ipa', 'ips', 'bahasa']);
            $table->enum('jalur_pendaftaran', ['Zonasi', 'Afirmasi', 'Prestasi', 'Perpindahan Tugas']);

            // Berkas Lampiran
            $table->string('berkas_ijazah_skl')->nullable();
            $table->string('berkas_kk')->nullable();
            $table->string('berkas_rapor')->nullable();

            $table->string('status')->default('Menunggu Verifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spmb');
    }
};
