<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthSpmbAbsensiTest extends TestCase
{
    use RefreshDatabase;

    private function dataPendaftar(array $ubah = []): array
    {
        return array_merge([
            'nama_lengkap' => 'Budi Santoso', 'gender' => 'laki-laki', 'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '2011-05-10', 'nisn' => '0081234567', 'nik' => '1275000000000001',
            'agama' => 'Islam', 'email' => 'budi@contoh.test', 'telepon' => '081200000001',
            'alamat' => 'Jl. Contoh No. 1', 'kota' => 'Medan', 'provinsi' => 'Sumatera Utara',
            'nama_ayah' => 'Ayah Budi', 'pekerjaan_ayah' => 'Wiraswasta',
            'nama_ibu' => 'Ibu Budi', 'pekerjaan_ibu' => 'Ibu Rumah Tangga', 'telepon_ortu' => '081300000001',
            'asal_sekolah' => 'SMP Negeri 1 Medan', 'nilai_rata' => 85.5, 'tahun_lulus' => (int) date('Y'),
            'program' => 'ipa', 'jalur_pendaftaran' => 'Zonasi', 'persetujuan' => true,
        ], $ubah);
    }

    // ---------- autentikasi ----------

    public function test_login_berhasil_dan_gagal(): void
    {
        $user = User::factory()->guru()->create(['email' => 'guru@contoh.test']);

        $this->postJson('/api/v1/auth/login', ['email' => 'guru@contoh.test', 'password' => 'password'])
            ->assertOk()
            ->assertJsonPath('data.user.role', 'guru')
            ->assertJsonStructure(['data' => ['token', 'tipe', 'user']]);

        $this->postJson('/api/v1/auth/login', ['email' => $user->email, 'password' => 'salah'])
            ->assertStatus(422);
    }

    public function test_me_membutuhkan_token(): void
    {
        $this->getJson('/api/v1/auth/me')->assertUnauthorized();

        Sanctum::actingAs(User::factory()->admin()->create());
        $this->getJson('/api/v1/auth/me')->assertOk()->assertJsonPath('data.role', 'admin');
    }

    // ---------- SPMB ----------

    public function test_pendaftaran_menghasilkan_nomor_acak_8_karakter(): void
    {
        $res = $this->postJson('/api/v1/spmb/daftar', $this->dataPendaftar())->assertCreated();

        $this->assertMatchesRegularExpression('/^[A-Z0-9]{8}$/', $res->json('data.nomor_pendaftaran'));
        $this->assertSame('menunggu', $res->json('data.status'));
    }

    public function test_pendaftaran_wajib_persetujuan_dan_nisn_unik(): void
    {
        $this->postJson('/api/v1/spmb/daftar', $this->dataPendaftar(['persetujuan' => false]))->assertStatus(422);

        $this->postJson('/api/v1/spmb/daftar', $this->dataPendaftar())->assertCreated();
        $this->postJson('/api/v1/spmb/daftar', $this->dataPendaftar(['nik' => '1275000000000002']))->assertStatus(422);
    }

    public function test_cek_status_hanya_menampilkan_data_minimal(): void
    {
        $nomor = $this->postJson('/api/v1/spmb/daftar', $this->dataPendaftar())->json('data.nomor_pendaftaran');

        $res = $this->getJson('/api/v1/spmb/status/' . strtolower($nomor))->assertOk();
        $res->assertJsonPath('data.nama', 'B*** S******');
        $res->assertJsonMissingPath('data.nik');
        $res->assertJsonMissingPath('data.nisn');
        $res->assertJsonMissingPath('data.email');

        $this->getJson('/api/v1/spmb/status/TIDAKADA')->assertNotFound();
        $this->getJson('/api/v1/spmb/status/pendek')->assertNotFound();
    }

    public function test_hanya_admin_membaca_data_pendaftar_dan_mengubah_status(): void
    {
        $spmb = Spmb::factoryLessCreate(\Illuminate\Support\Arr::except($this->dataPendaftar(), ["persetujuan"]));

        Sanctum::actingAs(User::factory()->guru()->create());
        $this->getJson('/api/v1/spmb')->assertForbidden();
        $this->getJson('/api/v1/spmb/' . $spmb->id)->assertForbidden();

        Sanctum::actingAs(User::factory()->admin()->create());
        $this->getJson('/api/v1/spmb/' . $spmb->id)->assertOk()->assertJsonPath('data.nik', '1275000000000001');

        // "perlu_perbaikan" wajib disertai catatan
        $this->putJson('/api/v1/spmb/' . $spmb->id . '/status', ['status' => 'perlu_perbaikan'])->assertStatus(422);
        $this->putJson('/api/v1/spmb/' . $spmb->id . '/status', ['status' => 'lulus'])
            ->assertOk()->assertJsonPath('data.status', 'lulus');

        // perubahan langsung terlihat di cek status publik
        $this->getJson('/api/v1/spmb/status/' . $spmb->nomor_pendaftaran)->assertJsonPath('data.status', 'lulus');
    }

    public function test_kepala_sekolah_dapat_melihat_statistik(): void
    {
        Spmb::factoryLessCreate(\Illuminate\Support\Arr::except($this->dataPendaftar(), ["persetujuan"]));

        Sanctum::actingAs(User::factory()->siswa()->create());
        $this->getJson('/api/v1/spmb/statistik')->assertForbidden();

        Sanctum::actingAs(User::factory()->kepalaSekolah()->create());
        $this->getJson('/api/v1/spmb/statistik')->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.per_status.menunggu', 1)
            ->assertJsonPath('data.per_status.lulus', 0);
    }

    // ---------- absensi ----------

    public function test_guru_mencatat_absensi_dan_siswa_melihat_rekapnya(): void
    {
        $kelas = Kelas::create(['nama' => 'X IPA 1']);
        $s1 = User::factory()->siswa($kelas->id)->create(['name' => 'Adi']);
        $s2 = User::factory()->siswa($kelas->id)->create(['name' => 'Bunga']);

        Sanctum::actingAs(User::factory()->guru()->create());
        $payload = [
            'kelas_id' => $kelas->id,
            'tanggal' => now()->toDateString(),
            'kehadiran' => [
                ['siswa_id' => $s1->id, 'status' => 'hadir'],
                ['siswa_id' => $s2->id, 'status' => 'sakit', 'keterangan' => 'Demam'],
            ],
        ];
        $this->postJson('/api/v1/absensi', $payload)->assertCreated()->assertJsonPath('data.ringkasan.hadir', 1);

        // menyimpan ulang pada tanggal yang sama memperbarui, bukan menggandakan
        $payload['kehadiran'][1]['status'] = 'hadir';
        $this->postJson('/api/v1/absensi', $payload)->assertCreated();
        $this->assertSame(1, Absensi::count());

        $this->getJson('/api/v1/absensi/rekap/' . $kelas->id)->assertOk()
            ->assertJsonPath('data.1.hadir', 1)
            ->assertJsonPath('meta.jumlah_pertemuan', 1);

        Sanctum::actingAs($s1);
        $this->getJson('/api/v1/absensi/saya')->assertOk()->assertJsonPath('ringkasan.hadir', 1);
        $this->postJson('/api/v1/absensi', $payload)->assertForbidden();
    }

    public function test_absensi_menolak_siswa_dari_kelas_lain(): void
    {
        $a = Kelas::create(['nama' => 'X IPA 1']);
        $b = Kelas::create(['nama' => 'X IPA 2']);
        $orangLain = User::factory()->siswa($b->id)->create();

        Sanctum::actingAs(User::factory()->guru()->create());
        $this->postJson('/api/v1/absensi', [
            'kelas_id' => $a->id,
            'tanggal' => now()->toDateString(),
            'kehadiran' => [['siswa_id' => $orangLain->id, 'status' => 'hadir']],
        ])->assertStatus(422);
    }

    public function test_ekspor_csv_hanya_admin_dan_menetralkan_rumus(): void
    {
        $kelas = Kelas::create(['nama' => 'X IPA 1']);
        $siswa = User::factory()->siswa($kelas->id)->create(['name' => '=HYPERLINK("http://jahat.test")']);

        $guru = User::factory()->guru()->create();
        Sanctum::actingAs($guru);
        $this->postJson('/api/v1/absensi', [
            'kelas_id' => $kelas->id, 'tanggal' => now()->toDateString(),
            'kehadiran' => [['siswa_id' => $siswa->id, 'status' => 'hadir']],
        ])->assertCreated();

        $this->get('/api/v1/absensi/export/' . $kelas->id)->assertForbidden();

        Sanctum::actingAs(User::factory()->admin()->create());
        $res = $this->get('/api/v1/absensi/export/' . $kelas->id)->assertOk();
        $isi = $res->streamedContent();

        $this->assertStringContainsString('Nama Siswa', $isi);
        $this->assertStringContainsString("'=HYPERLINK", $isi);   // diberi apostrof
        $this->assertStringNotContainsString(',=HYPERLINK', $isi); // tidak berdiri sebagai rumus
    }
}
