<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can view registration page', function () {
    $response = $this->get('/daftar');
    $response->assertStatus(200);
});

test('user can submit registration form successfully', function () {
    $this->withoutMiddleware();
    $this->get('/daftar');

    $response = $this->post('/proses-pendaftaran', [
        'nama_lengkap' => 'Budi Santoso',
        'gender' => 'laki-laki',
        'tempat_lahir' => 'Bahorok',
        'tanggal_lahir' => '2010-05-12',
        'nisn' => '1234567890',
        'nik' => '1234567890123456',
        'agama' => 'islam',
        'email' => 'budi@example.com',
        'telepon' => '081234567890',
        'alamat' => 'Jl. Pendidikan No. 5, Bahorok',
        'kota' => 'Kabupaten Langkat',
        'provinsi' => 'Sumatera Utara',
        'nama_ayah' => 'Joko Santoso',
        'pekerjaan_ayah' => 'Petani',
        'nama_ibu' => 'Siti Aminah',
        'pekerjaan_ibu' => 'Ibu Rumah Tangga',
        'telepon_ortu' => '081234567891',
        'asal_sekolah' => 'SMPN 1 Bahorok',
        'nilai_rata' => '88.50',
        'tahun_lulus' => '2026',
        'program' => 'ipa',
        'jalur_pendaftaran' => 'Zonasi',
        'confirm_data' => 'on',
        'agree_terms' => 'on',
        'agree_privacy' => 'on',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');
    
    $this->assertDatabaseHas('spmb', [
        'nik' => '1234567890123456',
        'nama_lengkap' => 'Budi Santoso',
    ]);
});
