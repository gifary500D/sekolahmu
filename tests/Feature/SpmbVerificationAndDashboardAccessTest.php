<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SpmbVerificationAndDashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper membuat pendaftar SPMB dan akun User terkait
     */
    private function createSpmbDanUser(string $spmbStatus = 'Menunggu Verifikasi', bool $passwordChanged = false, ?int $kelasId = null): array
    {
        $nisn = '1234567890';
        $email = 'calon.siswa@example.com';
        $tempPassword = 'Sp-Password123!';

        $spmb = Spmb::create([
            'nomor_pendaftaran' => 'SPMB-2026-0001',
            'nama_lengkap' => 'Ahmad Calon Siswa',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Bahorok',
            'tanggal_lahir' => '2008-01-01',
            'nisn' => $nisn,
            'nik' => '1207010101080001',
            'agama' => 'Islam',
            'email' => $email,
            'telepon' => '081234567890',
            'alamat' => 'Jl. Bahorok Indah No. 1',
            'kota' => 'Langkat',
            'provinsi' => 'Sumatera Utara',
            'nama_ayah' => 'Bapak Siswa',
            'pekerjaan_ayah' => 'Wiraswasta',
            'nama_ibu' => 'Ibu Siswa',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'telepon_ortu' => '081234567891',
            'asal_sekolah' => 'SMP Negeri 1 Bahorok',
            'nilai_rata' => 88.5,
            'tahun_lulus' => 2026,
            'program' => 'ipa',
            'jalur_pendaftaran' => 'Zonasi',
            'status' => $spmbStatus,
        ]);

        $user = User::create([
            'name' => 'Ahmad Calon Siswa',
            'email' => $email,
            'nisn' => $nisn,
            'password' => Hash::make($tempPassword),
            'role' => 'siswa',
            'kelas_id' => $kelasId,
            'password_changed' => $passwordChanged,
        ]);

        return compact('spmb', 'user', 'tempPassword');
    }

    public function test_siswa_baru_status_menunggu_verifikasi_ditolak_mengakses_dashboard_dan_login(): void
    {
        $data = $this->createSpmbDanUser('Menunggu Verifikasi', false);

        // 1. Percobaan login web form ditolak dan diberi pesan status
        $loginRes = $this->from('/login')->post('/proses-login', [
            'login' => $data['user']->email,
            'password' => $data['tempPassword'],
        ]);
        $loginRes->assertRedirect('/login');
        $loginRes->assertSessionHasErrors('login');
        $this->assertGuest();

        // 2. Akses langsung dengan auth ditolak 403 Forbidden
        $dashboardRes = $this->actingAs($data['user'])->get('/dashboard');
        $dashboardRes->assertForbidden();
    }

    public function test_siswa_baru_status_sedang_diverifikasi_ditolak_mengakses_dashboard(): void
    {
        $data = $this->createSpmbDanUser('Sedang Diverifikasi', false);

        $this->actingAs($data['user'])->get('/dashboard')->assertForbidden();
        $this->actingAs($data['user'])->get('/dashboard/tugas')->assertForbidden();
    }

    public function test_siswa_baru_status_terverifikasi_belum_bisa_mengakses_dashboard_harus_diterima(): void
    {
        // Kondisi umum: admin memverifikasi berkas sehingga status = "Terverifikasi"
        // Namun siswa belum dinyatakan "Diterima"
        $data = $this->createSpmbDanUser('Terverifikasi', false);

        // Akses dashboard ditolak karena status belum "Diterima"
        $this->actingAs($data['user'])->get('/dashboard')->assertForbidden();
        $this->actingAs($data['user'])->get('/dashboard/ubah-password')->assertForbidden();

        // Percobaan login web form juga menginfokan bahwa akun belum Diterima
        $resLogin = $this->post('/proses-login', [
            'login' => $data['user']->nisn,
            'password' => $data['tempPassword'],
        ]);
        $resLogin->assertRedirect('/login');
        $resLogin->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_siswa_baru_status_ditolak_tidak_dapat_mengakses_dashboard(): void
    {
        $data = $this->createSpmbDanUser('Ditolak', false);

        $this->actingAs($data['user'])->get('/dashboard')->assertForbidden();

        $resLogin = $this->post('/proses-login', [
            'login' => $data['user']->email,
            'password' => $data['tempPassword'],
        ]);
        $resLogin->assertRedirect('/login');
        $resLogin->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_siswa_baru_status_diterima_dapat_login_dan_diarahkan_ganti_password_sementara(): void
    {
        $data = $this->createSpmbDanUser('Diterima', false);

        // Siswa berhasil login via email / NISN
        $resLogin = $this->post('/proses-login', [
            'login' => $data['user']->nisn,
            'password' => $data['tempPassword'],
        ]);
        $resLogin->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($data['user']);

        // Mengakses dashboard diarahkan ke form ubah password wajib karena password_changed = false
        $resDashboard = $this->actingAs($data['user'])->get('/dashboard');
        $resDashboard->assertRedirect(route('siswa.password.form'));
    }

    public function test_siswa_baru_berhasil_ubah_password_dan_dapat_mengakses_dashboard_penuh(): void
    {
        $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa']);
        $data = $this->createSpmbDanUser('Diterima', false, $kelas->id);

        // Ubah password wajib
        $resUpdate = $this->actingAs($data['user'])->post(route('siswa.password.update'), [
            'password' => 'SandiRahasiaBaru#2026',
            'password_confirmation' => 'SandiRahasiaBaru#2026',
        ]);
        $resUpdate->assertRedirect(route('dashboard'));

        $data['user']->refresh();
        $this->assertTrue($data['user']->password_changed);
        $this->assertTrue(Hash::check('SandiRahasiaBaru#2026', $data['user']->password));

        // Sekarang siswa dapat mengakses dashboard utama secara normal
        $resDashboard = $this->actingAs($data['user'])->get('/dashboard');
        $resDashboard->assertOk();
        $resDashboard->assertSee('Ahmad Calon Siswa');
        $resDashboard->assertSee('X-IPA-1');

        // Fitur siswa lainnya juga terbuka
        $this->actingAs($data['user'])->get(route('siswa.tugas'))->assertOk();
        $this->actingAs($data['user'])->get(route('siswa.absensi'))->assertOk();
        $this->actingAs($data['user'])->get(route('siswa.roster'))->assertOk();
        $this->actingAs($data['user'])->get(route('siswa.nilai'))->assertOk();
    }

    public function test_admin_dapat_mengubah_status_spmb_menjadi_diterima_dan_menetapkan_kelas(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kelas = Kelas::create(['nama' => 'X-IPS-1', 'tingkat' => '10', 'program' => 'ips']);
        $data = $this->createSpmbDanUser('Menunggu Verifikasi', false);

        $resUpdate = $this->actingAs($admin)->post(route('admin.spmb.status', $data['spmb']->id), [
            'status' => 'Diterima',
            'note' => 'Dokumen lengkap dan memenuhi syarat seleksi zonasi.',
            'kelas_id' => $kelas->id,
        ]);
        $resUpdate->assertRedirect(route('admin.spmb.index'));
        $resUpdate->assertSessionHas('success');

        $data['spmb']->refresh();
        $this->assertEquals('Diterima', $data['spmb']->status);
        $this->assertEquals('Dokumen lengkap dan memenuhi syarat seleksi zonasi.', $data['spmb']->note);

        // Akun siswa tersinkronisasi dan kelas telah ditetapkan
        $data['user']->refresh();
        $this->assertEquals($kelas->id, $data['user']->kelas_id);
        $this->assertEquals('siswa', $data['user']->role);
    }

    public function test_admin_dapat_menetapkan_atau_memindahkan_kelas_siswa_via_panel_siswa(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kelasA = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'program' => 'ipa']);
        $kelasB = Kelas::create(['nama' => 'X-IPA-2', 'tingkat' => '10', 'program' => 'ipa']);

        $data = $this->createSpmbDanUser('Diterima', true, $kelasA->id);

        // Admin memindahkan kelas siswa ke X-IPA-2
        $res = $this->actingAs($admin)->put(route('admin.siswa.kelas', $data['user']->id), [
            'kelas_id' => $kelasB->id,
        ]);
        $res->assertRedirect();
        $res->assertSessionHas('success');

        $data['user']->refresh();
        $this->assertEquals($kelasB->id, $data['user']->kelas_id);
    }

    public function test_admin_dapat_mereset_kata_sandi_sementara_siswa(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $data = $this->createSpmbDanUser('Diterima', true);

        // Admin mereset kata sandi siswa
        $resReset = $this->actingAs($admin)->post(route('admin.siswa.reset-password', $data['user']->id));
        $resReset->assertRedirect();
        $resReset->assertSessionHas('success');

        $data['user']->refresh();
        $this->assertFalse($data['user']->password_changed);

        // Siswa yang direset kini dipaksa mengganti sandi lagi saat login
        $this->actingAs($data['user'])->get('/dashboard')->assertRedirect(route('siswa.password.form'));
    }

    public function test_sinkronisasi_akun_otomatis_saat_pendaftar_tanpa_user_diterima(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kelas = Kelas::create(['nama' => 'X-BAHASA-1', 'tingkat' => '10', 'program' => 'bahasa']);

        // Pendaftar SPMB mendaftar melalui API (belum ada record User)
        $spmb = Spmb::create([
            'nomor_pendaftaran' => 'SPMB-2026-9999',
            'nama_lengkap' => 'Rina Cantika',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '2008-05-12',
            'nisn' => '9988776655',
            'nik' => '1207998877660001',
            'agama' => 'Islam',
            'email' => 'rina.cantika@example.com',
            'telepon' => '081299998888',
            'alamat' => 'Jl. Pahlawan No. 5',
            'kota' => 'Langkat',
            'provinsi' => 'Sumatera Utara',
            'nama_ayah' => 'Ayah Rina',
            'pekerjaan_ayah' => 'PNS',
            'nama_ibu' => 'Ibu Rina',
            'pekerjaan_ibu' => 'PNS',
            'telepon_ortu' => '081299998889',
            'asal_sekolah' => 'SMP Swasta Bahorok',
            'nilai_rata' => 92.0,
            'tahun_lulus' => 2026,
            'program' => 'bahasa',
            'jalur_pendaftaran' => 'Prestasi',
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->assertDatabaseMissing('users', ['nisn' => '9988776655']);

        // Admin menyetujui ("Diterima") dan menetapkan kelas
        $this->actingAs($admin)->post(route('admin.spmb.status', $spmb->id), [
            'status' => 'Diterima',
            'kelas_id' => $kelas->id,
        ])->assertRedirect(route('admin.spmb.index'));

        // Akun User otomatis terbentuk di DB dan tersinkronisasi
        $this->assertDatabaseHas('users', [
            'nisn' => '9988776655',
            'email' => 'rina.cantika@example.com',
            'role' => 'siswa',
            'kelas_id' => $kelas->id,
            'password_changed' => false,
        ]);

        $newUser = User::where('nisn', '9988776655')->first();
        $this->assertNotNull($newUser);

        // Akun siswa baru ini dapat mengakses alur ganti password dan portal
        $this->actingAs($newUser)->get('/dashboard')->assertRedirect(route('siswa.password.form'));
    }

    public function test_api_update_status_spmb_mendukung_status_diterima_dan_penetapan_kelas(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kelas = Kelas::create(['nama' => 'X-IPA-3', 'tingkat' => '10', 'program' => 'ipa']);
        $data = $this->createSpmbDanUser('Menunggu Verifikasi', false);

        Sanctum::actingAs($admin);
        $res = $this->putJson("/api/spmb/status/{$data['spmb']->id}", [
            'status' => 'Diterima',
            'kelas_id' => $kelas->id,
            'note' => 'Diterima melalui jalur zonasi.',
        ]);

        $res->assertOk();
        $res->assertJsonPath('success', true);
        $res->assertJsonPath('data.status', 'Diterima');

        $data['spmb']->refresh();
        $this->assertEquals('Diterima', $data['spmb']->status);
        $this->assertEquals('Diterima melalui jalur zonasi.', $data['spmb']->note);

        $data['user']->refresh();
        $this->assertEquals($kelas->id, $data['user']->kelas_id);
    }

    public function test_siswa_lama_tanpa_rekam_jejak_spmb_tidak_terblokir_dan_dapat_mengakses_dashboard(): void
    {
        $kelas = Kelas::create(['nama' => 'XI-IPA-1', 'tingkat' => '11', 'program' => 'ipa']);
        // Siswa lama yang dibuat langsung tanpa SPMB
        $siswaLama = User::factory()->create([
            'role' => 'siswa',
            'kelas_id' => $kelas->id,
            'password_changed' => true,
            'nisn' => '8888888888',
        ]);

        $this->assertDatabaseMissing('spmb', ['nisn' => '8888888888']);

        $res = $this->actingAs($siswaLama)->get('/dashboard');
        $res->assertOk();
        $res->assertSee('XI-IPA-1');
    }

    public function test_admin_spmb_update_status_dengan_note_dan_self_healing_berfungsi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $data = $this->createSpmbDanUser('Menunggu Verifikasi', false);

        $res = $this->actingAs($admin)->post(route('admin.spmb.status', $data['spmb']->id), [
            'status' => 'Terverifikasi',
            'note' => 'Berkas pendaftaran lengkap dan valid.',
        ]);

        $res->assertRedirect(route('admin.spmb.index'));

        $data['spmb']->refresh();
        $this->assertEquals('Terverifikasi', $data['spmb']->status);
        $this->assertEquals('Berkas pendaftaran lengkap dan valid.', $data['spmb']->note);
    }
}
