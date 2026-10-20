# SekolahKu Digital

Portal sekolah berbasis Laravel 12: portal publik, PPDB/SPMB daring, absensi per kelas, manajemen tugas, berita, agenda, galeri, dan REST API v1 (token Sanctum). Proyek ini adalah hasil penggabungan seluruh branch tim. Rincian asal kode dan perubahan ada di `docs/CATATAN_PENGGABUNGAN.md`.

## Kebutuhan
PHP 8.2 atau lebih baru (XAMPP dengan PHP 8.2.12 sudah cukup), Composer, MySQL, Node.js 20 atau lebih baru.

## Pemasangan (Windows + XAMPP)
1. Nyalakan **Apache** dan **MySQL** di XAMPP, lalu buat database kosong `sekolahku_digital` di phpMyAdmin.
2. Di folder proyek:
   ```
   copy .env.example .env
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   npm install
   npm run build
   php artisan serve
   ```
3. Buka `http://localhost:8000`.

Berkas `composer.lock` sengaja tidak disertakan agar Composer memilih versi paket yang cocok dengan PHP di komputer masing-masing. Setelah `composer install` berhasil, berkas itu akan terbentuk otomatis.

`php artisan migrate --seed` memakai database kosong. Bila database lama sudah terlanjur berisi tabel dari branch sebelumnya, pakai database baru atau jalankan `php artisan migrate:fresh --seed` (menghapus semua tabel dan data).

## Akun demo (data fiktif, kata sandi semua akun: `password`)
| Peran | Email |
|---|---|
| Admin sekolah | admin@sekolahku.test |
| Kepala sekolah | kepsek@sekolahku.test |
| Guru | guru1@sekolahku.test, guru2@sekolahku.test |
| Siswa kelas X IPA 1 | siswa11@sekolahku.test sampai siswa16@sekolahku.test |
| Siswa kelas X IPA 2 | siswa21@sekolahku.test sampai siswa26@sekolahku.test |

Ubah atau hapus akun ini sebelum dipakai di luar demonstrasi.

## Halaman web
| Alamat | Isi |
|---|---|
| `/` | Beranda |
| `/daftar` | Formulir pendaftaran, dikirim ke API dan menampilkan nomor serta bukti cetak |
| `/cek-status` | Cek status pendaftaran tanpa login |

## REST API v1 (prefix `/api/v1`)
Autentikasi: `POST /auth/login` mengembalikan token, lalu kirim header `Authorization: Bearer <token>`. Selalu sertakan `Accept: application/json`.

| Kelompok | Endpoint | Akses |
|---|---|---|
| Auth | `POST /auth/login`, `GET /auth/me`, `POST /auth/logout` | publik, login, login |
| PPDB | `POST /spmb/daftar`, `GET /spmb/status/{nomor}` | publik |
| PPDB | `GET /spmb`, `GET /spmb/{id}`, `PUT /spmb/{id}/status` | admin |
| PPDB | `GET /spmb/statistik` | admin, kepala sekolah |
| Absensi | `GET /kelas`, `GET /kelas/{id}/siswa`, `GET /absensi`, `GET /absensi/rekap/{kelas}` | guru, admin, kepala sekolah |
| Absensi | `POST /absensi` | guru, admin |
| Absensi | `GET /absensi/saya` | siswa |
| Absensi | `GET /absensi/export/{kelas}` (CSV) | admin |
| Tugas | `GET/POST /tugas`, `GET/PUT/PATCH/DELETE /tugas/{id}`, `GET /tugas/{id}/progres` | sesuai peran |
| Tugas | `PATCH /tugas/{id}/status` | siswa kelas terkait |
| Notifikasi | `GET /notifikasi`, `POST /notifikasi/{id}/baca`, `POST /notifikasi/baca-semua` | login |
| Konten publik | `GET /berita`, `/berita/{slug}`, `/agenda`, `/agenda/{id}`, `/agenda/{id}/ics`, `/galeri` | publik |
| Konten admin | `GET/POST/PUT/DELETE /admin/berita`, `/admin/agenda`, `/admin/galeri` | admin |

Contoh:
```
curl -X POST http://localhost:8000/api/v1/auth/login -H "Accept: application/json" -H "Content-Type: application/json" -d "{\"email\":\"guru1@sekolahku.test\",\"password\":\"password\"}"
```
Rincian parameter modul tugas dan konten ada di `docs/API_TUGAS_KONTEN.md`.

## Pengingat tenggat tugas
`php artisan tugas:kirim-pengingat` mengirim notifikasi ke siswa yang belum menyelesaikan tugas berakhir dalam 24 jam. Perintah ini dijadwalkan tiap jam. Saat pengembangan, jalankan `php artisan schedule:work` di terminal terpisah. Di server, pasang cron `* * * * * php artisan schedule:run`.

## Pengujian
```
php artisan test
```

## Struktur
```
app/Http/Controllers/Api/V1   Auth, Spmb, Absensi, Tugas, Notifikasi, Berita, Agenda, Galeri
app/Http/Controllers          PageController (halaman web)
app/Models, app/Policies      model dan kebijakan akses
database/migrations, seeders  skema dan data demo
resources/views               Blade (beranda, daftar, cek-status)
frontend-prototype/           prototype SPA terpisah (belum terhubung ke API)
docs/                         catatan penggabungan, API, berkas uji lama
```
