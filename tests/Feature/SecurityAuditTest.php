<?php

use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('skenario 1: siswa tidak dapat mengakses atau mengunduh berkas tugas siswa lain', function () {
    Storage::fake('local');

    $guru = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
    $kelas = Kelas::create([
        'nama' => 'XII-IPA-1',
        'tingkat' => '12',
        'program' => 'ipa',
        'wali_kelas_id' => $guru->id,
    ]);

    $siswa1 = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelas->id,
        'password_changed' => true,
    ]);

    $siswa2 = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelas->id,
        'password_changed' => true,
    ]);

    $tugas = Tugas::create([
        'judul' => 'Tugas Mandiri Kimia',
        'mata_pelajaran' => 'Kimia',
        'kelas_id' => $kelas->id,
        'guru_id' => $guru->id,
        'tenggat' => now()->addDays(2),
        'prioritas' => 'sedang',
    ]);

    // Simpan berkas tugas siswa 1 di storage privat local
    $filePath = 'private/tugas/tugas_siswa1_' . time() . '.pdf';
    Storage::disk('local')->put($filePath, 'konten tugas siswa 1');

    $submissionSiswa1 = TugasSiswa::create([
        'tugas_id' => $tugas->id,
        'siswa_id' => $siswa1->id,
        'status' => 'selesai',
        'file_path' => $filePath,
        'diselesaikan_pada' => now(),
    ]);

    // Siswa 2 mencoba mengunduh berkas tugas milik Siswa 1
    $response = $this->actingAs($siswa2)->get(route('siswa.tugas.download', $submissionSiswa1->id));
    $response->assertStatus(403);

    // Siswa 1 mengunduh berkasnya sendiri (diizinkan)
    $responseOwner = $this->actingAs($siswa1)->get(route('siswa.tugas.download', $submissionSiswa1->id));
    $responseOwner->assertOk();
});

test('skenario 2: guru tidak dapat mengelola atau mengakses kelas yang bukan tanggung jawabnya', function () {
    Storage::fake('local');

    $guru1 = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
    $guru2 = User::factory()->create(['role' => 'guru', 'password_changed' => true]);

    $kelas1 = Kelas::create([
        'nama' => 'X-IPA-A',
        'tingkat' => '10',
        'program' => 'ipa',
        'wali_kelas_id' => $guru1->id,
    ]);

    $kelas2 = Kelas::create([
        'nama' => 'X-IPA-B',
        'tingkat' => '10',
        'program' => 'ipa',
        'wali_kelas_id' => $guru2->id,
    ]);

    // Guru 1 mencoba membuat tugas untuk kelas 2 yang bukan tanggung jawabnya
    $responseCreate = $this->actingAs($guru1)->post(route('guru.tugas.store'), [
        'judul' => 'Tugas Ilegal Lintas Kelas',
        'mata_pelajaran' => 'Fisika',
        'kelas_id' => $kelas2->id,
        'tenggat' => now()->addDays(3)->toDateTimeString(),
        'prioritas' => 'sedang',
        'deskripsi' => 'Uji coba unauthorized',
    ]);
    $responseCreate->assertStatus(403);

    // Guru 2 memiliki tugas di kelas 2
    $tugasKelas2 = Tugas::create([
        'judul' => 'Tugas Legal Guru 2',
        'mata_pelajaran' => 'Biologi',
        'kelas_id' => $kelas2->id,
        'guru_id' => $guru2->id,
        'tenggat' => now()->addDays(2),
        'prioritas' => 'sedang',
    ]);

    $siswaKelas2 = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelas2->id, 'password_changed' => true]);
    $filePath = 'private/tugas/tugas_k2.pdf';
    Storage::disk('local')->put($filePath, 'konten tugas kelas 2');

    $submission = TugasSiswa::create([
        'tugas_id' => $tugasKelas2->id,
        'siswa_id' => $siswaKelas2->id,
        'status' => 'selesai',
        'file_path' => $filePath,
    ]);

    // Guru 1 mencoba melihat submissions tugas Guru 2
    $this->actingAs($guru1)->get(route('guru.tugas.submissions', $tugasKelas2->id))->assertStatus(403);

    // Guru 1 mencoba mengunduh berkas pengumpulan tugas Guru 2
    $this->actingAs($guru1)->get(route('guru.tugas.download', $submission->id))->assertStatus(403);

    // Guru 1 mencoba mengekspor rekap absensi kelas 2
    $this->actingAs($guru1)->get(route('guru.absensi.export', ['kelas' => $kelas2->nama]))->assertStatus(403);
});

