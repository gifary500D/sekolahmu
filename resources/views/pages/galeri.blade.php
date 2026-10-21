@extends('layouts.app')

@section('title', 'Galeri Sekolah')

@section('content')

{{-- =============================================
     HERO
     ============================================= --}}
<section class="py-12 sm:py-16 bg-[#0F2F6B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Galeri Sekolah</h1>
        <p class="text-base sm:text-lg text-blue-100 max-w-2xl mx-auto">
            Momen dan dokumentasi kegiatan berharga SMA Pemda Bahorok
        </p>
    </div>
</section>


{{-- =============================================
     FILTER & SEARCH
     ============================================= --}}
<section class="py-5 sm:py-6 bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 sticky top-16 z-30 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="relative">
                <label for="searchGaleri" class="sr-only">Cari galeri</label>
                <input
                    type="text"
                    id="searchGaleri"
                    placeholder="Cari foto atau album..."
                    class="w-full px-5 py-3 pl-11 border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500 rounded-lg focus:ring-2 focus:ring-[#1E63D6] focus:border-transparent outline-none transition-all text-sm"
                >
                <svg class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="flex gap-2 overflow-x-auto pb-1">
                <button data-filter="semua"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 bg-[#1E63D6] text-white rounded-full font-semibold text-sm whitespace-nowrap transition-colors">
                    Semua
                </button>
                <button data-filter="akademik"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] dark:hover:border-blue-400 dark:hover:text-blue-400 transition-colors">
                    Akademik
                </button>
                <button data-filter="olahraga"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] dark:hover:border-blue-400 dark:hover:text-blue-400 transition-colors">
                    Olahraga
                </button>
                <button data-filter="kegiatan"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] dark:hover:border-blue-400 dark:hover:text-blue-400 transition-colors">
                    Kegiatan
                </button>
                <button data-filter="fasilitas"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] dark:hover:border-blue-400 dark:hover:text-blue-400 transition-colors">
                    Fasilitas
                </button>
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     GALERI GRID
     ============================================= --}}
