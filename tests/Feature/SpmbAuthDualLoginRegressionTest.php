<?php

use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('admin menyetujui pendaftaran spmb membuat akun user siswa baru dengan password sementara ter-hash dan relasi valid', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa']);

    $spmb = Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1001',
        'nama_lengkap' => 'Bintang Pratama',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-03-15',
        'nisn' => '0091122334',
        'nik' => '1207010101080055',
        'agama' => 'Islam',
        'email' => 'bintang.pratama@example.com',
        'telepon' => '081234567811',
        'alamat' => 'Jl. Bahorok Permai No. 12',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Bintang',
        'pekerjaan_ayah' => 'PNS',
        'nama_ibu' => 'Ibu Bintang',
        'pekerjaan_ibu' => 'Guru',
        'telepon_ortu' => '081234567812',
        'asal_sekolah' => 'SMP Negeri 2 Bahorok',
        'nilai_rata' => 90.5,
        'tahun_lulus' => 2026,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
        'status' => 'Menunggu Verifikasi',
    ]);

    // Verifikasi akun belum ada sebelum disetujui
    expect(User::where('nisn', '0091122334')->first())->toBeNull();

    // Admin menyetujui ("Diterima") dan menetapkan rombel
    $response = $this->actingAs($admin)->post(route('admin.spmb.status', $spmb->id), [
        'status' => 'Diterima',
        'kelas_id' => $kelas->id,
        'note' => 'Berkas valid dan nilai memenuhi kriteria penerimaan.',
    ]);

    $response->assertRedirect(route('admin.spmb.index'));
    $response->assertSessionHas('success');

    // Akun user siswa terbentuk otomatis
    $user = User::where('nisn', '0091122334')->first();
    expect($user)->not->toBeNull();
    expect($user->role)->toBe('siswa');
    expect($user->email)->toBe('bintang.pratama@example.com');
    expect($user->name)->toBe('Bintang Pratama');
    expect($user->kelas_id)->toBe($kelas->id);
    expect($user->password_changed)->toBeFalse();
    expect($user->password)->not->toBeEmpty();
    // Memastikan password ter-hash secara aman
    expect(password_get_info($user->password)['algo'])->not->toBe(0);

    // Relasi dua arah berfungsi
    expect($user->spmb)->not->toBeNull();
    expect($user->spmb->nomor_pendaftaran)->toBe('SPMB-2026-1001');
    expect($user->isSpmbDiterima())->toBeTrue();
    expect($spmb->fresh()->getUser()->id)->toBe($user->id);
});

test('admin menyetujui pendaftaran spmb mengaktifkan dan memulihkan akun user yang soft-deleted', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $spmb = Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1002',
        'nama_lengkap' => 'Citra Lestari',
        'gender' => 'perempuan',
        'tempat_lahir' => 'Medan',
        'tanggal_lahir' => '2008-07-20',
        'nisn' => '0095566778',
        'nik' => '1207010101080066',
        'agama' => 'Islam',
        'email' => 'citra.lestari@example.com',
        'telepon' => '081234567822',
        'alamat' => 'Jl. Bukit Lawang No. 7',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Citra',
        'pekerjaan_ayah' => 'Wiraswasta',
        'nama_ibu' => 'Ibu Citra',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '081234567823',
        'asal_sekolah' => 'SMP Negeri 1 Bahorok',
        'nilai_rata' => 88.0,
        'tahun_lulus' => 2026,
        'program' => 'ips',
        'jalur_pendaftaran' => 'Prestasi',
        'status' => 'Menunggu Verifikasi',
    ]);

    // Buat akun yang sebelumnya soft-deleted
    $existing = User::create([
        'name' => 'Citra Lestari Lama',
        'email' => 'citra.lestari@example.com',
        'nisn' => '0095566778',
        'password' => Hash::make('OldPassword123!'),
        'role' => 'siswa',
        'password_changed' => false,
    ]);
    $existing->delete();
    expect($existing->trashed())->toBeTrue();

    // Admin menyetujui
    $this->actingAs($admin)->post(route('admin.spmb.status', $spmb->id), [
        'status' => 'Diterima',
    ])->assertRedirect(route('admin.spmb.index'));

    $user = User::where('nisn', '0095566778')->first();
    expect($user)->not->toBeNull();
    expect($user->trashed())->toBeFalse();
    expect($user->role)->toBe('siswa');
    expect($user->name)->toBe('Citra Lestari');
});