test('skenario 3: dokumen tugas dan SPMB terlindungi di storage privat tanpa fallback disk public', function () {
    Storage::fake('local');
    Storage::fake('public');

    $admin = User::factory()->create(['role' => 'admin', 'password_changed' => true]);
    $siswa = User::factory()->create(['role' => 'siswa', 'password_changed' => true]);

    $spmb = Spmb::factory()->create([
        'berkas_ijazah_skl' => 'spmb/ijazah/dokumen_rahasia.pdf',
    ]);

    // Simpan berkas HANYA di disk public (tidak ada di disk local)
    Storage::disk('public')->put('spmb/ijazah/dokumen_rahasia.pdf', 'dokumen palsu public');

    // Siswa atau publik mencoba mengakses dokumen SPMB admin -> ditolak
    $this->get(route('admin.spmb.berkas', ['id' => $spmb->id, 'jenis' => 'ijazah']))->assertRedirect('/login');
    $this->actingAs($siswa)->get(route('admin.spmb.berkas', ['id' => $spmb->id, 'jenis' => 'ijazah']))->assertStatus(403);

    // Admin mencoba mengunduh berkas yang hanya ada di public (karena fallback public dihapus, wajib 404)
    $this->actingAs($admin)->get(route('admin.spmb.berkas', ['id' => $spmb->id, 'jenis' => 'ijazah']))->assertStatus(404);

    // Ketika disimpan di disk privat 'local', admin dapat mengunduhnya dengan aman
    Storage::disk('local')->put('spmb/ijazah/dokumen_rahasia.pdf', 'dokumen sah privat');
    $responseAdmin = $this->actingAs($admin)->get(route('admin.spmb.berkas', ['id' => $spmb->id, 'jenis' => 'ijazah']));
    $responseAdmin->assertOk();
});

test('skenario 4: eskalasi hak akses (privilege escalation) dicegah pada seluruh peran', function () {
    $siswa = User::factory()->create(['role' => 'siswa', 'password_changed' => true]);
    $guru = User::factory()->create(['role' => 'guru', 'password_changed' => true]);

    // Siswa dilarang mengakses rute Administrator
    $this->actingAs($siswa)->get('/dashboard/admin/spmb')->assertStatus(403);
    $this->actingAs($siswa)->get('/dashboard/admin/pengguna')->assertStatus(403);
    $this->actingAs($siswa)->get('/dashboard/admin/kelas')->assertStatus(403);

    // Siswa dilarang mengakses rute Guru
    $this->actingAs($siswa)->get('/dashboard/guru/tugas')->assertStatus(403);
    $this->actingAs($siswa)->get('/dashboard/guru/absensi')->assertStatus(403);

    // Guru dilarang mengakses rute Administrator
    $this->actingAs($guru)->get('/dashboard/admin/pengguna')->assertStatus(403);
    $this->actingAs($guru)->get('/dashboard/admin/spmb')->assertStatus(403);

    // Siswa dan Guru dilarang mengubah status verifikasi SPMB melalui API
    $spmb = Spmb::factory()->create();
    Sanctum::actingAs($siswa);
    $this->putJson("/api/spmb/status/{$spmb->id}", ['status' => 'Diterima'])->assertStatus(403);

    Sanctum::actingAs($guru);
    $this->putJson("/api/spmb/status/{$spmb->id}", ['status' => 'Diterima'])->assertStatus(403);
});

test('skenario 5: logout hanya dapat diproses melalui metode POST dengan token CSRF', function () {
    $user = User::factory()->create(['password_changed' => true]);

    // Percobaan logout via GET harus ditolak 405 Method Not Allowed
    $this->actingAs($user);
    $responseGet = $this->get('/logout');
    $responseGet->assertStatus(405);
    $this->assertAuthenticatedAs($user);

    // Logout via POST berhasil dan mengakhiri sesi user
    $responsePost = $this->actingAs($user)->post('/logout');
    $responsePost->assertRedirect('/');
    $this->assertGuest();
});

test('skenario 6: exception server tidak membocorkan detail internal atau pesan mentah', function () {
    Storage::fake('local');

    // Simulasikan pendaftaran via API yang memicu rollback & catch block
    // Buat data dengan NIK yang sengaja bertabrakan di dalam transaksi
    Spmb::factory()->create(['nik' => '9999888877776666']);

    $payload = [
        'nama_lengkap' => 'Calon Uji Exception',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-01-01',
        'nisn' => '1122334455',
        'nik' => '9999888877776666',
        'agama' => 'Islam',
        'email' => 'calon_exception@example.com',
        'telepon' => '081234567890',
        'alamat' => 'Jl. Pendidikan',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak',
        'pekerjaan_ayah' => 'PNS',
        'nama_ibu' => 'Ibu',
        'pekerjaan_ibu' => 'Guru',
        'telepon_ortu' => '081234567891',
        'asal_sekolah' => 'SMP 1 Bahorok',
        'nilai_rata' => 88.0,
        'tahun_lulus' => 2024,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
    ];

    $response = $this->postJson('/api/spmb/daftar', $payload);
    $response->assertStatus(422);

    // Pastikan tidak ada kebocoran string query database atau stack trace
    $content = $response->getContent();
    expect($content)->not->toContain('SQLSTATE')
        ->not->toContain('syntax error')
        ->not->toContain('PDOException')
        ->not->toContain('vendor/');
});

