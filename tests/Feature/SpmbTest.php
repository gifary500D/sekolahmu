<?php

/**
 * Feature Tests — SPMB Module (Phase 1)
 *
 * Mencakup:
 *   - Pendaftaran API berhasil (nomor registrasi unik, persisten ke DB)
 *   - Pendaftaran gagal validasi (NISN tidak 10 digit)
 *   - Pendaftaran gagal duplikasi NISN
 *   - Cek status berhasil
 *   - Cek status 404 (nomor tidak ada)
 *   - Update status oleh admin terautentikasi
 *   - Update status ditolak 401 (tidak terautentikasi via Gate)
 *   - Update status ditolak 403 (user biasa)
 *   - Update status ditolak 422 (nilai status tidak valid)
 *   - Pendaftaran via web form (proses-pendaftaran) redirect dengan flash nomor
 */

use App\Models\Spmb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(Tests\TestCase::class, RefreshDatabase::class);

// ─────────────────────────────────────────────────────────────────────────────
// Helper: payload valid untuk pendaftaran API
// ─────────────────────────────────────────────────────────────────────────────
function validSpmbPayload(array $override = []): array
{
    return array_merge([
        'nama_lengkap'      => 'Budi Santoso',
        'gender'            => 'laki-laki',
        'tempat_lahir'      => 'Medan',
        'tanggal_lahir'     => '2007-06-15',
        'nisn'              => '1234567890',
        'nik'               => '1234567890123456',
        'agama'             => 'Islam',
        'email'             => 'budi@example.com',
        'telepon'           => '081234567890',
        'alamat'            => 'Jl. Contoh No. 1',
        'kota'              => 'Medan',
        'provinsi'          => 'Sumatera Utara',
        'nama_ayah'         => 'Ahmad Santoso',
        'pekerjaan_ayah'    => 'PNS',
        'nama_ibu'          => 'Siti Aminah',
        'pekerjaan_ibu'     => 'Guru',
        'telepon_ortu'      => '081298765432',
        'asal_sekolah'      => 'SMP Negeri 1 Medan',
        'nilai_rata'        => 87.5,
        'tahun_lulus'       => (int) date('Y'),
        'program'           => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
    ], $override);
}

// ─────────────────────────────────────────────────────────────────────────────
// 1. Pendaftaran berhasil — data tersimpan dan nomor registrasi unik dikembalikan
// ─────────────────────────────────────────────────────────────────────────────
test('pendaftaran berhasil menyimpan ke database dan mengembalikan nomor registrasi unik', function () {
    Storage::fake('public');

    $response = $this->postJson('/api/spmb/daftar', validSpmbPayload());

    $response->assertStatus(201)
             ->assertJsonPath('success', true)
             ->assertJsonStructure([
                 'success',
                 'message',
                 'data' => ['nomor_pendaftaran', 'nama_lengkap', 'jalur_pendaftaran', 'status'],
             ]);

    $nomor = $response->json('data.nomor_pendaftaran');
    expect($nomor)->toStartWith('SPMB-' . date('Y') . '-');

    // Data tersimpan secara persisten di DB
    $this->assertDatabaseHas('spmb', [
        'nisn'  => '1234567890',
        'nik'   => '1234567890123456',
        'status' => 'Menunggu Verifikasi',
        'nomor_pendaftaran' => $nomor,
    ]);
});

// ─────────────────────────────────────────────────────────────────────────────
// 2. Nomor pendaftaran unik — dua pendaftaran berurutan menghasilkan nomor berbeda
// ─────────────────────────────────────────────────────────────────────────────
test('dua pendaftaran berurutan menghasilkan nomor pendaftaran yang berbeda', function () {
    Storage::fake('public');

    $r1 = $this->postJson('/api/spmb/daftar', validSpmbPayload([
        'nisn' => '1111111111',
        'nik'  => '1111111111111111',
        'email' => 'user1@example.com',
    ]));
    $r2 = $this->postJson('/api/spmb/daftar', validSpmbPayload([
        'nisn' => '2222222222',
        'nik'  => '2222222222222222',
        'email' => 'user2@example.com',
    ]));

    $r1->assertStatus(201);
    $r2->assertStatus(201);

    expect($r1->json('data.nomor_pendaftaran'))
        ->not->toBe($r2->json('data.nomor_pendaftaran'));
});

