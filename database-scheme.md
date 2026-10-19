# Skema Relasi Database Sekolahmu (DBML & Dokumentasi Relasi)

Salin kode DBML di bawah ini dan tempelkan ke editor di [dbdiagram.io](https://dbdiagram.io):

```dbml
// ==========================================
// SKEMA DATABASE APLIKASI SEKOLAHMU
// ==========================================

Table users {
  id bigint [pk, increment]
  name varchar
  email varchar [unique]
  nisn varchar [unique, null]
  role varchar // 'admin', 'guru', 'siswa'
  kelas_id bigint [null]
  password varchar
  password_changed boolean
  remember_token varchar [null]
  deleted_at timestamp [null]
  created_at timestamp
  updated_at timestamp
}

Table kelas {
  id bigint [pk, increment]
  nama varchar [unique]
  tingkat varchar // '10', '11', '12'
  program varchar // 'ipa', 'ips', 'bahasa'
  wali_kelas_id bigint [null]
  created_at timestamp
  updated_at timestamp
}

Table spmb {
  id bigint [pk, increment]
  nomor_pendaftaran varchar [unique]
  nama_lengkap varchar
  gender varchar // 'laki-laki', 'perempuan'
  tempat_lahir varchar
  tanggal_lahir date
  nisn varchar
  nik varchar
  agama varchar
  email varchar
  telepon varchar
  alamat text
  kota varchar
  provinsi varchar
  nama_ayah varchar
  pekerjaan_ayah varchar
  nama_ibu varchar
  pekerjaan_ibu varchar
  telepon_ortu varchar
  asal_sekolah varchar
  nilai_rata decimal
  tahun_lulus year
  program varchar
  jalur_pendaftaran varchar
  status varchar
  note text [null]
  created_at timestamp
  updated_at timestamp
}

Table tugas {
  id bigint [pk, increment]
  judul varchar
  deskripsi text [null]
  mata_pelajaran varchar
  kelas_id bigint [null]
  guru_id bigint
  tenggat datetime
  prioritas varchar // 'rendah', 'sedang', 'tinggi'
  deleted_at timestamp [null]
  created_at timestamp
  updated_at timestamp
}

Table tugas_siswa {
  id bigint [pk, increment]
  tugas_id bigint
  siswa_id bigint
  status varchar // 'belum', 'dikerjakan', 'selesai'
  file_path varchar [null]
  nilai decimal [null]
  catatan text [null]
  diselesaikan_pada timestamp [null]
  pengingat_dikirim_pada timestamp [null]
  created_at timestamp
  updated_at timestamp
}

Table absensi {
  id bigint [pk, increment]
  kelas varchar
  tanggal date
  data_kehadiran json
  created_at timestamp
  updated_at timestamp
}

Table rosters {
  id bigint [pk, increment]
  kelas_id bigint
  mata_pelajaran varchar
  guru_id bigint [null]
  hari varchar // 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
  jam_mulai time
  jam_selesai time
  tahun_ajaran varchar
  semester varchar // 'Ganjil', 'Genap'
  created_at timestamp
  updated_at timestamp
}

Table berita {
  id bigint [pk, increment]
  judul varchar
  slug varchar [unique]
  ringkasan varchar [null]
  konten longtext
  gambar_path varchar [null]
  status varchar // 'draf', 'terbit'
  diterbitkan_pada timestamp [null]
  penulis_id bigint [null]
  created_at timestamp
  updated_at timestamp
}

Table agenda {
  id bigint [pk, increment]
  judul varchar
  deskripsi text [null]
  lokasi varchar [null]
  mulai datetime
  selesai datetime [null]
  created_at timestamp
  updated_at timestamp
}

Table galeri {
  id bigint [pk, increment]
  judul varchar
  keterangan varchar [null]
  album varchar [null]
  gambar_path varchar [null]
  created_at timestamp
  updated_at timestamp
}

Table audit_logs {
  id bigint [pk, increment]
  user_id bigint [null]
  action varchar
  description text
  ip_address varchar [null]
  created_at timestamp
  updated_at timestamp
}

// ==========================================
// RELASI ANTAR TABEL (FOREIGN KEYS)
// ==========================================

Ref: users.kelas_id > kelas.id [delete: set null]
Ref: kelas.wali_kelas_id > users.id [delete: set null]

Ref: tugas.kelas_id > kelas.id [delete: cascade]
Ref: tugas.guru_id > users.id [delete: cascade]

Ref: tugas_siswa.tugas_id > tugas.id [delete: cascade]
Ref: tugas_siswa.siswa_id > users.id [delete: cascade]

Ref: rosters.kelas_id > kelas.id [delete: cascade]
Ref: rosters.guru_id > users.id [delete: set null]

Ref: berita.penulis_id > users.id [delete: set null]
Ref: audit_logs.user_id > users.id [delete: set null]
```

---

## Penjelasan Detail Relasi Database (Eloquent Relationships)

Berikut adalah penjelasan jenis relasi (Cardinality) antar tabel dalam sistem:

### 1. Kelas ↔ Siswa (`users`)
* **Jenis Relasi:** **One-to-Many** (`1 Kelas` memiliki banyak `Siswa`).
* **Penjelasan:** Satu rombongan belajar (Kelas) dapat diisi oleh banyak siswa, di mana setiap siswa terdaftar di satu kelas tertentu melalui *foreign key* `kelas_id` pada tabel `users`.

### 2. Kelas ↔ Wali Kelas (`users`)
* **Jenis Relasi:** **Many-to-One / Belongs-To** (`Banyak Kelas` diampu oleh `1 Guru`).
* **Penjelasan:** Setiap kelas memiliki satu guru sebagai wali kelas melalui *foreign key* `wali_kelas_id` pada tabel `kelas`.

### 3. Guru (`users`) ↔ Tugas
* **Jenis Relasi:** **One-to-Many** (`1 Guru` membuat banyak `Tugas`).
* **Penjelasan:** Seorang guru pengampu dapat memberikan banyak penugasan mata pelajaran melalui *foreign key* `guru_id` pada tabel `tugas`.

### 4. Kelas ↔ Tugas
* **Jenis Relasi:** **One-to-Many** (`1 Kelas` menerima banyak `Tugas`).
* **Penjelasan:** Penugasan dari guru ditujukan untuk kelas tertentu melalui *foreign key* `kelas_id` pada tabel `tugas` (atau global jika bernilai `null`).

### 5. Tugas ↔ Siswa (`users`) via `tugas_siswa` (Pivot Table)
* **Jenis Relasi:** **Many-to-Many** (`Banyak Tugas` dikerjakan oleh `Banyak Siswa`).
* **Penjelasan:** Dihubungkan melalui tabel perantara transaksional `tugas_siswa`. Satu tugas dikerjakan oleh banyak siswa, dan satu siswa dapat mengumpulkan banyak tugas. Tabel ini menyimpan atribut status pengerjaan, *file path* lampiran, nilai, dan catatan evaluasi.

### 6. Kelas ↔ Roster (Jadwal Pelajaran)
* **Jenis Relasi:** **One-to-Many** (`1 Kelas` memiliki banyak `Roster` jadwal).
* **Penjelasan:** Setiap kelas memiliki jadwal mata pelajaran harian yang dihubungkan melalui *foreign key* `kelas_id` pada tabel `rosters`.

### 7. Guru (`users`) ↔ Roster
* **Jenis Relasi:** **One-to-Many** (`1 Guru` mengajar di banyak `Roster` jadwal).
* **Penjelasan:** Seorang guru pengampu mengajar pada jadwal pelajaran tertentu melalui *foreign key* `guru_id` pada tabel `rosters`.

### 8. Penulis / Admin (`users`) ↔ Berita
* **Jenis Relasi:** **Many-to-One / Belongs-To** (`Banyak Berita` ditulis oleh `1 Penulis/Admin`).
* **Penjelasan:** Artikel atau pengumuman portal sekolah dibuat oleh seorang penulis (Admin) melalui *foreign key* `penulis_id` pada tabel `berita`.

### 9. Pengguna (`users`) ↔ Audit Logs
* **Jenis Relasi:** **One-to-Many** (`1 User` menghasilkan banyak `Audit Log` aktivitas).
* **Penjelasan:** Setiap tindakan penting yang dilakukan pengguna (login, tambah data, hapus data) dicatat sebagai riwayat log sistem melalui *foreign key* `user_id` pada tabel `audit_logs`.