test('skenario 7: akun siswa dengan password_changed false dipaksa mengganti kata sandi', function () {
    $kelas = Kelas::create(['nama' => 'X-1', 'tingkat' => '10', 'program' => 'ipa']);
    $siswa = User::factory()->create([
        'role' => 'siswa',
        'kelas_id' => $kelas->id,
        'password_changed' => false,
    ]);

    // Mengakses dashboard siswa langsung dialihkan ke form ubah password
    $this->actingAs($siswa)->get('/dashboard')->assertRedirect(route('siswa.password.form'));

    // Mengakses fitur siswa lain juga terproteksi middleware password.changed
    $this->actingAs($siswa)->get(route('siswa.tugas'))->assertRedirect(route('siswa.password.form'));
    $this->actingAs($siswa)->get(route('siswa.absensi'))->assertRedirect(route('siswa.password.form'));
    $this->actingAs($siswa)->get(route('siswa.nilai'))->assertRedirect(route('siswa.password.form'));
    $this->actingAs($siswa)->get(route('siswa.roster'))->assertRedirect(route('siswa.password.form'));

    // Form ubah password dapat diakses
    $this->actingAs($siswa)->get(route('siswa.password.form'))->assertOk();

    // Siswa berhasil mengubah kata sandi
    $responseUbah = $this->actingAs($siswa)->post(route('siswa.password.update'), [
        'password' => 'SandiBaru#2026',
        'password_confirmation' => 'SandiBaru#2026',
    ]);
    $responseUbah->assertRedirect(route('dashboard'));

    $siswa->refresh();
    expect($siswa->password_changed)->toBeTrue();
    expect(Hash::check('SandiBaru#2026', $siswa->password))->toBeTrue();

    // Setelah diubah, siswa kini dapat mengakses fitur siswa secara bebas
    $this->actingAs($siswa)->get(route('siswa.tugas'))->assertOk();
    $this->actingAs($siswa)->get(route('siswa.absensi'))->assertOk();
    $this->actingAs($siswa)->get(route('siswa.nilai'))->assertOk();
});

test('skenario 8: endpoint status SPMB mengembalikan data minimal dan validasi nomor ketat', function () {
    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-8888',
        'nama_lengkap' => 'Ahmad Fauzi Rahman',
        'nisn' => '0011223344',
        'status' => 'Lulus Seleksi',
    ]);

    // 1. Format nomor tidak sesuai regex SPMB ditolak 422
    $responseInvalid = $this->getJson('/api/spmb/status/MALICIOUS-INPUT');
    $responseInvalid->assertStatus(422)
                    ->assertJsonPath('success', false)
                    ->assertJsonValidationErrors(['nomor']);

    // 2. Format valid mengembalikan hanya data yang diminimalkan
    $responseValid = $this->getJson('/api/spmb/status/SPMB-2026-8888');
    $responseValid->assertOk()
                  ->assertJsonPath('success', true)
                  ->assertJsonPath('data.nomor_pendaftaran', 'SPMB-2026-8888')
                  ->assertJsonPath('data.nama_lengkap', 'A**** F**** R*****')
                  ->assertJsonPath('data.status', 'Lulus Seleksi')
                  ->assertJsonStructure([
                      'data' => ['nomor_pendaftaran', 'nama_lengkap', 'status']
                  ]);

    // Pastikan tidak membocorkan PII atau data sekunder
    $responseValid->assertJsonMissingPath('data.asal_sekolah')
                  ->assertJsonMissingPath('data.program')
                  ->assertJsonMissingPath('data.jalur_pendaftaran')
                  ->assertJsonMissingPath('data.tanggal_daftar')
                  ->assertJsonMissingPath('data.nisn')
                  ->assertJsonMissingPath('data.nik');

    // 3. Verifikasi tambahan jika parameter NISN tidak cocok ditolak 403
    $responseWrongNisn = $this->getJson('/api/spmb/status/SPMB-2026-8888?nisn=9999999999');
    $responseWrongNisn->assertStatus(403);

    // 4. Verifikasi tambahan dengan NISN cocok diizinkan 200
    $responseRightNisn = $this->getJson('/api/spmb/status/SPMB-2026-8888?nisn=0011223344');
    $responseRightNisn->assertOk();
});

test('skenario 9: pembuatan tugas API tanpa kelas valid ditolak 404 dan tidak fallback ke Kelas::first', function () {
    $guru = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
    $kelas = Kelas::create(['nama' => 'X-Umum', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => null]);

    Sanctum::actingAs($guru);

    // Mencoba kirim tanpa kelas_id atau dengan kelas yang tidak ada
    $response = $this->postJson('/api/tugas/buat', [
        'judul' => 'Tugas Uji Fallback',
        'deskripsi' => 'Deskripsi tugas',
        'kelas_id' => 99999,
    ]);

    // Wajib 404 atau 422 dan TIDAK boleh otomatis menempel ke $kelas->id (Kelas::first)
    $response->assertStatus(404);
    $this->assertDatabaseMissing('tugas', [
        'judul' => 'Tugas Uji Fallback',
        'kelas_id' => $kelas->id,
    ]);
});
