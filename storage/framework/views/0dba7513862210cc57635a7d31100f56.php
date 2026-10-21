<?php $__env->startSection('title', 'Daftar Tugas Siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Tugas Akademik
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Daftar Penugasan &amp; Nilai</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Unggah berkas tugas dan lihat nilai serta catatan evaluasi dari guru di SMA Pemda Bahorok.</p>
            </div>
            <div>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Mengumpulkan Tugas</p>
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Task List Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Semua Tugas &amp; Penilaian</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Total: <?php echo e(count($tugasList)); ?> Tugas</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Mata Pelajaran / Judul</th>
                            <th class="py-3 px-6">Sisa Waktu (Tenggat)</th>
                            <th class="py-3 px-6">Status &amp; Nilai</th>
                            <th class="py-3 px-6 text-right">Aksi &amp; Berkas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        <?php $__empty_1 = true; $__currentLoopData = $tugasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tugas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $sub = $submitted[$tugas->id] ?? null;
                                $status = $sub ? $sub->status : 'belum';
                                
                                $tenggat = \Carbon\Carbon::parse($tugas->tenggat);
                                $diffHours = now()->diffInHours($tenggat, false);
                                if ($diffHours < 0) {
                                    $timeLabel = 'Tenggat terlewat';
                                    $badgeColor = 'bg-red-100 dark:bg-red-950/60 text-red-800 dark:text-red-300';
                                } elseif ($diffHours < 24) {
                                    $timeLabel = $diffHours . ' jam lagi';
                                    $badgeColor = 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300';
                                } else {
                                    $days = ceil($diffHours / 24);
                                    $timeLabel = $days . ' hari lagi';
                                    $badgeColor = 'bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300';
                                }
                            ?>
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors align-top">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 dark:text-white block text-base mb-0.5"><?php echo e($tugas->judul); ?></strong>
                                    <span class="text-xs text-blue-700 dark:text-blue-400 font-medium block mb-1"><?php echo e($tugas->mata_pelajaran ?? 'Umum'); ?></span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e(Str::limit($tugas->deskripsi, 60)); ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-2.5 py-1 rounded <?php echo e($badgeColor); ?> text-xs font-semibold mb-1"><?php echo e($timeLabel); ?></span>
                                    <span class="font-mono text-[11px] text-slate-500 dark:text-slate-400 block"><?php echo e($tugas->tenggat); ?></span>
                                </td>
                                <td class="py-4 px-6">
                                    <?php if($status === 'selesai'): ?>
                                        <span class="px-2.5 py-1 rounded bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold inline-block mb-2">Selesai</span>
                                        <?php if($sub && $sub->nilai !== null): ?>
                                            <div class="text-xs space-y-1">
                                                <p class="font-bold text-slate-900 dark:text-white">Nilai: <span class="text-blue-700 dark:text-blue-400 text-sm font-mono"><?php echo e($sub->nilai); ?></span> / 100</p>
                                                <?php if($sub->catatan): ?>
                                                    <p class="text-slate-600 dark:text-slate-300 italic bg-slate-50 dark:bg-slate-800 p-2 rounded border border-slate-200 dark:border-slate-700">Catatan: "<?php echo e($sub->catatan); ?>"</p>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-amber-600 dark:text-amber-400 block italic">Menunggu penilaian guru</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold">Belum Dikerjakan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <?php if($status === 'belum'): ?>
                                        <?php if($diffHours < 0): ?>
                                            <span class="px-3 py-1.5 bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 rounded-lg text-xs font-semibold inline-block">Waktu Habis (Ditutup)</span>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('siswa.tugas.submit', $tugas->id)); ?>" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-end sm:items-center justify-end gap-2">
                                                <?php echo csrf_field(); ?>
                                                <input 
                                                    type="file" 
                                                    name="berkas" 
                                                    required 
                                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                                                    class="text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-950/60 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/60 cursor-pointer max-w-[200px]"
                                                >
                                                <button type="submit" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-semibold transition-colors shadow-sm whitespace-nowrap">
                                                    Kirim
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="flex flex-col items-end gap-1.5">
                                            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Tugas Dikirim</span>
                                            <div class="flex items-center gap-2">
                                                <?php if($sub && $sub->file_path): ?>
                                                    <a href="<?php echo e(route('siswa.tugas.download', $sub->id)); ?>" class="text-xs text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                                                        Lihat File
                                                    </a>
                                                <?php endif; ?>
                                                <form action="<?php echo e(route('siswa.tugas.cancel', $tugas->id)); ?>" method="POST" onsubmit="return confirm('Batalkan pengumpulan tugas ini?');" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-xs text-red-600 dark:text-red-400 hover:underline font-medium">Batalkan</button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada tugas yang tersedia saat ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/siswa/tugas.blade.php ENDPATH**/ ?>