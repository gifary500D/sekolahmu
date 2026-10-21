<?php $__env->startSection('title', 'Dashboard Administrator'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
<?php
    $hour = (int) now()->timezone('Asia/Jakarta')->format('G');
    if ($hour >= 4 && $hour <= 10) {
        $greetings = 'Selamat Pagi';
    } elseif ($hour >= 11 && $hour <= 14) {
        $greetings = 'Selamat Siang';
    } elseif ($hour >= 15 && $hour <= 17) {
        $greetings = 'Selamat Sore';
    } else {
        $greetings = 'Selamat Malam';
    }
?>
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 dark:from-slate-900 dark:via-blue-950 dark:to-slate-900 rounded-2xl shadow-md p-6 sm:p-8 mb-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border border-transparent dark:border-slate-800">
            <div>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight"><span class="dynamic-greeting" data-greeting><?php echo e($greetings); ?></span>, <?php echo e(auth()->user()->name ?? 'Administrator'); ?></h1>
                <p class="text-blue-200 text-sm mt-2 max-w-2xl leading-relaxed">Kelola sistem akademik terpadu, verifikasi pendaftaran peserta didik baru (SPMB), dan pengaturan pengguna secara real-time.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                <a href="<?php echo e(route('admin.spmb.index')); ?>" class="px-5 py-2.5 bg-amber-400 hover:bg-amber-350 text-blue-950 font-bold rounded-xl text-sm shadow-md transition-all text-center">
                    Verifikasi SPMB (<?php echo e($pendingSpmb); ?>)
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl text-sm border border-white/20 transition-all text-center">
                    Manajemen Pengguna
                </a>
                <button type="button" onclick="toggleDarkMode()" aria-label="Toggle Tema Gelap/Terang" title="Ganti Mode Gelap / Terang" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl text-sm border border-white/20 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="w-4 h-4 block dark:hidden text-amber-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <span class="text-xs font-semibold dark:hidden">Mode Gelap</span>
                    <span class="text-xs font-semibold hidden dark:inline">Mode Terang</span>
                </button>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Siswa Aktif -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Siswa Aktif</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?php echo e(number_format($totalSiswa, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-blue-600 dark:text-blue-400 font-semibold">
                    <span>Terdaftar di rombongan belajar</span>
                </div>
            </div>

            <!-- Guru & Admin -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Guru &amp; Staf</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?php echo e(number_format($totalGuru + $totalAdmin, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                    <span><?php echo e($totalGuru); ?> Guru, <?php echo e($totalAdmin); ?> Admin</span>
                </div>
            </div>

            <!-- Kelas Rombel -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Rombongan Belajar</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?php echo e(number_format($totalKelas, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-amber-600 dark:text-amber-400 font-semibold">
                    <span>Tingkat X, XI, dan XII</span>
                </div>
            </div>

            <!-- Pendaftar SPMB -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pendaftar SPMB</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2"><?php echo e(number_format($totalSpmb, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-400 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-cyan-700 dark:text-cyan-400 font-semibold">
                    <span><?php echo e($acceptedSpmb); ?> Diterima, <?php echo e($pendingSpmb); ?> Pending</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Management Modules -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Main Menu Overview -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 sm:p-8">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center justify-between">
                        <span>Modul Administrasi Utama</span>
                        <span class="text-xs font-normal text-slate-500 dark:text-slate-400">Akses Cepat</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <a href="<?php echo e(route('admin.siswa.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-blue-600 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-slate-800/60 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 flex items-center justify-center group-hover:bg-blue-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Tabel Data Siswa</h3>
                                    <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Daftar Aktif &amp; Kelas</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Lihat tabel lengkap seluruh siswa aktif dan rombongan belajar.</p>
                        </a>

                        <a href="<?php echo e(route('admin.kelas.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-emerald-600 dark:hover:border-emerald-500 hover:bg-emerald-50/40 dark:hover:bg-slate-800/60 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Master Data Kelas</h3>
                                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Rombel &amp; Wali Kelas</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Tambah, ubah, atau hapus rombongan belajar dan tentukan wali kelas.</p>
                        </a>

                        <a href="<?php echo e(route('admin.cms.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-indigo-600 dark:hover:border-indigo-500 hover:bg-indigo-50/40 dark:hover:bg-slate-800/60 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 flex items-center justify-center group-hover:bg-indigo-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">CMS Portal &amp; Berita</h3>
                                    <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Publikasi Sekolah</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Buat dan publikasikan berita, pengumuman, atau artikel ke halaman depan.</p>
                        </a>

                        <a href="<?php echo e(route('admin.spmb.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-amber-600 dark:hover:border-amber-500 hover:bg-amber-50/40 dark:hover:bg-slate-800/60 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 flex items-center justify-center group-hover:bg-amber-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Verifikasi Berkas SPMB</h3>
                                    <span class="text-xs text-amber-600 dark:text-amber-400 font-medium"><?php echo e($pendingSpmb); ?> Menunggu Validasi</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Periksa dan validasi dokumen calon peserta didik baru.</p>
                        </a>

                        <a href="<?php echo e(route('admin.roster.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-purple-600 dark:hover:border-purple-500 hover:bg-purple-50/40 dark:hover:bg-slate-800/60 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-300 flex items-center justify-center group-hover:bg-purple-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Jadwal Pelajaran (Roster)</h3>
                                    <span class="text-xs text-purple-600 dark:text-purple-400 font-medium">Pengaturan Waktu</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Atur jadwal mata pelajaran per kelas, hari, dan guru pengampu.</p>
                        </a>

                        <a href="<?php echo e(route('admin.users.index')); ?>" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50/40 dark:hover:bg-slate-800/60 transition-all group sm:col-span-2">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/50 text-cyan-700 dark:text-cyan-300 flex items-center justify-center group-hover:bg-cyan-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756.24 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Manajemen Pengguna Sistem &amp; Penempatan Kelas</h3>
                                    <span class="text-xs text-cyan-600 dark:text-cyan-400 font-medium">Akun &amp; Kredensial</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Tambah pengguna baru, reset kata sandi, dan atur penempatan kelas siswa secara instan.</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Col: System Status & Recent Activity -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white mb-4 flex items-center justify-between">
                        <span>Pendaftar SPMB Terbaru</span>
                        <a href="<?php echo e(route('admin.spmb.index')); ?>" class="text-xs text-blue-700 dark:text-blue-400 hover:underline font-semibold">Semua</a>
                    </h2>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $recentSpmb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spmb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex items-start gap-3 pb-3 border-b border-slate-100 dark:border-slate-800 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 flex items-center justify-center flex-shrink-0 text-xs font-bold">SP</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($spmb->nama_lengkap); ?></p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400"><?php echo e($spmb->jalur_pendaftaran); ?> • <span class="font-medium text-slate-700 dark:text-slate-300"><?php echo e($spmb->status); ?></span></p>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5 block"><?php echo e($spmb->created_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Belum ada data pendaftar SPMB.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white mb-4 flex items-center justify-between">
                        <span>Pengguna Baru</span>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-xs text-blue-700 dark:text-blue-400 hover:underline font-semibold">Semua</a>
                    </h2>
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="flex items-start gap-3 pb-3 border-b border-slate-100 dark:border-slate-800 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 text-xs font-bold"><?php echo e(strtoupper(substr($usr->role, 0, 1))); ?></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate"><?php echo e($usr->name); ?></p>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Peran: <span class="uppercase font-medium text-slate-700 dark:text-slate-300"><?php echo e($usr->role); ?></span></p>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5 block"><?php echo e($usr->created_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Belum ada data pengguna baru.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- System Info Box -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-slate-200 rounded-2xl p-6 shadow-sm border border-slate-800">
                    <h3 class="font-bold text-white mb-2 text-sm">Informasi Server &amp; Sistem</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">Sistem operasional akademik berjalan normal pada Laravel 12.</p>
                    <div class="text-xs space-y-2 border-t border-slate-800 pt-3">
                        <div class="flex justify-between"><span>Lingkungan</span><span class="text-emerald-400 font-semibold">Production</span></div>
                        <div class="flex justify-between"><span>Database</span><span class="text-slate-300 font-semibold">MySQL / SQLite</span></div>
                        <div class="flex justify-between"><span>Keamanan</span><span class="text-blue-400 font-semibold">SSL &amp; CSRF Active</span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>