<?php $__env->startSection('title', 'Verifikasi Pendaftar SPMB'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Verifikasi Pendaftar SPMB</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Kelola dan perbarui status seleksi pendaftaran siswa baru SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.spmb.export')); ?>" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel (.xls)
                </a>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Dashboard
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-emerald-50 dark:bg-emerald-950/60 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-50 dark:bg-red-950/60 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Memperbarui Status</p>
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Banner Informasi Alur Status SPMB & Dashboard -->
        <div class="bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 p-4 mb-6 rounded-xl text-blue-900 dark:text-blue-200 text-xs sm:text-sm flex items-start gap-3 shadow-sm">
            <span class="text-lg">ℹ️</span>
            <div>
                <p class="font-bold">Ketentuan Alur Verifikasi &amp; Akses Dashboard:</p>
                <p class="mt-0.5 text-blue-800 dark:text-blue-300 leading-relaxed">
                    Siswa baru hanya dapat mengakses dashboard portal siswa setelah status dinyatakan <strong class="underline">"Diterima"</strong>. Status <em>"Terverifikasi"</em> adalah verifikasi berkas awal. Saat status diubah menjadi <strong>"Diterima"</strong>, sistem otomatis mensinkronisasi akun User siswa dan Anda dapat langsung menetapkan kelas (rombel).
                </p>
            </div>
        </div>

        <!-- Applicants Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Pendaftar SPMB</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Total: <?php echo e(count($applicants)); ?> Pendaftar</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">No. Pendaftaran &amp; Nama</th>
                            <th class="py-3 px-6">NISN / Asal Sekolah</th>
                            <th class="py-3 px-6">Jalur / Program</th>
                            <th class="py-3 px-6">Status Saat Ini</th>
                            <th class="py-3 px-6 text-right">Ubah Status / Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        <?php $__empty_1 = true; $__currentLoopData = $applicants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $applicant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors align-top">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 dark:text-white block text-base mb-0.5"><?php echo e($applicant->nama_lengkap); ?></strong>
                                    <span class="text-xs text-blue-700 dark:text-blue-400 font-mono font-semibold"><?php echo e($applicant->nomor_pendaftaran); ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-mono text-xs block mb-0.5">NISN: <?php echo e($applicant->nisn); ?></span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($applicant->asal_sekolah); ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-semibold block text-slate-900 dark:text-white"><?php echo e($applicant->jalur_pendaftaran); ?></span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 uppercase">Program <?php echo e($applicant->program); ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <?php
                                        $badgeColor = match($applicant->status) {
                                            'Diterima' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300',
                                            'Terverifikasi' => 'bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300',
                                            'Sedang Diverifikasi' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300',
                                            'Ditolak' => 'bg-red-50 dark:bg-red-950/60 text-red-800 dark:text-red-300',
                                            default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300'
                                        };
                                        $linkedUser = $applicant->user_record;
                                    ?>
                                    <span class="px-2.5 py-1 rounded <?php echo e($badgeColor); ?> text-xs font-semibold inline-block mb-1">
                                        <?php echo e($applicant->status); ?>

                                    </span>
                                    <?php if($applicant->note): ?>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">Catatan: <?php echo e($applicant->note); ?></p>
                                    <?php endif; ?>
                                    <div class="mt-1 pt-1 border-t border-slate-100 dark:border-slate-800 text-[11px]">
                                        <?php if($linkedUser): ?>
                                            <span class="text-emerald-600 dark:text-emerald-400 font-medium block">
                                                Akun: <?php echo e($linkedUser->email); ?>

                                            </span>
                                            <span class="text-slate-500 dark:text-slate-400 block">
                                                Kelas: <?php echo e($linkedUser->kelas->nama ?? 'Belum Ditentukan'); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-400 dark:text-slate-500 block italic">Akun: Belum Dibuat</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="<?php echo e(route('admin.spmb.status', $applicant->id)); ?>" method="POST" class="space-y-2 inline-block text-left">
                                        <?php echo csrf_field(); ?>
                                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 justify-end">
                                            <select name="status" required class="px-3 py-1.5 border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-blue-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
                                                <option value="Menunggu Verifikasi" <?php echo e($applicant->status == 'Menunggu Verifikasi' ? 'selected' : ''); ?>>Menunggu Verifikasi</option>
                                                <option value="Sedang Diverifikasi" <?php echo e($applicant->status == 'Sedang Diverifikasi' ? 'selected' : ''); ?>>Sedang Diverifikasi</option>
                                                <option value="Terverifikasi" <?php echo e($applicant->status == 'Terverifikasi' ? 'selected' : ''); ?>>Terverifikasi</option>
                                                <option value="Diterima" <?php echo e($applicant->status == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                                                <option value="Ditolak" <?php echo e($applicant->status == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                                            </select>
                                            <select name="kelas_id" class="px-2.5 py-1.5 border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-medium focus:ring-2 focus:ring-blue-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
                                                <option value="">-- Tetapkan Kelas --</option>
                                                <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($kelas->id); ?>" <?php echo e(($linkedUser && $linkedUser->kelas_id == $kelas->id) ? 'selected' : ''); ?>><?php echo e($kelas->nama); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-semibold transition-colors">
                                                Simpan
                                            </button>
                                        </div>
                                        <input type="text" name="note" value="<?php echo e(old('note', $applicant->note)); ?>" placeholder="Catatan verifikasi..." class="w-full px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 rounded-lg text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none">
                                    </form>
                                    <?php if($linkedUser): ?>
                                        <div class="mt-2 text-right">
                                            <form action="<?php echo e(route('admin.siswa.reset-password', $linkedUser->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Reset kata sandi sementara untuk siswa <?php echo e($linkedUser->name); ?>?');">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-[11px] text-amber-700 dark:text-amber-400 hover:underline">
                                                    Reset Sandi Sementara
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada pendaftar SPMB.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/admin/spmb/index.blade.php ENDPATH**/ ?>