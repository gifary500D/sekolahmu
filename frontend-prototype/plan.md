# Rencana Implementasi SekolahMu

## Ringkasan pendekatan

SekolahMu akan dibangun sebagai SPA frontend-only yang berjalan tanpa API eksternal atau API key. Aplikasi menggunakan HTML, CSS, dan JavaScript modular dengan server Node.js built-in untuk preview pada port 3000. Satu store demo menjadi sumber state untuk dashboard, SPMB, data akademik, absensi, tugas, dan pengguna; perubahan disimpan ke localStorage agar alur demo tetap konsisten setelah refresh. Lapisan `api.js` menyediakan kontrak/fungsi placeholder yang siap diganti implementasi REST Laravel 12.

Target utamanya adalah prototype yang langsung dapat diuji: navigasi sidebar, pencarian/filter/pagination, CRUD demo, perubahan status SPMB, absensi, ekspor CSV, formulir publik bertahap, dialog konfirmasi, toast, responsive layout, dan placeholder informatif untuk fitur administrasi yang belum menjadi CRUD penuh.

## Struktur proyek

- `index.html` — shell SPA, metadata, mount point, dan route publik/admin.
- `styles.css` — token visual, layout responsive, tabel, form, dialog, toast, dan state visual.
- `src/data.js` — data sintetis konsisten dan konfigurasi menu/role.
- `src/api.js` — konfigurasi base URL dan kontrak endpoint Laravel 12 (simulasi).
- `src/store.js` — single source of truth, localStorage persistence, reducer-like mutations.
- `src/ui.js` — komponen render HTML kecil, badge, chart CSS/SVG, modal, toast, tabel.
- `src/app.js` — router hash, event delegation, halaman dashboard dan semua modul.
- `public/manus-routes.json` — deklarasi route yang bisa diinspeksi platform.
- `server.js` — static server sederhana yang mendukung SPA fallback pada preview.
- `app.config.ts` — metadata project logo bila aset CDN tersedia.
- `TODO.md` — outcome dan kriteria implementasi.

## Keputusan desain

### Opsi gaya singkat

- **Admin editorial / institutional SaaS** — 0,06: panel data yang tenang dengan aksen biru dan tipografi tegas.
- **Soft campus glass** — 0,04: panel transparan dan gradient lembut dengan nuansa kampus modern.
- **Neo-brutalist school ops** — 0,03: kontras tinggi, garis tegas, dan kontrol yang sangat utilitarian.

Pilihan: **Admin editorial / institutional SaaS** karena paling cocok untuk sistem sekolah yang dipercaya admin, guru, dan orang tua sekaligus.

### Design Movement

Institutional SaaS yang meminjam ketenangan editorial: permukaan terang, bidang navigasi navy, garis pemisah halus, dan aksen biru elektrik untuk aksi penting.

### Core Principles

1. **Orientasi kerja** — setiap halaman memiliki judul, konteks waktu, aksi utama, dan state yang jelas.
2. **Kepadatan terukur** — data cukup padat untuk operasi admin tanpa terasa sesak.
3. **Kepercayaan melalui konteks** — label "Data demo", periode, status, dan catatan simulasi selalu terlihat.
4. **Progressive disclosure** — detail dan aksi lanjutan muncul saat dibutuhkan melalui drawer/modal.

### Color Philosophy

Navy memberi rasa institusional dan aman untuk urusan administrasi; biru cerah dipakai sebagai sinyal interaksi dan kemajuan, bukan dekorasi. Permukaan off-white serta abu-abu dingin menjaga keterbacaan tabel, sementara hijau/amber/merah hanya dipakai untuk makna status.

### Layout Paradigm

Shell dua zona: rail navigasi tetap di kiri dan workspace editorial di kanan. Header halaman membentuk jalur kerja, lalu konten tersusun sebagai kombinasi strip insight, panel kerja utama, dan panel aktivitas; bukan grid kartu seragam. Pada mobile rail berubah menjadi drawer dan tabel menggunakan overflow terkontrol.

### Signature Elements

- **Rail navy dengan marker aktif** berbentuk garis biru dan titik kecil.
- **Insight strip** dengan angka besar, konteks waktu, dan micro-bar.
- **Status pills** dengan warna semantik yang konsisten di seluruh modul.

### Interaction Philosophy

Aksi utama selalu memberi umpan balik langsung melalui toast, status tombol, dan perubahan data yang terlihat. Aksi destruktif atau perubahan status penting memakai konfirmasi dengan alasan yang jelas. Filter dan pencarian bersifat langsung, sedangkan form bertahap menjaga data pengguna saat berpindah tahap.

### Animation

Gunakan animasi singkat 140–220ms hanya untuk drawer, modal, toast, hover, dan perubahan bar chart. Tidak ada looping dekoratif. Hormati `prefers-reduced-motion` dengan mematikan transisi.

### Typography System

Gunakan `Inter` sebagai font utama melalui system fallback (`Inter, ui-sans-serif, system-ui`) agar stabil tanpa dependensi jaringan. Judul memakai bobot 700–800, body 14–15px dengan line-height longgar, label 11–12px uppercase ber-letter-spacing untuk konteks sekunder.

### Brand Essence

**SekolahMu membantu tim sekolah bergerak dari data yang tersebar ke keputusan harian yang tertata.** Kepribadian: terarah, ramah, dapat dipercaya.

### Brand Voice

Judul dan CTA terdengar ringkas, suportif, dan operasional.

- "Pantau sekolah tanpa kehilangan konteks."
- "Simpan perubahan demo dan lanjutkan pekerjaan Anda."

### Wordmark & Logo

Mark berupa dua panel buku yang membentuk huruf S abstrak, ditempatkan dalam kotak sudut membulat. Wordmark `SekolahMu` memakai lowercase `olah` untuk kesan dekat namun tetap profesional.

### Signature Brand Color

**SekolahMu Azure `#2F6BFF`** — biru elektrik yang dipakai sebagai penanda tindakan, fokus, dan kemajuan.

## Alur build dan delivery

1. Tulis shell SPA, data demo, store, router, dan sistem UI tanpa dependensi eksternal.
2. Implementasikan dashboard, SPMB, modul akademik, absensi, tugas, administrasi, dan pendaftaran publik.
3. Daftarkan diagnosik JavaScript serta route manifest sebelum dev server.
4. Jalankan server port 3000, cek HTTP preview, route manifest, dan pemeriksaan sintaks.
5. Lakukan inspeksi read-only terhadap implementasi dan perbaiki isu nyata yang ditemukan.
6. Commit ke branch utama/canonical remote sehingga WebDev dapat merekam checkpoint.

Prototype akan transparan bahwa data, autentikasi, upload, email, dan otorisasi backend belum aktif; kontrak endpoint Laravel disiapkan di `src/api.js` untuk tahap berikutnya.