test('login web dan api mendukung dual login via email dan nisn untuk siswa yang diterima', function () {
    $tempPassword = 'Sp-TempPass#2026';
    $email = 'dani.siswa@example.com';
    $nisn = '0098877665';

    Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1003',
        'nama_lengkap' => 'Dani Ramadhan',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-09-09',
        'nisn' => $nisn,
        'nik' => '1207010101080077',
        'agama' => 'Islam',
        'email' => $email,
        'telepon' => '081234567833',
        'alamat' => 'Jl. Bahorok Hulu No. 3',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Dani',
        'pekerjaan_ayah' => 'Petani',
        'nama_ibu' => 'Ibu Dani',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '081234567834',
        'asal_sekolah' => 'SMP Swasta Bahorok',
        'nilai_rata' => 87.5,
        'tahun_lulus' => 2026,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
        'status' => 'Diterima',
    ]);

    $user = User::create([
        'name' => 'Dani Ramadhan',
        'email' => $email,
        'nisn' => $nisn,
        'password' => Hash::make($tempPassword),
        'role' => 'siswa',
        'password_changed' => false,
    ]);

    // 1. Web: Login via Email
    $resWebEmail = $this->post('/proses-login', [
        'login' => $email,
        'password' => $tempPassword,
    ]);
    $resWebEmail->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);

    // Logout web
    $this->post('/logout');
    $this->assertGuest();

    // 2. Web: Login via NISN
    $resWebNisn = $this->post('/proses-login', [
        'login' => $nisn,
        'password' => $tempPassword,
    ]);
    $resWebNisn->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);

    $this->post('/logout');

    // 3. API: Login via Email ke /api/login
    $resApiEmail = $this->postJson('/api/login', [
        'login' => $email,
        'password' => $tempPassword,
    ]);
    $resApiEmail->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user.email', $email)
        ->assertJsonPath('data.user.nisn', $nisn)
        ->assertJsonPath('data.user.role', 'siswa')
        ->assertJsonPath('data.user.must_change_password', true)
        ->assertJsonPath('data.user.spmb_status', 'Diterima');
    expect($resApiEmail->json('data.token'))->not->toBeEmpty();

    // 4. API: Login via NISN ke /api/login
    $resApiNisn = $this->postJson('/api/login', [
        'login' => $nisn,
        'password' => $tempPassword,
    ]);
    $resApiNisn->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user.nisn', $nisn)
        ->assertJsonPath('data.user.must_change_password', true);

    // 5. API: Login via format JSON pada /proses-login
    $resWebJson = $this->postJson('/proses-login', [
        'login' => $nisn,
        'password' => $tempPassword,
    ]);
    $resWebJson->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.user.nisn', $nisn);
});

test('siswa spmb yang belum berstatus diterima ditolak baik pada web maupun api dengan pesan status jelas', function () {
    $tempPassword = 'Sp-Password#999';
    $email = 'menunggu@example.com';
    $nisn = '0099998888';

    $spmb = Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1004',
        'nama_lengkap' => 'Eko Menunggu',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-01-10',
        'nisn' => $nisn,
        'nik' => '1207010101080088',
        'agama' => 'Islam',
        'email' => $email,
        'telepon' => '081234567844',
        'alamat' => 'Jl. Desa Bahorok No. 4',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Eko',
        'pekerjaan_ayah' => 'Buruh',
        'nama_ibu' => 'Ibu Eko',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '081234567845',
        'asal_sekolah' => 'SMP Negeri 1 Bahorok',
        'nilai_rata' => 84.0,
        'tahun_lulus' => 2026,
        'program' => 'ips',
        'jalur_pendaftaran' => 'Afirmasi',
        'status' => 'Menunggu Verifikasi',
    ]);

    User::create([
        'name' => 'Eko Menunggu',
        'email' => $email,
        'nisn' => $nisn,
        'password' => Hash::make($tempPassword),
        'role' => 'siswa',
        'password_changed' => false,
    ]);

    // 1. Percobaan Login Web: dialihkan kembali dengan error status
    $resWeb = $this->from('/login')->post('/proses-login', [
        'login' => $email,
        'password' => $tempPassword,
    ]);
    $resWeb->assertRedirect('/login');
    $resWeb->assertSessionHasErrors('login');
    $this->assertGuest();

    // 2. Percobaan Login API: ditolak 403 Forbidden
    $resApi = $this->postJson('/api/login', [
        'login' => $nisn,
        'password' => $tempPassword,
    ]);
    $resApi->assertStatus(403)
        ->assertJsonPath('success', false)
        ->assertJsonPath('spmb_status', 'Menunggu Verifikasi');
    expect($resApi->json('message'))->toContain('Menunggu Verifikasi');
});

