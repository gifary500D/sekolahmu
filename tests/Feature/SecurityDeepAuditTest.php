<?php

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Roster;
use App\Models\Spmb;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\User;
use App\Support\Teks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('skenario 1: akses tanpa login ditolak ke endpoint terproteksi', function () {
    // API Sanctum
    $this->postJson('/api/absensi/simpan', [])->assertUnauthorized();
    $this->getJson('/api/absensi/rekap/X-IPA-1')->assertUnauthorized();
    $this->getJson('/api/absensi/export/X-IPA-1')->assertUnauthorized();
    $this->postJson('/api/tugas/buat', [])->assertUnauthorized();
    $this->deleteJson('/api/tugas/1')->assertUnauthorized();

    // Web Routes
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/dashboard/admin/spmb')->assertRedirect('/login');
    $this->get('/dashboard/guru/tugas')->assertRedirect('/login');
});

test('skenario 2: akses dengan salah role ditolak (RBAC)', function () {
    $siswa = User::factory()->create(['role' => 'siswa']);
    $guru = User::factory()->create(['role' => 'guru']);

    // Siswa mencoba membuat berita admin di API v1
    Sanctum::actingAs($siswa);
    $this->postJson('/api/v1/admin/berita', ['judul' => 'Hack', 'konten' => 'Hack', 'status' => 'terbit'])->assertForbidden();

    // Siswa mencoba akses rute guru di Web
    $this->actingAs($siswa)->get('/dashboard/guru/tugas')->assertForbidden();

    // Guru mencoba akses rute pengguna admin di Web
    $this->actingAs($guru)->get('/dashboard/admin/pengguna')->assertForbidden();

    // Siswa mencoba ekspor absensi di API
    Sanctum::actingAs($siswa);
    $this->getJson('/api/absensi/export/X-IPA-1')->assertForbidden();
});

test('skenario 3: siswa tidak dapat mengakses absensi atau tugas lintas kelas (IDOR)', function () {
    $kelasA = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa']);
    $kelasB = Kelas::create(['nama' => 'X-IPA-2', 'tingkat' => '10', 'program' => 'ipa']);

    $siswaA = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelasA->id]);

    Absensi::create([
        'kelas' => 'X-IPA-2',
        'tanggal' => '2026-10-20',
        'data_kehadiran' => [['nama' => 'Siswa Lain', 'status' => 'Hadir']],
    ]);

    // Siswa A mencoba mengakses rekap absensi kelas B
    Sanctum::actingAs($siswaA);
    $response = $this->getJson('/api/absensi/rekap/X-IPA-2');
    $response->assertForbidden();

    // Siswa A mencoba melihat daftar tugas kelas B
    $responseTugas = $this->getJson('/api/tugas/kelas/X-IPA-2');
    $responseTugas->assertForbidden();
});

test('skenario 3b: siswa hanya dapat melihat data absensinya sendiri di kelasnya', function () {
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa']);
    $siswa1 = User::factory()->create(['name' => 'Ahmad Siswa', 'role' => 'siswa', 'kelas_id' => $kelas->id]);
    $siswa2 = User::factory()->create(['name' => 'Budi Siswa', 'role' => 'siswa', 'kelas_id' => $kelas->id]);

    Absensi::create([
        'kelas' => 'X-IPA-1',
        'tanggal' => '2026-10-20',
        'data_kehadiran' => [
            ['nama' => 'Ahmad Siswa', 'status' => 'Hadir'],
            ['nama' => 'Budi Siswa', 'status' => 'Sakit'],
        ],
    ]);

    Sanctum::actingAs($siswa1);
    $response = $this->getJson('/api/absensi/rekap/X-IPA-1');
    $response->assertOk();

    // Pastikan data yang kembali HANYA data Ahmad Siswa, bukan Budi Siswa
    $kehadiran = $response->json('data.0.data_kehadiran');
    expect($kehadiran)->toHaveCount(1);
    expect($kehadiran[0]['nama'])->toBe('Ahmad Siswa');
});

