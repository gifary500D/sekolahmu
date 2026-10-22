<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SapaanDanTugasBeritaTest extends TestCase
{
    use RefreshDatabase;

    public function test_aplikasi_menggunakan_timezone_asia_jakarta(): void
    {
        $this->assertEquals('Asia/Jakarta', config('app.timezone'));
    }

    public function test_identitas_sekolah_sma_smk_dan_seksi_program_selaras(): void
    {
        $response = $this->withoutVite()->get('/');
        $response->assertOk();

        // 1. Identitas SMA/SMK Pemda Bahorok
        $response->assertSee('SMA/SMK Pemda Bahorok');
        $response->assertDontSee('SMA Pemda Bahorok');

        // 2. Istilah Kampus Utama diganti menjadi Gedung Utama
        $response->assertSee('GEDUNG UTAMA');
        $response->assertDontSee('Kampus Utama');

        // 3. Selaras Seksi Program SMA & SMK
        $response->assertSee('SMA: Peminatan MIPA');
        $response->assertSee('SMA: Peminatan IPS');
        $response->assertSee('SMK: Teknik Komputer &amp; Jaringan', false);
        $response->assertSee('SMK: Manajemen &amp; Bisnis Terapan', false);
        $response->assertSee('SMK: Kejuruan Terapan &amp; Vokasi', false);
    }

    public function test_dashboard_admin_guru_siswa_menampilkan_sapaan_dinamis(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password_changed' => true]);
        $guru = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
        $kelas = Kelas::create(['nama' => 'X-IPA-1', 'tingkat' => '10', 'jurusan' => 'IPA']);
        $siswa = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelas->id, 'password_changed' => true]);

        // Dashboard Admin
        $resAdmin = $this->actingAs($admin)->get('/dashboard');
        $resAdmin->assertOk();
        $resAdmin->assertSee('data-greeting', false);
        $resAdmin->assertSee('dynamic-greeting', false);

        // Dashboard Guru
        $resGuru = $this->actingAs($guru)->get('/dashboard');
        $resGuru->assertOk();
        $resGuru->assertSee('data-greeting', false);
        $resGuru->assertSee('dynamic-greeting', false);

        // Dashboard Siswa
        $resSiswa = $this->actingAs($siswa)->get('/dashboard');
        $resSiswa->assertOk();
        $resSiswa->assertSee('data-greeting', false);
        $resSiswa->assertSee('dynamic-greeting', false);
    }

    public function test_halaman_berita_publik_menampilkan_daftar_dan_modal_pratinjau(): void
    {
        Berita::create([
            'judul' => 'Prestasi Gemilang Siswa Bahorok',
            'slug' => 'prestasi-gemilang-siswa-bahorok',
            'ringkasan' => 'Ringkasan berita prestasi',
            'konten' => 'Isi berita lengkap tentang prestasi siswa dalam olimpiade sains nasional.',
            'status' => 'terbit',
            'diterbitkan_pada' => now()->subHour(),
        ]);

        $response = $this->get(route('berita.index'));
        $response->assertOk();
        $response->assertSee('Prestasi Gemilang Siswa Bahorok');
        $response->assertSee('newsDetailModal');
        $response->assertSee('openNewsModal');
        $response->assertSee('Baca Selengkapnya');
    }

    public function test_cms_berita_admin_memiliki_pratinjau_dan_aksi_berfungsi(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password_changed' => true]);

        $berita = Berita::create([
            'judul' => 'Pengumuman Libur Semester',
            'slug' => 'pengumuman-libur-semester',
            'konten' => 'Informasi libur semester genap untuk seluruh siswa.',
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
        ]);

        $resIndex = $this->actingAs($admin)->get(route('admin.cms.index'));
        $resIndex->assertOk();
        $resIndex->assertSee('Pengumuman Libur Semester');
        $resIndex->assertSee('cmsNewsModal');
        $resIndex->assertSee('openCmsNewsModal');

        // Test delete
        $resDelete = $this->actingAs($admin)->delete(route('admin.cms.berita.delete', $berita->id));
        $resDelete->assertRedirect(route('admin.cms.index'));
        $this->assertDatabaseMissing('berita', ['id' => $berita->id]);
    }

    public function test_guru_pengampu_dapat_melihat_pratinjau_berkas_dari_private_storage(): void
    {
        Storage::fake('local');

        $kelas = Kelas::create(['nama' => 'XI-MIPA-1', 'tingkat' => '11', 'jurusan' => 'IPA']);
        $guruPengampu = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
        $guruLain = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
        $siswa = User::factory()->create(['role' => 'siswa', 'kelas_id' => $kelas->id, 'password_changed' => true]);

        $tugas = Tugas::create([
            'judul' => 'Praktikum Kimia Organik',
            'mata_pelajaran' => 'Kimia',
            'kelas_id' => $kelas->id,
            'guru_id' => $guruPengampu->id,
            'tenggat' => now()->addDays(3),
            'prioritas' => 'tinggi',
            'deskripsi' => 'Kumpulkan lembar pengamatan dalam format PDF atau foto.',
        ]);

        $filePath = 'private/tugas/test_submission.pdf';
        Storage::disk('local')->put($filePath, '%PDF-1.4 test file content');

        $submission = TugasSiswa::create([
            'tugas_id' => $tugas->id,
            'siswa_id' => $siswa->id,
            'status' => 'selesai',
            'file_path' => $filePath,
            'diselesaikan_pada' => now(),
        ]);

        // 1. Guru pengampu dapat mengakses pratinjau tugas
        $resPengampu = $this->actingAs($guruPengampu)->get(route('guru.tugas.preview', $submission->id));
        $resPengampu->assertOk();

        // 2. Guru lain ditolak 403
        $this->actingAs($guruLain)->get(route('guru.tugas.preview', $submission->id))->assertForbidden();

        // 3. Siswa ditolak 403
        $this->actingAs($siswa)->get(route('guru.tugas.preview', $submission->id))->assertForbidden();

        // 4. Pengunjung anonim diarahkan ke login
        $this->post('/logout');
        $this->get(route('guru.tugas.preview', $submission->id))->assertRedirect('/login');
    }

    public function test_halaman_tugas_guru_dan_pengumpulan_memuat_modal_pratinjau(): void
    {
        $guru = User::factory()->create(['role' => 'guru', 'password_changed' => true]);
        $kelas = Kelas::create(['nama' => 'XII-IPA-2', 'tingkat' => '12', 'jurusan' => 'IPA']);

        $tugas = Tugas::create([
            'judul' => 'Tugas Biologi Sel',
            'mata_pelajaran' => 'Biologi',
            'kelas_id' => $kelas->id,
            'guru_id' => $guru->id,
            'tenggat' => now()->addDay(),
            'prioritas' => 'sedang',
            'deskripsi' => 'Amati preparat sel bawang merah.',
        ]);

        // Halaman Index Tugas Guru
        $resIndex = $this->actingAs($guru)->get(route('guru.tugas.index'));
        $resIndex->assertOk();
        $resIndex->assertSee('taskDetailModal');
        $resIndex->assertSee('openTaskModal');

        // Halaman Submissions Tugas Guru
        $resSub = $this->actingAs($guru)->get(route('guru.tugas.submissions', $tugas->id));
        $resSub->assertOk();
        $resSub->assertSee('previewModal');
        $resSub->assertSee('openPreview');
        $resSub->assertSee('Petunjuk &amp; Instruksi Tugas', false);
    }

    public function test_upload_berita_gambar_dan_render_via_media_route_berfungsi(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin', 'password_changed' => true]);
        $fakeImage = UploadedFile::fake()->create('kegiatan-sekolah.jpg', 100, 'image/jpeg');

        // Upload Berita
        $response = $this->actingAs($admin)->post(route('admin.cms.berita.store'), [
            'judul' => 'Inovasi Robotika Siswa SMA/SMK',
            'konten' => 'Siswa berhasil menciptakan robot pemilah sampah otomatis.',
            'status' => 'terbit',
            'gambar' => $fakeImage,
        ]);

        $response->assertRedirect(route('admin.cms.index'));

        $berita = Berita::where('judul', 'Inovasi Robotika Siswa SMA/SMK')->first();
        $this->assertNotNull($berita);
        $this->assertNotNull($berita->gambar_path);
        Storage::disk('public')->assertExists($berita->gambar_path);

        // Verifikasi URL /media/{path} pada halaman CMS Berita Admin
        $resCms = $this->actingAs($admin)->get(route('admin.cms.index'));
        $resCms->assertOk();
        $expectedMediaUrl = route('media.file', ['path' => $berita->gambar_path]);
        $resCms->assertSee($expectedMediaUrl, false);
        $resCms->assertSee('gambarBeritaInput');
        $resCms->assertSee('gambarCompressInfo');

        // Verifikasi Halaman Berita Publik memuat URL media
        $resBerita = $this->get(route('berita.index'));
        $resBerita->assertOk();
        $resBerita->assertSee($expectedMediaUrl, false);

        // Verifikasi route /media/{path} mengembalikan file status 200
        $resMedia = $this->get($expectedMediaUrl);
        $resMedia->assertOk();

        // Verifikasi route /media/{path} mengembalikan 404 untuk file yang tidak ada
        $this->get('/media/berita/tidak-ada-file-xyz.jpg')->assertNotFound();

        // Verifikasi path traversal diblokir dengan 400
        $this->get('/media/../config/app.php')->assertStatus(400);
    }
}
