<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('tingkat', 10)->nullable(); // X, XI, XII
            $table->string('program', 20)->nullable(); // IPA, IPS, Bahasa, Umum
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['wali_kelas_id']);
            $table->dropColumn(['tingkat', 'program', 'wali_kelas_id']);
        });
    }
};