test('skenario 4: guru tidak dapat memanipulasi guru_id atau kelas_id lintas kelas', function () {
    $guru1 = User::factory()->create(['role' => 'guru']);
    $guru2 = User::factory()->create(['role' => 'guru']);
    $kelasGuru1 = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guru1->id]);
    $kelasGuru2 = Kelas::create(['nama' => 'X-IPS-1', 'tingkat' => '10', 'program' => 'ips', 'wali_kelas_id' => $guru2->id]);

    Sanctum::actingAs($guru1);

    // Guru 1 mencoba membuat tugas untuk kelas Guru 2
    $response = $this->postJson('/api/tugas/buat', [
        'judul' => 'Tugas Ilegal',
        'deskripsi' => 'Deskripsi',
        'kelas_id' => $kelasGuru2->id,
        'guru_id' => $guru2->id, // Percobaan spoofing guru_id
    ]);

    $response->assertForbidden();

    // Guru 1 membuat tugas untuk kelasnya sendiri, mencoba memalsukan guru_id ke guru2
    $responseValid = $this->postJson('/api/tugas/buat', [
        'judul' => 'Tugas Legal',
        'deskripsi' => 'Deskripsi',
        'kelas_id' => $kelasGuru1->id,
        'guru_id' => $guru2->id, // Harus diabaikan & dipaksa ke guru1
    ]);

    $responseValid->assertCreated();
    $this->assertDatabaseHas('tugas', [
        'judul' => 'Tugas Legal',
        'kelas_id' => $kelasGuru1->id,
        'guru_id' => $guru1->id, // Terbukti terkunci ke guru1
    ]);
});

test('skenario 5: validasi input ketat pada NISN, NIK, dan MIME upload SPMB', function () {
    Storage::fake('local');

    // NISN bukan 10 digit, NIK bukan 16 digit, MIME bukan pdf/gambar
    $filePalsu = UploadedFile::fake()->create('malicious.php', 10, 'application/x-php');

    $payload = [
        'nama_lengkap' => 'Tester Validasi',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Medan',
        'tanggal_lahir' => '2008-01-01',
        'nisn' => '123', // Kurang dari 10 digit
        'nik' => '999', // Kurang dari 16 digit
        'agama' => 'Islam',
        'email' => 'validasi@example.com',
        'telepon' => '08123456789',
        'alamat' => 'Jl. Uji Coba',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Ayah',
        'pekerjaan_ayah' => 'PNS',
        'nama_ibu' => 'Ibu',
        'pekerjaan_ibu' => 'Guru',
        'telepon_ortu' => '08123456780',
        'asal_sekolah' => 'SMPN 1 Bahorok',
        'nilai_rata' => 88.5,
        'tahun_lulus' => 2024,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Prestasi',
        'berkas_ijazah_skl' => $filePalsu,
    ];

    $response = $this->postJson('/api/spmb/daftar', $payload);
    $response->assertStatus(422)
             ->assertJsonValidationErrors(['nisn', 'nik', 'berkas_ijazah_skl']);
});

test('skenario 6: endpoint publik cek status mencegah kebocoran PII dan enumerasi', function () {
    $spmb = Spmb::factory()->create([
        'nomor_pendaftaran' => 'SPMB-2026-7777',
        'nama_lengkap' => 'Muhammad Rifqi Pratama',
        'nisn' => '0098765432',
        'nik' => '1234567890123456',
        'email' => 'rifqi@example.com',
        'telepon' => '081299998888',
        'alamat' => 'Alamat Sangat Rahasia',
        'nama_ayah' => 'Ayah Rifqi',
        'status' => 'Menunggu Verifikasi',
    ]);

    // Akses tanpa login
    $response = $this->getJson('/api/spmb/status/SPMB-2026-7777');
    $response->assertOk()
             ->assertJsonPath('data.nomor_pendaftaran', 'SPMB-2026-7777')
             ->assertJsonPath('data.nama_lengkap', 'M******* R**** P******'); // Ter-masking

    // PII sensitif tidak boleh bocor
    $response->assertJsonMissingPath('data.nisn');
    $response->assertJsonMissingPath('data.nik');
    $response->assertJsonMissingPath('data.email');
    $response->assertJsonMissingPath('data.telepon');
    $response->assertJsonMissingPath('data.alamat');
    $response->assertJsonMissingPath('data.nama_ayah');
});