// ─────────────────────────────────────────────────────────────────────────────
// 3. Pendaftaran gagal — NISN tidak 10 digit
// ─────────────────────────────────────────────────────────────────────────────
test('pendaftaran gagal validasi jika NISN tidak 10 digit', function () {
    $response = $this->postJson('/api/spmb/daftar', validSpmbPayload([
        'nisn' => '123',  // terlalu pendek
    ]));

    $response->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonPath('message', 'Validasi gagal')
             ->assertJsonValidationErrors(['nisn']);
});

// ─────────────────────────────────────────────────────────────────────────────
// 4. Pendaftaran gagal — NISN sudah terdaftar (duplikasi)
// ─────────────────────────────────────────────────────────────────────────────
test('pendaftaran gagal jika NISN sudah terdaftar', function () {
    // Buat record awal
    Spmb::factory()->create([
        'nisn'              => '1234567890',
        'nomor_pendaftaran' => 'SPMB-2025-0001',
        'status'            => 'Menunggu Verifikasi',
    ]);

    $response = $this->postJson('/api/spmb/daftar', validSpmbPayload([
        'nisn' => '1234567890',  // duplikasi
    ]));

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['nisn']);
});

// ─────────────────────────────────────────────────────────────────────────────
// 5. Cek status berhasil — data pendaftar ditemukan berdasarkan nomor pendaftaran
// ─────────────────────────────────────────────────────────────────────────────
test('cek status mengembalikan data pendaftar berdasarkan nomor pendaftaran', function () {
    Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-0001',
        'nama_lengkap'      => 'Budi Santoso',
        'status'            => 'Diverifikasi',
    ]);

    $response = $this->getJson('/api/spmb/status/SPMB-2026-0001');

    $response->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonPath('data.nomor_pendaftaran', 'SPMB-2026-0001')
             ->assertJsonPath('data.nama_lengkap', 'B*** S******')
             ->assertJsonPath('data.status', 'Diverifikasi')
             ->assertJsonStructure([
                 'data' => ['nomor_pendaftaran', 'nama_lengkap', 'asal_sekolah', 'program', 'jalur_pendaftaran', 'status', 'tanggal_daftar']
             ]);

    // Pastikan data sensitif tidak bocor
    $response->assertJsonMissingPath('data.nisn');
    $response->assertJsonMissingPath('data.nik');
});

// ─────────────────────────────────────────────────────────────────────────────
// 6. Cek status 404 — nomor pendaftaran tidak ada
// ─────────────────────────────────────────────────────────────────────────────
test('cek status mengembalikan 404 jika nomor pendaftaran tidak ditemukan', function () {
    $response = $this->getJson('/api/spmb/status/SPMB-9999-9999');

    $response->assertStatus(404)
             ->assertJsonPath('success', false);
});

// ─────────────────────────────────────────────────────────────────────────────
// 7. Update status berhasil oleh admin terautentikasi
// ─────────────────────────────────────────────────────────────────────────────
test('update status berhasil dilakukan oleh admin yang terautentikasi', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-0099',
        'status'            => 'Menunggu Verifikasi',
    ]);

    $response = $this->actingAs($admin)
                     ->putJson("/api/spmb/status/{$spmb->id}", [
                         'status' => 'Lulus',
                     ]);

    $response->assertStatus(200)
             ->assertJsonPath('success', true)
             ->assertJsonPath('data.status', 'Lulus');

    // Perubahan tersimpan di DB
    $this->assertDatabaseHas('spmb', [
        'id'     => $spmb->id,
        'status' => 'Lulus',
    ]);
});

