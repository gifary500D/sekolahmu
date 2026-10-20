# TODO SekolahMu

## Shell aplikasi, navigasi, dan state demo

- [x] Aplikasi menggunakan bahasa Indonesia, menampilkan brand SekolahMu, sidebar yang dapat dibuka/tutup, topbar pencarian/notifikasi/profil, route admin dan route publik yang saling terhubung.
- [x] Satu sumber state demo dipakai lintas modul; perubahan tambah/edit/hapus/status tersinkron ke dashboard dan disimpan melalui localStorage dengan label jelas bahwa ini bukan database produksi.
- [x] Tersedia loading/empty/error state yang masuk akal, toast notification, dialog konfirmasi, validasi form, dan layout responsive untuk desktop/tablet/ponsel.
- [x] Route manifest `/manus-routes.json` mencantumkan seluruh halaman yang diimplementasikan.

## Dashboard admin

- [x] Dashboard menampilkan total murid aktif, guru, kelas, pendaftar baru, ringkasan absensi hari ini, tren pendaftaran, ringkasan kehadiran, pendaftar terbaru, aktivitas administrasi, dan akses cepat.
- [x] Semua angka demo realistis, konsisten, tidak acak setiap render, dan memiliki konteks waktu/keterangan serta penanda data demo.

## SPMB dan verifikasi

- [x] Dashboard SPMB menampilkan total pendaftar, menunggu verifikasi, terverifikasi, diterima, ditolak, dan ringkasan berdasarkan jalur.
- [x] Tabel pendaftar memiliki nomor, nama, asal sekolah, jalur, tanggal, status, aksi; pencarian nama/nomor, filter status/jalur, pagination, detail pendaftar, dan aksi verifikasi.
- [x] Detail pendaftar menampilkan identitas sintetis, sekolah asal, jalur, dokumen, pemeriksaan, catatan, dan riwayat status.
- [x] Alur status mendukung Menunggu Verifikasi → Sedang Diverifikasi → Terverifikasi → Diterima atau Ditolak, dengan konfirmasi sebelum perubahan dan badge konsisten.

## Data akademik

- [x] Halaman murid, guru, dan kelas mendukung pencarian, filter/sorting yang relevan, pagination, detail, tambah/edit, dan konfirmasi hapus.
- [x] Data demo saling konsisten: kelas, wali kelas, dan jumlah murid mencerminkan daftar murid yang sama.

## Absensi

- [x] Pengguna dapat memilih kelas/tanggal, melihat murid kelas tersebut, menetapkan Hadir/Izin/Sakit/Alpa, melihat ringkasan, menandai semua hadir, mengubah per murid, dan menyimpan perubahan.
- [x] Tersedia riwayat/filter rekap dan ekspor CSV frontend; perubahan absensi memperbarui ringkasan yang relevan.

## Tugas

- [x] Halaman tugas menampilkan judul, deskripsi, kelas, guru, tenggat, prioritas Rendah/Normal/Tinggi, status; pencarian/filter, tambah/edit, dan konfirmasi hapus.
- [x] Tenggat dekat/terlewat diberi indikator visual; tidak ada klaim pengumpulan jawaban murid sudah tersedia.

## Administrasi dan transparansi backend

- [x] Manajemen pengguna menampilkan nama, email demo, peran Admin/Guru/Murid/Petugas SPMB, status akun, dan aktivitas terakhir.
- [x] Hak akses menunjukkan modul per peran serta catatan bahwa otorisasi wajib diterapkan di backend, bukan hanya menyembunyikan tombol.
- [x] Laporan dan pengaturan sekolah yang belum menjadi CRUD penuh menampilkan placeholder informatif, bukan tombol dekoratif.
- [x] `src/api.js` memusatkan konfigurasi endpoint dan menyiapkan kontrak REST Laravel 12; prototype tidak mengklaim autentikasi, database, upload, email, atau keamanan server aktif.

## Pendaftaran publik

- [x] Halaman publik terpisah menampilkan profil sekolah, periode demo, persyaratan, formulir lima tahap (data pribadi, sekolah asal, jalur, dokumen, persetujuan), validasi, progres, navigasi kembali tanpa kehilangan data, dan ringkasan akhir.
- [x] Simulasi pengiriman menghasilkan konfirmasi transparan dan nomor pendaftaran demo; halaman cek status menerima nomor demo dan memberi hasil.

## Quality bar

- [x] Pemeriksaan sintaks/diagnostik bersih pada source code yang diubah.
- [x] Dev server mendengarkan `0.0.0.0:3000`, root dan `/manus-routes.json` mengembalikan HTTP 200.
- [x] Checkpoint canonical dibuat setelah implementasi tervalidasi.
