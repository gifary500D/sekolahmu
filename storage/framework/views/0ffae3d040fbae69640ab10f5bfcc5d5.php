<?php $__env->startSection('title', 'Jadwal Pelajaran Kelas'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-purple-50 dark:bg-purple-950/60 text-purple-800 dark:text-purple-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Akademik Siswa
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Jadwal Pelajaran (Roster)</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Jadwal kegiatan belajar mengajar harian untuk kelas <?php echo e($user->kelas->nama ?? 'Siswa'); ?>.</p>
            </div>
            <div>
                <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Roster Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Rombongan Belajar: <?php echo e($user->kelas->nama ?? '-'); ?></h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tahun Ajaran 2026/2027</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Hari</th>
                            <th class="py-3 px-6">Jam Pelajaran</th>
                            <th class="py-3 px-6">Mata Pelajaran</th>
                            <th class="py-3 px-6">Guru Pengampu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        <?php $__empty_1 = true; $__currentLoopData = $rosters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white"><?php echo e($roster->hari); ?></td>
                                <td class="py-4 px-6 font-mono text-xs text-slate-600 dark:text-slate-400"><?php echo e($roster->jam_mulai); ?> - <?php echo e($roster->jam_selesai); ?></td>
                                <td class="py-4 px-6 font-semibold text-blue-700 dark:text-blue-400"><?php echo e($roster->mata_pelajaran); ?></td>
                                <td class="py-4 px-6 text-slate-700 dark:text-slate-300"><?php echo e($roster->guru->name ?? 'Guru Pengampu'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500 dark:text-slate-400 text-xs">
                                    Belum ada jadwal pelajaran (roster) yang diatur untuk kelas Anda.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/siswa/roster.blade.php ENDPATH**/ ?>