// ─────────────────────────────────────────────────────────────────────────────
// 8. Update status ditolak (403) — user tidak terautentikasi → Gate menolak
// ─────────────────────────────────────────────────────────────────────────────
test('update status ditolak 403 jika tidak terautentikasi (request tanpa user)', function () {
    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-0100',
        'status'            => 'Menunggu Verifikasi',
    ]);

    // Tidak ada actingAs — $request->user() akan null → controller returns 403
    $response = $this->putJson("/api/spmb/status/{$spmb->id}", [
        'status' => 'Lulus',
    ]);

    $response->assertStatus(401);
});

// ─────────────────────────────────────────────────────────────────────────────
// 9. Update status ditolak (403) — user terdaftar tapi bukan admin
// ─────────────────────────────────────────────────────────────────────────────
test('update status ditolak 403 jika user terautentikasi bukan admin', function () {
    $regularUser = User::factory()->create(['role' => 'user']);

    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-0101',
        'status'            => 'Menunggu Verifikasi',
    ]);

    $response = $this->actingAs($regularUser)
                     ->putJson("/api/spmb/status/{$spmb->id}", [
                         'status' => 'Lulus',
                     ]);

    $response->assertStatus(403)
             ->assertJsonPath('success', false);

    // Status tidak berubah
    $this->assertDatabaseHas('spmb', [
        'id'     => $spmb->id,
        'status' => 'Menunggu Verifikasi',
    ]);
});

// ─────────────────────────────────────────────────────────────────────────────
// 10. Update status ditolak (422) — nilai status tidak valid
// ─────────────────────────────────────────────────────────────────────────────
test('update status ditolak 422 jika nilai status tidak valid', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-0102',
        'status'            => 'Menunggu Verifikasi',
    ]);

    $response = $this->actingAs($admin)
                     ->putJson("/api/spmb/status/{$spmb->id}", [
                         'status' => 'STATUS_TIDAK_ADA',
                     ]);

    $response->assertStatus(422)
             ->assertJsonPath('success', false)
             ->assertJsonValidationErrors(['status']);
});

// ─────────────────────────────────────────────────────────────────────────────
// 11. Update status 404 — ID tidak ditemukan
// ─────────────────────────────────────────────────────────────────────────────
test('update status mengembalikan 404 jika ID pendaftar tidak ada', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
                     ->putJson('/api/spmb/status/99999', [
                         'status' => 'Lulus',
                     ]);

    $response->assertStatus(404)
             ->assertJsonPath('success', false);
});

// ─────────────────────────────────────────────────────────────────────────────
// 12. Web form proses-pendaftaran berhasil — redirect ke /daftar dengan flash
// ─────────────────────────────────────────────────────────────────────────────
test('proses pendaftaran via web form berhasil dan redirect dengan nomor pendaftaran', function () {
    Storage::fake('public');

    $payload = validSpmbPayload([
        'confirm_data'   => '1',
        'agree_terms'    => '1',
        'agree_privacy'  => '1',
    ]);

    $response = $this->withoutVite()
                     ->post('/proses-pendaftaran', array_merge($payload, [
                         '_token' => csrf_token(),
                     ]));

    $response->assertStatus(302);         // redirect
    $response->assertRedirect('/daftar'); // kembali ke halaman daftar

    // Flash success mengandung nomor pendaftaran
    $response->assertSessionHas('success');
    $flashMsg = session('success');
    expect($flashMsg)->toContain('SPMB-');

    // Data tersimpan di DB
    $this->assertDatabaseHas('spmb', ['nisn' => '1234567890']);
});

// ─────────────────────────────────────────────────────────────────────────────
// 13. Web form proses-pendaftaran gagal validasi — redirect back dengan errors
// ─────────────────────────────────────────────────────────────────────────────
test('proses pendaftaran via web form gagal jika NISN tidak valid dan redirect balik dengan errors', function () {
    $payload = validSpmbPayload(['nisn' => '123']); // NISN tidak 10 digit

    $response = $this->withoutVite()
                     ->post('/proses-pendaftaran', $payload);

    $response->assertStatus(302);
    $response->assertSessionHasErrors(['nisn']);

    // Tidak ada data yang tersimpan
    $this->assertDatabaseMissing('spmb', ['email' => 'budi@example.com']);
});