test('alur flag wajib ganti password tertangani dengan baik di portal web dan api', function () {
    $tempPassword = 'Sp-Default#123';
    $email = 'fajar.siswa@example.com';
    $nisn = '0097788990';

    Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1005',
        'nama_lengkap' => 'Fajar Nugraha',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-04-04',
        'nisn' => $nisn,
        'nik' => '1207010101080099',
        'agama' => 'Islam',
        'email' => $email,
        'telepon' => '081234567855',
        'alamat' => 'Jl. Merdeka No. 15',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Fajar',
        'pekerjaan_ayah' => 'Wiraswasta',
        'nama_ibu' => 'Ibu Fajar',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '081234567856',
        'asal_sekolah' => 'SMP Negeri 1 Bahorok',
        'nilai_rata' => 89.0,
        'tahun_lulus' => 2026,
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
        'status' => 'Diterima',
    ]);

    $user = User::create([
        'name' => 'Fajar Nugraha',
        'email' => $email,
        'nisn' => $nisn,
        'password' => Hash::make($tempPassword),
        'role' => 'siswa',
        'password_changed' => false,
    ]);

    // 1. Web: Mengakses dashboard dialihkan ke form ganti password
    $this->actingAs($user)->get('/dashboard')->assertRedirect(route('siswa.password.form'));

    // Siswa memperbarui kata sandi di form web
    $resWebUpdate = $this->actingAs($user)->post(route('siswa.password.update'), [
        'password' => 'KataSandiBaru#999',
        'password_confirmation' => 'KataSandiBaru#999',
    ]);
    $resWebUpdate->assertRedirect(route('dashboard'));

    $user->refresh();
    expect($user->password_changed)->toBeTrue();
    expect(Hash::check('KataSandiBaru#999', $user->password))->toBeTrue();

    // 2. Sekarang coba reset lagi ke sandi sementara untuk menguji alur API
    $user->update([
        'password' => Hash::make('Sp-NewTemp#888'),
        'password_changed' => false,
    ]);

    // Login via API menginfokan must_change_password = true
    $resLoginApi = $this->postJson('/api/login', [
        'login' => $email,
        'password' => 'Sp-NewTemp#888',
    ]);
    $resLoginApi->assertOk();
    $token = $resLoginApi->json('data.token');

    // Mengakses endpoint /api/user mengindikasikan must_change_password = true
    $resMe = $this->withHeader('Authorization', 'Bearer '.$token)->getJson('/api/user');
    $resMe->assertOk()
        ->assertJsonPath('data.must_change_password', true)
        ->assertJsonPath('data.password_changed', false);

    // Ubah password melalui API
    $resApiPass = $this->withHeader('Authorization', 'Bearer '.$token)->postJson('/api/ubah-password', [
        'password' => 'SandiBaruApi#2026',
        'password_confirmation' => 'SandiBaruApi#2026',
    ]);
    $resApiPass->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.password_changed', true);

    $user->refresh();
    expect($user->password_changed)->toBeTrue();
    expect(Hash::check('SandiBaruApi#2026', $user->password))->toBeTrue();

    // Logout via API
    $resLogout = $this->withHeader('Authorization', 'Bearer '.$token)->postJson('/api/logout');
    $resLogout->assertOk()->assertJsonPath('success', true);
});

test('api update status spmb oleh admin menyelaraskan akun dan mengembalikan kredensial sementara', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kelas = Kelas::create(['nama' => 'X-IPS-2', 'tingkat' => '10', 'program' => 'ips']);

    $spmb = Spmb::create([
        'nomor_pendaftaran' => 'SPMB-2026-1006',
        'nama_lengkap' => 'Gita Kirana',
        'gender' => 'perempuan',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2008-11-11',
        'nisn' => '0093344556',
        'nik' => '1207010101080033',
        'agama' => 'Islam',
        'email' => 'gita.kirana@example.com',
        'telepon' => '081234567866',
        'alamat' => 'Jl. Kolam No. 2',
        'kota' => 'Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Bapak Gita',
        'pekerjaan_ayah' => 'PNS',
        'nama_ibu' => 'Ibu Gita',
        'pekerjaan_ibu' => 'PNS',
        'telepon_ortu' => '081234567867',
        'asal_sekolah' => 'SMP Negeri 1 Bahorok',
        'nilai_rata' => 93.0,
        'tahun_lulus' => 2026,
        'program' => 'ips',
        'jalur_pendaftaran' => 'Prestasi',
        'status' => 'Sedang Diverifikasi',
    ]);

    Sanctum::actingAs($admin);

    $response = $this->putJson("/api/spmb/status/{$spmb->id}", [
        'status' => 'Diterima',
        'kelas_id' => $kelas->id,
        'note' => 'Disetujui melalui seleksi prestasi.',
    ]);

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.status', 'Diterima')
        ->assertJsonPath('data.user_email', 'gita.kirana@example.com')
        ->assertJsonPath('data.user_nisn', '0093344556')
        ->assertJsonPath('data.role', 'siswa');

    $tempPass = $response->json('data.temp_password');
    expect($tempPass)->not->toBeNull();

    $newUser = User::where('nisn', '0093344556')->first();
    expect($newUser)->not->toBeNull();
    expect(Hash::check($tempPass, $newUser->password))->toBeTrue();

    // Siswa baru ini langsung dapat login dengan kredensial sementara tersebut
    $loginRes = $this->postJson('/api/login', [
        'login' => '0093344556',
        'password' => $tempPass,
    ]);
    $loginRes->assertOk()->assertJsonPath('success', true);
});
