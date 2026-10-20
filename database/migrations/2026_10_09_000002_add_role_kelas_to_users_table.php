<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // admin | guru | siswa | kepala_sekolah
            $table->string('role', 20)->default('siswa')->index();
            // Kelas siswa. Sengaja tanpa foreign key agar kompatibel di MySQL maupun SQLite (pengujian).
            $table->unsignedBigInteger('kelas_id')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['kelas_id']);
            $table->dropColumn(['role', 'kelas_id']);
        });
    }
};
