<?php $__env->startSection('title', 'Transkrip Nilai Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Transkrip &amp; Rekapitulasi Nilai Tugas</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Daftar nilai dan catatan evaluasi dari guru pengampu atas tugas yang telah dikumpulkan.</p>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm inline-flex items-center gap-2 self-start">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-base font-bold text-slate-900 dark:text-white">Riwayat Penilaian Tugas</h2>
                <span class="px-3 py-1 bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 rounded-full text-xs font-semibold">Total Dikumpulkan: <?php echo e($submissions->count()); ?> Tugas</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-200 dark:border-slate-800">
                            <th class="py-3 px-6">Mata Pelajaran / Tugas</th>
                            <th class="py-3 px-6">Tanggal Pengumpulan</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Nilai Angka</th>
                            <th class="py-3 px-6">Catatan / Feedback Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-xs text-slate-700 dark:text-slate-300">
                        <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 dark:text-white block mb-0.5"><?php echo e($sub->tugas->judul ?? '-'); ?></span>
                                    <span class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold"><?php echo e($sub->tugas->mata_pelajaran ?? '-'); ?></span>
                                </td>
                                <td class="py-4 px-6 text-slate-500 dark:text-slate-400">
                                    <?php echo e($sub->diselesaikan_pada ? $sub->diselesaikan_pada->format('d M Y, H:i') : $sub->updated_at->format('d M Y, H:i')); ?>

                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase <?php echo e($sub->nilai !== null ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300'); ?>">
                                        <?php echo e($sub->nilai !== null ? 'Sudah Dinilai' : 'Menunggu Penilaian'); ?>

                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <?php if($sub->nilai !== null): ?>
                                        <span class="text-base font-black text-blue-700 dark:text-blue-400"><?php echo e($sub->nilai); ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-400 dark:text-slate-500 font-medium">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-slate-600 dark:text-slate-300 italic">
                                    <?php echo e($sub->catatan ?? 'Belum ada catatan dari guru.'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 dark:text-slate-500 text-xs">Belum ada tugas yang dikumpulkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/siswa/nilai.blade.php ENDPATH**/ ?>