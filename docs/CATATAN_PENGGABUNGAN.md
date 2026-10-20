# Catatan Penggabungan

Dibuat dari branch di `github.com/gifary500D/sekolahmu`: `main` (= `company-profile`), `frontend-integration`, `backendsuclyn2`, dan `backend/tugas-konten-fauzi`. Branch Anggota 1 (arsitektur, autentikasi, peran, dokumentasi API) tidak ada di repo, sehingga bagian itu dibuat ulang secukupnya.

## Asal tiap bagian
| Bagian | Sumber | Keterangan |
|---|---|---|
| Kerangka Laravel 12 + Sanctum | `backendsuclyn2` | Dasar proyek |
| Halaman Blade, CSS, JS | `main` | `app.css` dan `app.js` dikembalikan dari `main` (sempat tertimpa kerangka bawaan di branch Suclyn) |
| Prototype frontend | `frontend-integration` | Disalin utuh ke `frontend-prototype/` |
| SPMB, absensi | `backendsuclyn2` | Dilengkapi dan dirapikan, lihat di bawah |
| Tugas, notifikasi, berita, agenda, galeri | `backend/tugas-konten-fauzi` | Tidak diubah, kecuali pemuatan rute |
| Autentikasi, peran, kelas, data demo | baru | Mengisi bagian Anggota 1 yang belum ada |

## Masalah yang ditemukan dan perbaikannya
1. **Dua kerangka Laravel berbeda** (Laravel 10 di `main`, 12 di dua branch backend) dan `package.json` bercampur Tailwind 3 dengan konfigurasi Tailwind 4. Disatukan ke Laravel 12 dan Tailwind 4 + Vite 8. `npm run build` sudah diuji berhasil.
2. **`composer.lock` branch Suclyn memerlukan PHP 8.4**, padahal XAMPP berisi PHP 8.2. Berkas dihapus dan syarat PHP diubah menjadi `^8.2`.
3. **Rute SPMB menunjuk ke method yang tidak ada** (`cekStatus`, `updateStatus`). Keduanya dibuat, ditambah daftar, detail, dan statistik untuk admin dan kepala sekolah.
4. **Tidak ada endpoint login**, padahal rute dilindungi Sanctum. Ditambah `/auth/login`, `/auth/me`, `/auth/logout`.
5. **Tidak ada peran pengguna.** Ditambah kolom `role` dan `kelas_id` pada `users`, tabel `kelas`, dan middleware `role:...`. Tanpa ini, siapa pun yang login dapat membuat atau menghapus tugas dan membaca data pendaftar.
6. **Formulir `/daftar` mengirim ke `/proses-pendaftaran`** yang hanya simulasi, dengan nama field berbeda (`nama` vs `nama_lengkap`) dan tanpa NIK serta jalur. Formulir kini mengirim ke API, menampilkan nomor pendaftaran, dan bisa dicetak. Halaman `/cek-status` ditambahkan.
7. **Tabel `tugas` bentrok**: versi Suclyn memakai nama kelas berupa teks dan tanpa status per siswa. Versi Anggota 3 dipakai karena sesuai blueprint (guru membuat tugas per kelas, siswa mengubah status, notifikasi tenggat). Endpoint lama `/tugas/buat` dan `/tugas/kelas/{kelas}` tidak dipertahankan.
8. **Absensi dirancang ulang**: versi lama menyimpan nama siswa dalam JSON sehingga siswa tidak bisa melihat rekap sendiri. Kini ada tabel `absensi` (sesi per kelas per tanggal) dan `absensi_detail` (status hadir, izin, sakit, alpa per siswa), rekap per siswa, rekap siswa, dan ekspor CSV khusus admin dengan perlindungan penyisipan rumus.
9. **Nomor pendaftaran** berurutan (`SPMB-2026-0001`) mudah ditebak. Diganti 8 karakter acak sesuai blueprint, dan status mengikuti blueprint (`menunggu`, `diverifikasi`, `perlu_perbaikan`, `lulus`, `tidak_lulus`) beserta kolom `catatan`.
10. **Emoji di antarmuka** (layout dan formulir) diganti ikon SVG sesuai prinsip antarmuka blueprint.
11. **Halaman uji `public/index.html` dan `public/dashboard.html`** menimpa rute `/` dan memanggil endpoint lama. Dipindah ke `docs/legacy-suclyn/`.
12. Berkas alat bantu (`.claude`, `.mcp.json`, `AGENTS.md`, `CLAUDE.md`, `boost.json`, `database.sqlite`) tidak disertakan.
13. Sesi dan cache dipindah ke `file` agar halaman tidak error saat MySQL belum menyala.

## Belum tersedia
- Pengelolaan akun guru dan siswa oleh admin (CRUD pengguna) dan CRUD kelas. Saat ini akun dan kelas dibuat lewat seeder.
- Unggah berkas SPMB (kolom `berkas_*` sudah ada, fiturnya belum).
- `frontend-prototype/` masih memakai data simulasi dan nama endpoint yang berbeda dari API ini (misalnya `/attendance`, `/tasks`); perlu disambungkan oleh tim frontend.
- Dokumentasi API otomatis (Swagger/Scribe), notifikasi WhatsApp/email, PWA, dan mode gelap.
- Terjemahan pesan validasi ke bahasa Indonesia.

## Yang belum bisa diuji
Lingkungan penyusunan tidak dapat memasang paket Composer, sehingga `php artisan migrate` dan `php artisan test` belum dijalankan. Yang sudah diperiksa: sintaks seluruh berkas PHP, logika inti (penyamaran nama, pembersihan CSV, nomor acak), dan `npm run build`. Jalankan `php artisan migrate --seed` dan `php artisan test` di komputer Anda, lalu laporkan bila ada galat.

## Mengirim ke GitHub
```
git checkout -b integrasi
git add .
git commit -m "Gabungkan seluruh modul tim"
git push -u origin integrasi
```
Buka pull request ke `main` dan minta koordinator tim memeriksanya sebelum digabung.
