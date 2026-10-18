export const school = { name: 'SMA/SMK Pemda Bahorok', shortName: 'SMA/SMK Pemda Bahorok', location: 'Bahorok, Kab. Langkat, Sumatera Utara', period: 'Tahun Ajaran 2026/2027', spmbPeriod: '1 Juni — 31 Juli 2026', principal: 'Drs. H. Bahagia Sitepu, M.Pd.' };

export const students = [
  { id: 'M-26001', name: 'Aditya Pratama', gender: 'Laki-laki', className: 'X IPA 1', phone: '08xx-xxx-0101', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26002', name: 'Alya Putri Ramadhani', gender: 'Perempuan', className: 'X IPA 1', phone: '08xx-xxx-0102', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26003', name: 'Bima Saputra', gender: 'Laki-laki', className: 'X IPA 1', phone: '08xx-xxx-0103', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26004', name: 'Citra Maharani', gender: 'Perempuan', className: 'X IPA 2', phone: '08xx-xxx-0104', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26005', name: 'Daffa Rizky', gender: 'Laki-laki', className: 'X IPA 2', phone: '08xx-xxx-0105', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26006', name: 'Eka Wulandari', gender: 'Perempuan', className: 'X IPA 2', phone: '08xx-xxx-0106', status: 'Aktif', joined: '2024-07-15' },
  { id: 'M-26007', name: 'Farhan Maulana', gender: 'Laki-laki', className: 'XI IPS 1', phone: '08xx-xxx-0107', status: 'Aktif', joined: '2023-07-17' },
  { id: 'M-26008', name: 'Gita Anindya', gender: 'Perempuan', className: 'XI IPS 1', phone: '08xx-xxx-0108', status: 'Aktif', joined: '2023-07-17' },
  { id: 'M-26009', name: 'Hafiz Ramadhan', gender: 'Laki-laki', className: 'XI IPS 1', phone: '08xx-xxx-0109', status: 'Aktif', joined: '2023-07-17' },
  { id: 'M-26010', name: 'Intan Permata', gender: 'Perempuan', className: 'XI IPS 2', phone: '08xx-xxx-0110', status: 'Aktif', joined: '2023-07-17' },
  { id: 'M-26011', name: 'Jauhar Fikri', gender: 'Laki-laki', className: 'XI IPS 2', phone: '08xx-xxx-0111', status: 'Aktif', joined: '2023-07-17' },
  { id: 'M-26012', name: 'Kirana Salsabila', gender: 'Perempuan', className: 'XI IPS 2', phone: '08xx-xxx-0112', status: 'Aktif', joined: '2023-07-17' }
];

export const teachers = [
  { id: 'G-0812', name: 'Rina Kartika, S.Pd.', subject: 'Matematika', classes: 'X IPA 1, X IPA 2', status: 'Aktif', email: 'rina.kartika@demo.sch.id' },
  { id: 'G-0813', name: 'Yusuf Haryanto, M.Pd.', subject: 'Bahasa Indonesia', classes: 'XI IPS 1', status: 'Aktif', email: 'yusuf.haryanto@demo.sch.id' },
  { id: 'G-0814', name: 'Maya Sari, S.Pd.', subject: 'Biologi', classes: 'X IPA 1, X IPA 2', status: 'Aktif', email: 'maya.sari@demo.sch.id' },
  { id: 'G-0815', name: 'Dedi Kurniawan, S.Pd.', subject: 'Sejarah', classes: 'XI IPS 1, XI IPS 2', status: 'Aktif', email: 'dedi.kurniawan@demo.sch.id' },
  { id: 'G-0816', name: 'Novi Lestari, S.Pd.', subject: 'Bahasa Inggris', classes: 'XI IPS 2', status: 'Cuti', email: 'novi.lestari@demo.sch.id' },
  { id: 'G-0817', name: 'Arif Nugroho, S.Pd.', subject: 'PJOK', classes: 'Semua tingkat', status: 'Aktif', email: 'arif.nugroho@demo.sch.id' }
];

export const classes = [
  { id: 'K-101', name: 'X IPA 1', level: 'Kelas X', homeroom: 'Rina Kartika, S.Pd.', capacity: 32 },
  { id: 'K-102', name: 'X IPA 2', level: 'Kelas X', homeroom: 'Maya Sari, S.Pd.', capacity: 32 },
  { id: 'K-201', name: 'XI IPS 1', level: 'Kelas XI', homeroom: 'Yusuf Haryanto, M.Pd.', capacity: 30 },
  { id: 'K-202', name: 'XI IPS 2', level: 'Kelas XI', homeroom: 'Dedi Kurniawan, S.Pd.', capacity: 30 }
];

export const applicants = [
  { id: 'SPMB-26041', name: 'Nadia Cahyani', school: 'SMPN 1 Bahorok', path: 'Zonasi', date: '2026-06-18', status: 'Menunggu Verifikasi', phone: '08xx-xxx-2011', gender: 'Perempuan', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Perlu diperiksa' }, note: '', history: [{ status: 'Menunggu Verifikasi', date: '18 Jun 2026, 09:14', by: 'Sistem demo' }] },
  { id: 'SPMB-26040', name: 'Raka Adinata', school: 'SMPN 2 Bahorok', path: 'Prestasi', date: '2026-06-17', status: 'Sedang Diverifikasi', phone: '08xx-xxx-2012', gender: 'Laki-laki', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: 'Menunggu konfirmasi sertifikat lomba.', history: [{ status: 'Menunggu Verifikasi', date: '17 Jun 2026, 10:21', by: 'Sistem demo' }, { status: 'Sedang Diverifikasi', date: '18 Jun 2026, 08:45', by: 'Siti Rahma' }] },
  { id: 'SPMB-26039', name: 'Salsabila Nirmala', school: 'MTs Al-Hidayah Bahorok', path: 'Afirmasi', date: '2026-06-16', status: 'Terverifikasi', phone: '08xx-xxx-2013', gender: 'Perempuan', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: 'Dokumen telah sesuai persyaratan demo.', history: [{ status: 'Menunggu Verifikasi', date: '16 Jun 2026, 14:12', by: 'Sistem demo' }, { status: 'Terverifikasi', date: '17 Jun 2026, 11:20', by: 'Siti Rahma' }] },
  { id: 'SPMB-26038', name: 'Fauzan Akbar', school: 'SMPN 1 Bahorok', path: 'Zonasi', date: '2026-06-15', status: 'Diterima', phone: '08xx-xxx-2014', gender: 'Laki-laki', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: 'Diterima pada simulasi seleksi tahap 1.', history: [{ status: 'Terverifikasi', date: '16 Jun 2026, 09:12', by: 'Siti Rahma' }, { status: 'Diterima', date: '20 Jun 2026, 13:02', by: 'Admin demo' }] },
  { id: 'SPMB-26037', name: 'Nabila Zahra', school: 'SMPN 3 Bahorok', path: 'Prestasi', date: '2026-06-14', status: 'Ditolak', phone: '08xx-xxx-2015', gender: 'Perempuan', documents: { kartuKeluarga: 'Lengkap', rapor: 'Tidak sesuai', akta: 'Lengkap' }, note: 'Nilai rapor belum memenuhi kriteria jalur prestasi demo.', history: [{ status: 'Terverifikasi', date: '15 Jun 2026, 10:02', by: 'Siti Rahma' }, { status: 'Ditolak', date: '19 Jun 2026, 15:42', by: 'Admin demo' }] },
  { id: 'SPMB-26036', name: 'Gilang Ramadhan', school: 'SMPN 2 Bahorok', path: 'Zonasi', date: '2026-06-13', status: 'Terverifikasi', phone: '08xx-xxx-2016', gender: 'Laki-laki', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: '', history: [{ status: 'Terverifikasi', date: '14 Jun 2026, 09:42', by: 'Siti Rahma' }] },
  { id: 'SPMB-26035', name: 'Putri Ayu Lestari', school: 'MTs Al-Hidayah Bahorok', path: 'Afirmasi', date: '2026-06-12', status: 'Menunggu Verifikasi', phone: '08xx-xxx-2017', gender: 'Perempuan', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Belum diunggah' }, note: '', history: [{ status: 'Menunggu Verifikasi', date: '12 Jun 2026, 16:10', by: 'Sistem demo' }] },
  { id: 'SPMB-26034', name: 'Yoga Prasetyo', school: 'SMPN 1 Bahorok', path: 'Zonasi', date: '2026-06-11', status: 'Diterima', phone: '08xx-xxx-2018', gender: 'Laki-laki', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: '', history: [{ status: 'Terverifikasi', date: '12 Jun 2026, 10:22', by: 'Siti Rahma' }, { status: 'Diterima', date: '20 Jun 2026, 13:05', by: 'Admin demo' }] },
  { id: 'SPMB-26033', name: 'Keisha Maharani', school: 'SMPN 3 Bahorok', path: 'Prestasi', date: '2026-06-10', status: 'Menunggu Verifikasi', phone: '08xx-xxx-2019', gender: 'Perempuan', documents: { kartuKeluarga: 'Lengkap', rapor: 'Lengkap', akta: 'Lengkap' }, note: '', history: [{ status: 'Menunggu Verifikasi', date: '10 Jun 2026, 12:31', by: 'Sistem demo' }] }
];

export const tasks = [
  { id: 'T-0048', title: 'Eksperimen Fotosintesis', description: 'Menyusun laporan hasil eksperimen dan kesimpulan.', className: 'X IPA 1', teacher: 'Maya Sari, S.Pd.', due: '2026-06-27', priority: 'Tinggi', status: 'Aktif' },
  { id: 'T-0047', title: 'Analisis Cerpen Nusantara', description: 'Analisis unsur intrinsik dari cerpen pilihan.', className: 'XI IPS 1', teacher: 'Yusuf Haryanto, M.Pd.', due: '2026-06-29', priority: 'Normal', status: 'Aktif' },
  { id: 'T-0046', title: 'Latihan Persamaan Kuadrat', description: 'Latihan mandiri 20 soal pada modul 4.', className: 'X IPA 2', teacher: 'Rina Kartika, S.Pd.', due: '2026-06-22', priority: 'Tinggi', status: 'Terlambat' },
  { id: 'T-0045', title: 'Peta Perubahan Sosial', description: 'Membuat peta konsep perubahan sosial di Indonesia.', className: 'XI IPS 2', teacher: 'Dedi Kurniawan, S.Pd.', due: '2026-07-02', priority: 'Rendah', status: 'Draft' },
  { id: 'T-0044', title: 'Vocabulary Journal #3', description: 'Mencatat 30 kosakata baru dan contoh kalimat.', className: 'XI IPS 2', teacher: 'Novi Lestari, S.Pd.', due: '2026-06-25', priority: 'Normal', status: 'Aktif' }
];

export const users = [
  { id: 'U-001', name: 'Andi Setiawan', email: 'andi.admin@demo.sch.id', role: 'Admin', status: 'Aktif', lastActive: 'Hari ini, 09:42' },
  { id: 'U-002', name: 'Rina Kartika', email: 'rina.kartika@demo.sch.id', role: 'Guru', status: 'Aktif', lastActive: 'Hari ini, 08:17' },
  { id: 'U-003', name: 'Siti Rahma', email: 'siti.spmb@demo.sch.id', role: 'Petugas SPMB', status: 'Aktif', lastActive: 'Kemarin, 16:08' },
  { id: 'U-004', name: 'Alya Putri Ramadhani', email: 'alya.murid@demo.sch.id', role: 'Murid', status: 'Aktif', lastActive: '20 Jun 2026, 14:31' },
  { id: 'U-005', name: 'Bagus Firmansyah', email: 'bagus.murid@demo.sch.id', role: 'Murid', status: 'Nonaktif', lastActive: '18 Jun 2026, 10:02' }
];

export const attendanceSeed = { '2026-06-24|X IPA 1': { 'M-26001': 'Hadir', 'M-26002': 'Hadir', 'M-26003': 'Izin' }, '2026-06-24|X IPA 2': { 'M-26004': 'Hadir', 'M-26005': 'Hadir', 'M-26006': 'Hadir' }, '2026-06-23|XI IPS 1': { 'M-26007': 'Hadir', 'M-26008': 'Sakit', 'M-26009': 'Hadir' } };

export const activitySeed = [
  { icon: 'check', title: 'Status pendaftar diperbarui', copy: 'Fauzan Akbar ditandai Diterima oleh Admin demo.', time: '20 Jun 2026, 13:02' },
  { icon: 'user', title: 'Data murid ditambahkan', copy: 'Profil demo M-26012 berhasil dibuat.', time: '20 Jun 2026, 11:44' },
  { icon: 'file', title: 'Tugas baru dibuat', copy: 'Eksperimen Fotosintesis untuk X IPA 1.', time: '20 Jun 2026, 09:10' },
  { icon: 'calendar', title: 'Absensi disimpan', copy: 'Absensi X IPA 2 pada 24 Jun 2026.', time: '20 Jun 2026, 08:16' }
];

export const menu = [
  { section: 'Dashboard', items: [{ key: 'dashboard', label: 'Ringkasan', icon: 'grid' }, { key: 'activities', label: 'Aktivitas terbaru', icon: 'pulse' }] },
  { section: 'Akademik', items: [{ key: 'students', label: 'Data murid', icon: 'users' }, { key: 'teachers', label: 'Data guru', icon: 'teacher' }, { key: 'classes', label: 'Kelas', icon: 'book' }, { key: 'attendance', label: 'Absensi', icon: 'calendar' }, { key: 'tasks', label: 'Tugas', icon: 'file' }] },
  { section: 'Penerimaan Murid Baru', items: [{ key: 'spmb', label: 'Dashboard SPMB', icon: 'spark' }, { key: 'applicants', label: 'Data pendaftar', icon: 'clipboard' }, { key: 'verification', label: 'Verifikasi berkas', icon: 'shield' }, { key: 'status', label: 'Status pendaftaran', icon: 'search' }] },
  { section: 'Administrasi', items: [{ key: 'users', label: 'Manajemen pengguna', icon: 'user' }, { key: 'roles', label: 'Hak akses', icon: 'lock' }, { key: 'reports', label: 'Laporan', icon: 'chart' }, { key: 'school-settings', label: 'Pengaturan sekolah', icon: 'settings' }] }
];

export const rolePermissions = [
  { module: 'Ringkasan dashboard', Admin: true, Guru: true, Murid: true, 'Petugas SPMB': true },
  { module: 'Data murid', Admin: true, Guru: 'Terbatas', Murid: 'Profil sendiri', 'Petugas SPMB': false },
  { module: 'Absensi', Admin: true, Guru: 'Kelas diampu', Murid: 'Lihat sendiri', 'Petugas SPMB': false },
  { module: 'Tugas', Admin: true, Guru: 'Buat & kelola', Murid: 'Lihat', 'Petugas SPMB': false },
  { module: 'SPMB & verifikasi', Admin: true, Guru: false, Murid: false, 'Petugas SPMB': 'Kelola' },
  { module: 'Manajemen pengguna', Admin: true, Guru: false, Murid: false, 'Petugas SPMB': false },
  { module: 'Laporan', Admin: true, Guru: 'Akademik', Murid: false, 'Petugas SPMB': 'SPMB' }
];