test('skenario 7: pendaftaran dengan NISN atau NIK duplikat ditolak', function () {
    Spmb::factory()->create([
        'nisn' => '1234567890',
        'nik' => '1234567890123456',
    ]);

    $payload = [
        'nama_lengkap' => 'Pendaftar Duplikat',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Binjai',
        'tanggal_lahir' => '2008-05-10',
        'nisn' => '1234567890', // Duplikat
        'nik' => '1234567890123456', // Duplikat
        'agama' => 'Islam',
        'email' => 'duplikat@example.com',
        'telepon' => '08123456789',
        'alamat' => 'Jl. Baru',
        'kota' => 'Binjai',
        'provinsi' => 'Sumut',
        'nama_ayah' => 'Bapak',
        'pekerjaan_ayah' => 'Wiraswasta',
        'nama_ibu' => 'Ibu',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '08123456780',
        'asal_sekolah' => 'SMP 1',
        'nilai_rata' => 90,
        'tahun_lulus' => 2024,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
    ];

    $response = $this->postJson('/api/spmb/daftar', $payload);
    $response->assertStatus(422)
             ->assertJsonValidationErrors(['nisn', 'nik']);
});

test('skenario 8: kegagalan transaksi SPMB melakukan rollback berkas upload fisik', function () {
    Storage::fake('local');

    $file = UploadedFile::fake()->create('ijazah.pdf', 100, 'application/pdf');

    // Buat data dengan NIK yang sengaja bertabrakan setelah berkas di-upload, memicu rollback DB
    Spmb::factory()->create(['nik' => '1111222233334444']);

    $payload = [
        'nama_lengkap' => 'Calon Siswa Gagal Transaksi',
        'gender' => 'perempuan',
        'tempat_lahir' => 'Stabat',
        'tanggal_lahir' => '2008-03-15',
        'nisn' => '9988776655',
        'nik' => '1111222233334444', // Akan memicu error validasi duplikasi saat pendaftaran
        'agama' => 'Kristen',
        'email' => 'gagal@example.com',
        'telepon' => '081233445566',
        'alamat' => 'Jl. Stabat',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Ayah',
        'pekerjaan_ayah' => 'Petani',
        'nama_ibu' => 'Ibu',
        'pekerjaan_ibu' => 'Pedagang',
        'telepon_ortu' => '081233445577',
        'asal_sekolah' => 'SMPN 2 Stabat',
        'nilai_rata' => 85.0,
        'tahun_lulus' => 2024,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
        'berkas_ijazah_skl' => $file,
    ];

    $response = $this->postJson('/api/spmb/daftar', $payload);
    $response->assertStatus(422);

    // Pastikan tidak ada file yang tertinggal di direktori private storage
    expect(Storage::disk('local')->allFiles('spmb/ijazah'))->toBeEmpty();
});

test('skenario 9: otorisasi hapus tugas hanya dapat dilakukan oleh guru pembuat atau admin', function () {
    $guruA = User::factory()->create(['role' => 'guru']);
    $guruB = User::factory()->create(['role' => 'guru']);
    $admin = User::factory()->create(['role' => 'admin']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guruA->id]);

    $tugas = Tugas::create([
        'judul' => 'Tugas Milik Guru A',
        'deskripsi' => 'Kerjakan',
        'kelas_id' => $kelas->id,
        'guru_id' => $guruA->id,
        'tenggat' => now()->addDays(3),
        'prioritas' => 'sedang',
    ]);

    // Guru B mencoba menghapus tugas Guru A -> Ditolak 403
    Sanctum::actingAs($guruB);
    $responseB = $this->deleteJson("/api/tugas/{$tugas->id}");
    $responseB->assertForbidden();

    // Admin menghapus tugas -> Berhasil 200
    Sanctum::actingAs($admin);
    $responseAdmin = $this->deleteJson("/api/tugas/{$tugas->id}");
    $responseAdmin->assertOk();

    $this->assertSoftDeleted('tugas', ['id' => $tugas->id]);
});

test('skenario 10: ekspor CSV terproteksi dari Formula Injection (CSV Injection)', function () {
    $guru = User::factory()->create(['role' => 'guru']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa', 'wali_kelas_id' => $guru->id]);

    Absensi::create([
        'kelas' => 'X-IPA-1',
        'tanggal' => '2026-10-20',
        'data_kehadiran' => [
            ['nama' => '=CMD|\' /C calc\'!A0', 'status' => '+1337'],
            ['nama' => '@SUM(1+1)', 'status' => '-100'],
        ],
    ]);

    Sanctum::actingAs($guru);
    $response = $this->get('/api/absensi/export/X-IPA-1');
    $response->assertOk();

    $content = $response->streamedContent();

    // Pastikan karakter formula diawali dengan tanda kutip satu (') untuk menetralkan eksekusi spreadsheet
    expect($content)->toContain("'=CMD");
    expect($content)->toContain("'+1337");
    expect($content)->toContain("'@SUM");
    expect($content)->toContain("'-100");
});
