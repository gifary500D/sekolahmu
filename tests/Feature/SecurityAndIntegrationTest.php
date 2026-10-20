<?php

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('siswa tidak dapat mengakses dashboard admin (privilege escalation blocked)', function () {
    $siswa = User::factory()->create(['role' => 'siswa']);

    $response = $this->actingAs($siswa)->get('/dashboard/admin/pengguna');
    $response->assertStatus(403);

    $response2 = $this->actingAs($siswa)->post('/dashboard/admin/pengguna/simpan', [
        'name' => 'Hacker Admin',
        'email' => 'hacker@example.com',
        'password' => 'secret1234',
        'role' => 'admin',
    ]);
    $response2->assertStatus(403);
});

test('admin dapat mengakses dashboard admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->withoutVite()->actingAs($admin)->get('/dashboard/admin/spmb');
    $response->assertStatus(200);
});

test('siswa tidak dapat mengakses endpoint aksi guru', function () {
    $siswa = User::factory()->create(['role' => 'siswa']);

    $response = $this->actingAs($siswa)->get('/dashboard/guru/tugas');
    $response->assertStatus(403);
});

test('guru dapat mengakses rute manajemen guru', function () {
    $guru = User::factory()->create(['role' => 'guru']);

    $response = $this->withoutVite()->actingAs($guru)->get('/dashboard/guru/tugas');
    $response->assertStatus(200);
});

test('api tugas dapat membuat tugas dengan skema database yang valid', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guru->id]);

    $response = $this->actingAs($guru, 'sanctum')->postJson('/api/tugas/buat', [
        'judul_tugas' => 'Tugas Fisika Dasar',
        'deskripsi' => 'Kerjakan soal halaman 20',
        'kelas' => 'X-IPA-1',
        'tenggat_waktu' => now()->addDays(5)->toDateTimeString(),
        'prioritas' => 'Tinggi',
    ]);

    $response->assertStatus(201)
             ->assertJsonPath('success', true)
             ->assertJsonPath('data.judul', 'Tugas Fisika Dasar')
             ->assertJsonPath('data.prioritas', 'tinggi');

    $this->assertDatabaseHas('tugas', [
        'judul' => 'Tugas Fisika Dasar',
        'prioritas' => 'tinggi',
        'kelas_id' => $kelas->id,
    ]);
});

test('api tugas daftarTugas dapat memuat tugas per kelas', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guru->id]);

    Tugas::create([
        'judul' => 'Tugas Kimia',
        'deskripsi' => 'Laporan praktikum',
        'kelas_id' => $kelas->id,
        'guru_id' => $guru->id,
        'tenggat' => now()->addDays(3),
        'prioritas' => 'sedang',
    ]);

    $response = $this->actingAs($guru, 'sanctum')->getJson('/api/tugas/kelas/X-IPA-1');
    $response->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonCount(1, 'data');
});

test('relasi statusSiswa pada model Tugas berfungsi dengan baik', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guru->id]);
    $tugas = Tugas::create([
        'judul' => 'Tugas Biologi',
        'deskripsi' => 'Observasi tanaman',
        'kelas_id' => $kelas->id,
        'guru_id' => $guru->id,
        'tenggat' => now()->addDays(2),
        'prioritas' => 'sedang',
    ]);

    expect($tugas->statusSiswa)->toBeIterable();
});

test('halaman company profile dapat diakses publik', function () {
    $this->withoutVite();

    $this->get('/tentang')->assertStatus(200);
    $this->get('/fasilitas')->assertStatus(200);
    $this->get('/guru')->assertStatus(200);
});