<section class="py-12 sm:py-16 bg-gray-50 dark:bg-slate-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
        {{-- Kosongkan: ganti dengan $photos dari controller --}}
        $photos = [
            ['id'=>1,  'cat'=>'akademik',  'title'=>'Upacara Bendera',             'desc'=>'Pelaksanaan upacara bendera hari Senin bersama seluruh warga sekolah.',          'date'=>'Oktober 2026', 'ratio'=>'portrait'],
            ['id'=>2,  'cat'=>'kegiatan',  'title'=>'Festival Seni Budaya',        'desc'=>'Penampilan tari tradisional pada festival budaya tahunan sekolah.',              'date'=>'September 2026','ratio'=>'landscape'],
            ['id'=>3,  'cat'=>'olahraga',  'title'=>'Pertandingan Futsal',         'desc'=>'Tim futsal SMA Pemda Bahorok dalam pertandingan antar sekolah.',                'date'=>'September 2026','ratio'=>'portrait'],
            ['id'=>4,  'cat'=>'fasilitas', 'title'=>'Laboratorium Komputer',       'desc'=>'Fasilitas laboratorium komputer berstandar modern untuk siswa.',                 'date'=>'Agustus 2026', 'ratio'=>'landscape'],
            ['id'=>5,  'cat'=>'akademik',  'title'=>'Pameran Karya Ilmiah',        'desc'=>'Siswa memamerkan hasil penelitian ilmiah pada ajang Science Fair sekolah.',      'date'=>'Agustus 2026', 'ratio'=>'portrait'],
            ['id'=>6,  'cat'=>'kegiatan',  'title'=>'Pentas Drama Teater',         'desc'=>'Penampilan drama kolosal dari ekstrakurikuler teater sekolah.',                  'date'=>'Juli 2026',    'ratio'=>'landscape'],
            ['id'=>7,  'cat'=>'olahraga',  'title'=>'Lomba Lari Tahunan',          'desc'=>'Kegiatan olahraga rutin dalam rangka memperingati Hari Olahraga Nasional.',     'date'=>'September 2026','ratio'=>'portrait'],
            ['id'=>8,  'cat'=>'fasilitas', 'title'=>'Perpustakaan Sekolah',        'desc'=>'Ruang perpustakaan yang nyaman dan koleksi buku yang lengkap.',                 'date'=>'Juli 2026',    'ratio'=>'landscape'],
            ['id'=>9,  'cat'=>'akademik',  'title'=>'Kunjungan Studi Universitas', 'desc'=>'Siswa kelas XII mengikuti kunjungan ke universitas negeri ternama.',             'date'=>'Juni 2026',    'ratio'=>'landscape'],
            ['id'=>10, 'cat'=>'kegiatan',  'title'=>'Penghijauan Lingkungan',      'desc'=>'Kegiatan penanaman pohon dan kebersihan lingkungan sekolah.',                   'date'=>'Juni 2026',    'ratio'=>'portrait'],
            ['id'=>11, 'cat'=>'olahraga',  'title'=>'Kejuaraan Basket',            'desc'=>'Tim basket putra dalam kejuaraan tingkat kota Medan.',                          'date'=>'Mei 2026',     'ratio'=>'landscape'],
            ['id'=>12, 'cat'=>'fasilitas', 'title'=>'Aula Serba Guna',             'desc'=>'Aula sekolah yang luas dan modern untuk berbagai keperluan kegiatan.',          'date'=>'Mei 2026',     'ratio'=>'portrait'],
        ];
        @endphp

        {{-- Grid masonry-like: 2 kolom mobile, 3 tablet, 4 desktop --}}
        <div id="galeriGrid" class="columns-2 sm:columns-3 lg:columns-4 gap-3 sm:gap-4 space-y-0">

            @foreach ($photos as $photo)
            <div class="galeri-item break-inside-avoid mb-3 sm:mb-4 group cursor-pointer"
                 data-category="{{ $photo['cat'] }}"
                 data-title="{{ strtolower($photo['title']) }}"
                 data-id="{{ $photo['id'] }}"
                 onclick="openLightbox({{ $photo['id'] }})">

                {{-- Rasio: portrait = 4:5, landscape = 16:9 --}}
                <div class="relative overflow-hidden rounded-xl bg-[#0F2F6B]/10 dark:bg-slate-900 border border-gray-200 dark:border-slate-800
                            group-hover:shadow-xl group-hover:border-[#1E63D6]/30 dark:group-hover:border-blue-500/30 transition-all duration-300
                            {{ $photo['ratio'] === 'portrait' ? 'aspect-[4/5]' : 'aspect-video' }}">

                    {{-- Kosongkan: ganti src dengan {{ asset($photo['image_path']) }} --}}
                    {{-- alt wajib diisi dengan deskripsi gambar sesuai BRD --}}
                    <img
                        src=""
                        alt="{{ $photo['title'] }} - SMA Pemda Bahorok"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 hidden"
                        onerror="this.classList.add('hidden')"
                    >

                    {{-- Placeholder saat gambar belum ada --}}
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 dark:text-slate-500 img-placeholder">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5"/>
                        </svg>
                        <span class="text-xs text-center px-2 leading-tight">{{ $photo['title'] }}</span>
                    </div>

                    {{-- Overlay hover --}}
                    <div class="absolute inset-0 bg-[#0F2F6B]/0 group-hover:bg-[#0F2F6B]/60 transition-colors duration-300 flex flex-col justify-end p-3 sm:p-4">
                        <div class="translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            <span class="inline-block text-[#FFC20E] text-xs font-bold uppercase tracking-wide mb-1">
                                {{ ucfirst($photo['cat']) }}
                            </span>
                            <p class="text-white text-xs sm:text-sm font-semibold leading-snug line-clamp-2">
                                {{ $photo['title'] }}
                            </p>
                            <div class="flex items-center gap-1 mt-2 text-blue-200 text-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v1.5M17.25 3v1.5M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/>
                                </svg>
                                {{ $photo['date'] }}
                            </div>
                        </div>
                        {{-- Ikon zoom --}}
                        <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/20 border border-white/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        {{-- State kosong --}}
        <div id="noResults" class="hidden text-center py-16">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/>
                </svg>
            </div>
            <p class="text-gray-600 dark:text-slate-300 font-semibold">Tidak ada foto yang ditemukan</p>
            <p class="text-gray-400 dark:text-slate-500 text-sm mt-1">Coba ubah filter atau kata kunci</p>
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center items-center gap-2 mt-12" role="navigation" aria-label="Halaman galeri">
            <button aria-label="Halaman sebelumnya"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button aria-current="page" class="w-9 h-9 rounded-lg bg-[#1E63D6] text-white font-semibold text-sm">1</button>
            <button class="w-9 h-9 rounded-lg border border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 font-semibold text-sm hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">2</button>
            <button class="w-9 h-9 rounded-lg border border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 font-semibold text-sm hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">3</button>
            <button aria-label="Halaman berikutnya"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-300 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

    </div>
</section>


{{-- =============================================
     CTA
     ============================================= --}}
<section class="py-14 sm:py-20 bg-[#0F2F6B] text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4">Ingin Bergabung Bersama Kami?</h2>
        <p class="text-base sm:text-lg text-blue-100 mb-8">
            Daftarkan diri dan jadilah bagian dari keluarga besar SMA Pemda Bahorok
        </p>
        <a href="{{ url('/daftar') }}"
           class="inline-block bg-[#FFC20E] text-[#0F2F6B] px-10 py-4 rounded-lg font-bold hover:bg-yellow-300 transition-all duration-300 hover:shadow-xl">
            Daftar Sekarang
        </a>
    </div>
</section>


{{-- =============================================
     LIGHTBOX MODAL
     ============================================= --}}
<div id="lightbox"
     class="fixed inset-0 z-50 hidden"
     role="dialog"
     aria-modal="true"
     aria-label="Detail foto">

    {{-- Backdrop --}}
    <div id="lightboxBackdrop"
         class="absolute inset-0 bg-black/90 backdrop-blur-sm"
         onclick="closeLightbox()">
    </div>

    {{-- Container --}}
    <div class="relative z-10 h-full flex flex-col">

        {{-- Topbar --}}
        <div class="flex items-center justify-between px-4 sm:px-6 py-4 flex-shrink-0">
            <div>
                <span id="lbCategory" class="text-[#FFC20E] text-xs font-bold uppercase tracking-wide"></span>
                <h2 id="lbTitle" class="text-white font-bold text-base sm:text-lg mt-0.5"></h2>
            </div>
            <div class="flex items-center gap-3">
                <span id="lbCounter" class="text-gray-400 text-sm"></span>
                <button onclick="closeLightbox()"
                        aria-label="Tutup"
                        class="w-9 h-9 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Main area: prev | image | next --}}
        <div class="flex-1 flex items-center justify-between px-2 sm:px-4 min-h-0 gap-2">

            {{-- Prev --}}
            <button id="lbPrev"
                    onclick="navigateLightbox(-1)"
                    aria-label="Foto sebelumnya"
                    class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/25 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Image frame --}}
            <div class="flex-1 h-full flex items-center justify-center min-w-0 py-2">
                <div id="lbImageWrap"
                     class="relative max-h-full flex items-center justify-center">

                    {{-- Foto portrait 4:5 --}}
                    <div id="lbPortrait"
                         class="hidden relative bg-[#0F2F6B]/40 rounded-2xl overflow-hidden border border-white/10"
                         style="height: min(75vh, 560px); aspect-ratio: 4/5;">
                        <img id="lbImgPortrait"
                             src="" alt=""
                             class="w-full h-full object-cover hidden">
                        <div id="lbPlaceholderPortrait"
                             class="absolute inset-0 flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5"/>
                            </svg>
                            <p class="text-sm">Foto belum tersedia</p>
                        </div>
                    </div>

                    {{-- Foto landscape 16:9 --}}
                    <div id="lbLandscape"
                         class="hidden relative bg-[#0F2F6B]/40 rounded-2xl overflow-hidden border border-white/10"
                         style="width: min(85vw, 960px); aspect-ratio: 16/9;">
                        <img id="lbImgLandscape"
                             src="" alt=""
                             class="w-full h-full object-cover hidden">
                        <div id="lbPlaceholderLandscape"
                             class="absolute inset-0 flex flex-col items-center justify-center text-gray-500">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5"/>
                            </svg>
                            <p class="text-sm">Foto belum tersedia</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Next --}}
            <button id="lbNext"
                    onclick="navigateLightbox(1)"
                    aria-label="Foto berikutnya"
                    class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/25 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

        </div>

        {{-- Bottom info --}}
        <div class="flex-shrink-0 px-4 sm:px-6 py-4">
            <p id="lbDesc" class="text-gray-300 text-sm text-center max-w-2xl mx-auto"></p>
            <p id="lbDate" class="text-gray-500 text-xs text-center mt-1"></p>

            {{-- Thumbnail strip --}}
            <div id="lbThumbs"
                 class="flex gap-2 justify-center mt-4 overflow-x-auto pb-1 max-w-3xl mx-auto">
            </div>
        </div>

    </div>
