# API Tugas dan Konten (Anggota 3)

Prefix `/api/v1`. Kirim `Accept: application/json`. Rute bertanda (token) memerlukan `Authorization: Bearer <token>`.

## Publik
| Metode | Path | Keterangan |
|---|---|---|
| GET | `/berita` | Berita terbit. Query: `cari`, `per_page`, `page` |
| GET | `/berita/{slug}` | Detail berita |
| GET | `/agenda` | Query: `akan_datang=1`, `dari`, `sampai`, `per_page` |
| GET | `/agenda/{id}` | Detail agenda |
| GET | `/agenda/{id}/ics` | Unduh berkas kalender .ics |
| GET | `/galeri` | Query: `album`, `per_page` |

## Tugas (token)
| Metode | Path | Peran | Keterangan |
|---|---|---|---|
| GET | `/tugas` | semua | Siswa: tugas kelasnya dengan `status_saya`. Guru: tugas miliknya. Admin dan kepala sekolah: semua. Query: `status`, `prioritas`, `kelas_id`, `per_page` |
| POST | `/tugas` | guru, admin | `judul`, `deskripsi`, `mata_pelajaran`, `kelas_id`, `tenggat`, `prioritas` (`rendah`, `sedang`, `tinggi`) |
| GET | `/tugas/{id}` | sesuai kepemilikan | Detail |
| PUT/PATCH | `/tugas/{id}` | pemilik, admin | Tenggat baru mengatur ulang pengingat |
| DELETE | `/tugas/{id}` | pemilik, admin | Hapus |
| PATCH | `/tugas/{id}/status` | siswa kelas terkait | `status`: `belum`, `dikerjakan`, `selesai` |
| GET | `/tugas/{id}/progres` | pemilik, admin, kepala sekolah | Progres seluruh siswa di kelas |

## Notifikasi (token)
`GET /notifikasi`, `POST /notifikasi/{id}/baca`, `POST /notifikasi/baca-semua`.

## Pengelolaan konten (admin)
| Metode | Path | Keterangan |
|---|---|---|
| GET | `/admin/berita`, `/admin/berita/{id}` | Daftar (termasuk draf) dan detail |
| POST | `/admin/berita` | `judul`, `ringkasan`, `konten`, `status` (`draf`/`terbit`), `gambar` (opsional) |
| PUT | `/admin/berita/{id}` | Untuk unggah gambar kirim `POST` multipart dengan `_method=PUT`. `hapus_gambar=1` menghapus gambar |
| DELETE | `/admin/berita/{id}` | Hapus |
| POST/PUT/DELETE | `/admin/agenda[/{id}]` | `judul`, `deskripsi`, `lokasi`, `mulai`, `selesai`. PUT mengganti seluruh field |
| POST/PUT/DELETE | `/admin/galeri[/{id}]` | `judul`, `keterangan`, `album`, `gambar` (wajib saat POST) |

Gambar disimpan di disk `public`; jalankan `php artisan storage:link` agar dapat diakses.
