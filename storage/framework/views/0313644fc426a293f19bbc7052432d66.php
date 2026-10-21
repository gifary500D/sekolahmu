<?php $__env->startSection('title', 'CMS Portal & Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">CMS Portal &amp; Publikasi Berita</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Kelola pengumuman, berita sekolah, dan artikel yang tampil di halaman utama.</p>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors shadow-sm inline-flex items-center gap-2 self-start">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-xl shadow-sm text-xs font-medium">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Publikasi Berita -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 h-fit">
                <h2 class="text-base font-bold text-slate-900 dark:text-white mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">Buat Berita / Pengumuman</h2>
                <form action="<?php echo e(route('admin.cms.berita.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Judul Berita <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Judul pengumuman..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                            <option value="terbit">Terbit (Publik)</option>
                            <option value="arsip">Arsip (Draft)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Gambar Utama</label>
                        <input type="file" name="gambar" accept="image/*" class="text-xs text-slate-500 dark:text-slate-400 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-950/60 file:text-blue-700 dark:file:text-blue-300 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Isi Berita / Konten <span class="text-rose-500">*</span></label>
                        <textarea name="konten" rows="5" required placeholder="Tulis isi berita di sini..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-blue-600"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold transition-colors shadow-sm">
                        Publikasikan Berita
                    </button>
                </form>
            </div>

            <!-- Daftar Berita Terbit -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <h2 class="text-base font-bold text-slate-900 dark:text-white">Arsip Publikasi Berita</h2>
                    <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 rounded-full text-xs font-semibold">Total: <?php echo e($beritaList->count()); ?> Berita</span>
                </div>
                <div class="p-6 space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $beritaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $pubTime = ($berita->diterbitkan_pada ?? $berita->created_at)?->format('d M Y, H:i') ?? '-';
                            $imgSrc = $berita->gambar_path ? asset('storage/' . $berita->gambar_path) : '';
                        ?>
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-slate-300 dark:hover:border-slate-700 transition-colors">
                            <div class="flex items-start gap-3 flex-1">
                                <?php if($berita->gambar_path): ?>
                                    <img src="<?php echo e($imgSrc); ?>" alt="<?php echo e($berita->judul); ?>" class="w-16 h-16 rounded-lg object-cover flex-shrink-0 border border-slate-200 dark:border-slate-700">
                                <?php endif; ?>
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase <?php echo e($berita->status === 'terbit' ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300'); ?>">
                                            <?php echo e($berita->status); ?>

                                        </span>
                                        <span class="text-xs text-slate-400 dark:text-slate-500"><?php echo e($pubTime); ?></span>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e($berita->judul); ?></h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2"><?php echo e($berita->konten); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-center">
                                <button 
                                    type="button" 
                                    onclick="openCmsNewsModal('<?php echo e(addslashes($berita->judul)); ?>', '<?php echo e($pubTime); ?>', '<?php echo e($imgSrc); ?>', '<?php echo e(addslashes(str_replace(["\r\n", "\r", "\n"], '\n', $berita->konten))); ?>', '<?php echo e(ucfirst($berita->status)); ?>')"
                                    class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap"
                                >
                                    Pratinjau
                                </button>
                                <form action="<?php echo e(route('admin.cms.berita.delete', $berita->id)); ?>" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/50 hover:bg-rose-100 dark:hover:bg-rose-900/50 text-rose-700 dark:text-rose-300 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="py-12 text-center text-slate-400 dark:text-slate-500 text-xs">Belum ada berita atau pengumuman yang dipublikasikan.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Pratinjau CMS Berita -->
<div id="cmsNewsModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="p-4 sm:p-6 bg-slate-900 dark:bg-slate-950 text-white flex justify-between items-center">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-400 block mb-0.5">Pratinjau Konten Berita</span>
                <h3 id="cmsModalTitle" class="font-bold text-lg text-white">Judul Berita</h3>
            </div>
            <button type="button" onclick="closeCmsNewsModal()" class="w-9 h-9 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-4">
            <div class="flex items-center gap-3">
                <span id="cmsModalStatus" class="px-2.5 py-1 rounded text-xs font-bold uppercase bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300"></span>
                <span id="cmsModalTime" class="text-xs text-slate-500 dark:text-slate-400 font-mono"></span>
            </div>
            <div id="cmsModalImgWrapper" class="relative h-48 sm:h-56 bg-slate-100 dark:bg-slate-800 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 hidden">
                <img id="cmsModalImg" src="" alt="Gambar Berita" class="w-full h-full object-cover">
            </div>
            <div class="p-4 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                <p id="cmsModalContent" class="text-sm text-slate-800 dark:text-slate-200 leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-200 dark:border-slate-800 flex justify-end">
            <button type="button" onclick="closeCmsNewsModal()" class="px-5 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-xs font-semibold transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
function openCmsNewsModal(title, time, imgUrl, content, status) {
    document.getElementById('cmsModalTitle').textContent = title;
    document.getElementById('cmsModalTime').textContent = time;
    document.getElementById('cmsModalStatus').textContent = status;
    const imgWrapper = document.getElementById('cmsModalImgWrapper');
    const imgEl = document.getElementById('cmsModalImg');
    if (imgUrl) {
        imgEl.src = imgUrl;
        imgWrapper.classList.remove('hidden');
    } else {
        imgWrapper.classList.add('hidden');
    }
    document.getElementById('cmsModalContent').textContent = content;
    document.getElementById('cmsNewsModal').classList.remove('hidden');
}

function closeCmsNewsModal() {
    document.getElementById('cmsNewsModal').classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /data/data/com.termux/files/home/sekolahmu/resources/views/admin/cms/index.blade.php ENDPATH**/ ?>