</div>


{{-- =============================================
     JAVASCRIPT
     ============================================= --}}
<script>
// ---- Data foto (PHP ke JS) ----
const photoData = @json($photos);

// ---- Filter ----
const searchInput   = document.getElementById('searchGaleri');
const filterButtons = document.querySelectorAll('.filter-btn');
const noResults     = document.getElementById('noResults');
let currentFilter   = 'semua';

filterButtons.forEach(btn => {
    btn.addEventListener('click', function () {
        currentFilter = this.dataset.filter;
        filterButtons.forEach(b => {
            b.classList.remove('bg-[#1E63D6]', 'text-white');
            b.classList.add('border-2', 'border-gray-300', 'dark:border-slate-700', 'text-gray-600', 'dark:text-slate-300');
        });
        this.classList.remove('border-2', 'border-gray-300', 'dark:border-slate-700', 'text-gray-600', 'dark:text-slate-300');
        this.classList.add('bg-[#1E63D6]', 'text-white');
        filterItems();
    });
});

searchInput.addEventListener('input', filterItems);

function filterItems() {
    const term  = searchInput.value.toLowerCase().trim();
    const items = document.querySelectorAll('.galeri-item');
    let visible = 0;

    items.forEach(item => {
        const catOk  = currentFilter === 'semua' || item.dataset.category === currentFilter;
        const termOk = !term || item.dataset.title.includes(term);
        item.style.display = catOk && termOk ? '' : 'none';
        if (catOk && termOk) visible++;
    });

    noResults.classList.toggle('hidden', visible > 0);
}


