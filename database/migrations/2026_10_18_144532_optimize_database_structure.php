<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 2. Indexing
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'kelas_id']);
            $table->index('nisn');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->index(['kelas_id', 'guru_id']);
            $table->index('tenggat');
        });

        Schema::table('tugas_siswa', function (Blueprint $table) {
            $table->index(['tugas_id', 'siswa_id']);
            $table->index('status');
        });

        // 7. Soft Deletes
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['role', 'kelas_id']);
            $table->dropIndex(['nisn']);
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->dropIndex(['kelas_id', 'guru_id']);
            $table->dropIndex(['tenggat']);
        });

        Schema::table('tugas_siswa', function (Blueprint $table) {
            $table->dropIndex(['tugas_id', 'siswa_id']);
            $table->dropIndex(['status']);
        });
    }
};