// ---- Lightbox ----
let lbIndex   = 0;
let lbVisible = [];

function getVisiblePhotos() {
    const items = document.querySelectorAll('.galeri-item');
    const ids   = [];
    items.forEach(item => {
        if (item.style.display !== 'none') ids.push(parseInt(item.dataset.id));
    });
    return photoData.filter(p => ids.includes(p.id));
}

function openLightbox(photoId) {
    lbVisible = getVisiblePhotos();
    lbIndex   = lbVisible.findIndex(p => p.id === photoId);
    if (lbIndex === -1) lbIndex = 0;

    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    renderLightbox();
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = '';
}

function navigateLightbox(dir) {
    lbIndex = (lbIndex + dir + lbVisible.length) % lbVisible.length;
    renderLightbox();
}

function renderLightbox() {
    if (!lbVisible.length) return;
    const photo = lbVisible[lbIndex];

    // Teks
    document.getElementById('lbTitle').textContent    = photo.title;
    document.getElementById('lbCategory').textContent = photo.cat.charAt(0).toUpperCase() + photo.cat.slice(1);
    document.getElementById('lbDesc').textContent     = photo.desc;
    document.getElementById('lbDate').textContent     = photo.date;
    document.getElementById('lbCounter').textContent  = (lbIndex + 1) + ' / ' + lbVisible.length;

    // Frame rasio
    const portrait  = document.getElementById('lbPortrait');
    const landscape = document.getElementById('lbLandscape');
    portrait.classList.add('hidden');
    landscape.classList.add('hidden');

    if (photo.ratio === 'portrait') {
        portrait.classList.remove('hidden');
        // Kosongkan: set src gambar → document.getElementById('lbImgPortrait').src = photo.image_url;
    } else {
        landscape.classList.remove('hidden');
        // Kosongkan: set src gambar → document.getElementById('lbImgLandscape').src = photo.image_url;
    }

    // Thumbnail strip
    const strip = document.getElementById('lbThumbs');
    strip.innerHTML = '';
    lbVisible.forEach((p, i) => {
        const thumb = document.createElement('button');
        thumb.setAttribute('aria-label', 'Lihat ' + p.title);
        thumb.className = [
            'flex-shrink-0 w-14 h-14 rounded-lg overflow-hidden border-2 transition-all duration-200',
            i === lbIndex
                ? 'border-[#FFC20E] opacity-100'
                : 'border-transparent opacity-50 hover:opacity-75'
        ].join(' ');
        thumb.innerHTML = `
            <div class="w-full h-full bg-[#0F2F6B]/40 flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909"/>
                </svg>
            </div>`;
        // Kosongkan: ganti div placeholder di atas dengan <img src="${p.image_url}" alt="${p.title}" class="w-full h-full object-cover">
        thumb.onclick = () => { lbIndex = i; renderLightbox(); };
        strip.appendChild(thumb);
    });

    // Scroll thumb aktif ke tengah
    const activThumb = strip.children[lbIndex];
    if (activThumb) activThumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
}

// Keyboard navigation
document.addEventListener('keydown', function (e) {
    const lb = document.getElementById('lightbox');
    if (lb.classList.contains('hidden')) return;
    if (e.key === 'ArrowRight') navigateLightbox(1);
    if (e.key === 'ArrowLeft')  navigateLightbox(-1);
    if (e.key === 'Escape')     closeLightbox();
});

// Swipe touch support
let touchStartX = 0;
document.getElementById('lightbox').addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].clientX;
}, { passive: true });
document.getElementById('lightbox').addEventListener('touchend', e => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) navigateLightbox(diff > 0 ? 1 : -1);
}, { passive: true });
</script>

@endsection