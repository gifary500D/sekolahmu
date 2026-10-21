@extends('layouts.app')

@section('title', 'Berita & Informasi')

@section('content')
<!-- Hero Section -->
<section class="py-12 sm:py-16 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita & Informasi</h1>
        <p class="text-lg text-blue-100 max-w-2xl mx-auto">Dapatkan update terbaru seputar kegiatan, prestasi, dan perkembangan SMA Pemda Bahorok</p>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="py-8 sm:py-12 bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Search Box -->
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Cari berita..." class="w-full px-6 py-3 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-amber-400 focus:border-transparent outline-none transition-all">
                <svg class="absolute right-4 top-3.5 w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Category Filter -->
            <div class="flex gap-2 overflow-x-auto pb-2">
                <button data-filter="semua" class="filter-btn px-6 py-2 bg-amber-400 text-blue-950 rounded-full font-semibold text-sm whitespace-nowrap hover:bg-amber-300 transition-colors active">Semua</button>
                <button data-filter="akademik" class="filter-btn px-6 py-2 border-2 border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-amber-400 hover:text-amber-500 transition-colors">Akademik</button>
                <button data-filter="olahraga" class="filter-btn px-6 py-2 border-2 border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-amber-400 hover:text-amber-500 transition-colors">Olahraga</button>
                <button data-filter="kegiatan" class="filter-btn px-6 py-2 border-2 border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-full font-semibold text-sm whitespace-nowrap hover:border-amber-400 hover:text-amber-500 transition-colors">Kegiatan</button>
            </div>
        </div>
    </div>
</section>

<!-- Featured News -->
<section class="py-16 sm:py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Berita Utama</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Berita Terpopuler</h2>
        </div>

        <!-- Featured Article Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Large Featured Card -->
            <div class="lg:col-span-2 group">
                <div class="relative h-96 overflow-hidden rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 shadow-xl">
                    <img src="https://images.unsplash.com/photo-1505994032602-b1fbc17e3049?w=800&h=500&fit=crop" alt="Berita Utama" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-8">
                        <span class="text-amber-300 font-bold text-xs uppercase tracking-wider mb-3 w-fit px-3 py-1 bg-white/20 rounded-full">Akademik</span>
                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-3 group-hover:text-amber-300 transition-colors">Juara Kompetisi Sains Nasional 2024</h3>
                        <p class="text-blue-100 text-base mb-4">Tim Science Club kami berhasil meraih juara pertama dalam kompetisi sains nasional yang diikuti oleh 200+ sekolah dari seluruh Indonesia.</p>
                        <div class="flex items-center gap-4 text-blue-100 text-sm">
                            <span>15 Oktober 2024</span>
                            <span>•</span>
                            <span>Admin SMA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Featured Cards -->
            <div class="space-y-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-lg transition-all duration-300 group h-44">
                    <div class="relative h-24 overflow-hidden bg-gradient-to-br from-green-400 to-green-600">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=200&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-amber-500 uppercase tracking-wide">Olahraga</span>
                        <h4 class="text-base font-bold text-gray-900 dark:text-white mt-1 group-hover:text-amber-500 transition-colors line-clamp-2">Juara Piala Olahraga Kota</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-2">10 Oktober 2024</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-lg transition-all duration-300 group h-44">
                    <div class="relative h-24 overflow-hidden bg-gradient-to-br from-purple-400 to-purple-600">
                        <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=200&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <span class="text-xs font-bold text-amber-500 uppercase tracking-wide">Kegiatan</span>
                        <h4 class="text-base font-bold text-gray-900 dark:text-white mt-1 group-hover:text-amber-500 transition-colors line-clamp-2">Program Literasi Digital</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-2">8 Oktober 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- All News Grid -->
<section class="py-16 sm:py-20 bg-gray-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Semua Berita</h2>
            <p class="text-gray-600 dark:text-slate-400 text-lg">Jelajahi arsip lengkap berita dan informasi terbaru kami</p>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- News Card 1 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="akademik" data-title="Peluncuran Program Beasiswa Pendidikan">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-indigo-400 to-indigo-600">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Akademik</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        5 Oktober 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Peluncuran Program Beasiswa Pendidikan</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Sekolah meluncurkan program beasiswa untuk siswa berprestasi dengan benefit mencakup biaya pendidikan dan mentoring akademik.</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- News Card 2 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="olahraga" data-title="Turnamen Futsal Antar Kelas Dimulai">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-rose-400 to-rose-600">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Olahraga</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        3 Oktober 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Turnamen Futsal Antar Kelas Dimulai</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Turnamen futsal tahunan telah dimulai dengan partisipasi 16 tim dari berbagai kelas dengan hadiah menarik menanti pemenang.</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- News Card 3 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="kegiatan" data-title="Peringatan Hari Kesadaran Lingkungan">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-cyan-400 to-cyan-600">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Kegiatan</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        1 Oktober 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Peringatan Hari Kesadaran Lingkungan</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Sekolah mengadakan kegiatan penanaman pohon dan edukasi lingkungan yang melibatkan seluruh siswa dan guru.</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- News Card 4 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="akademik" data-title="Pembukaan Lab Komputer Terbaru">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-amber-400 to-amber-600">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Akademik</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        28 September 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Pembukaan Lab Komputer Terbaru</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Fasilitas baru berupa lab komputer berstandar internasional telah resmi dibuka untuk mendukung pembelajaran teknologi.</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- News Card 5 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="kegiatan" data-title="Festival Budaya Sekolah 2024">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-emerald-400 to-emerald-600">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Kegiatan</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        25 September 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Festival Budaya Sekolah 2024</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Acara tahunan menampilkan berbagai penampilan seni dan budaya dari seluruh siswa dengan tema "Menggali Akar Budaya".</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- News Card 6 -->
            <div class="news-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-xl transition-all duration-300 group flex flex-col" data-category="olahraga" data-title="Tim Basket Lolos ke Babak Semifinal">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-violet-400 to-violet-600">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=400&fit=crop" alt="Berita" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute top-4 right-4">
                        <span class="inline-block bg-amber-400 text-blue-950 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wide">Olahraga</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-sm text-gray-500 dark:text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                        20 September 2024
                    </p>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-amber-500 transition-colors leading-tight">Tim Basket Lolos ke Babak Semifinal</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4 flex-grow">Tim basket putra SMA Pemda Bahorok berhasil melampaui babak penyisihan dengan performa spektakuler melawan tim unggulan.</p>
                    <a href="#" class="text-amber-500 font-semibold text-sm hover:text-amber-600 transition-colors inline-flex items-center gap-2 group/link">
                        Baca Selengkapnya
                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center items-center gap-2 mt-12">
            <button class="px-4 py-2 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="px-4 py-2 bg-amber-400 text-blue-950 rounded-lg font-semibold">1</button>
            <button class="px-4 py-2 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">2</button>
            <button class="px-4 py-2 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">3</button>
            <button class="px-4 py-2 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ingin Bergabung Dengan Kami?</h2>
        <p class="text-lg text-blue-100 mb-8">Daftarkan diri Anda dan menjadi bagian dari keluarga besar SMA Pemda Bahorok</p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>

<!-- Related Info Section -->
<section class="py-16 sm:py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Informasi Berguna</h2>
            <p class="text-gray-600 dark:text-slate-400 text-lg">Akses ke informasi penting sekolah lainnya</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <a href="#" class="group p-8 rounded-2xl border border-gray-200 dark:border-slate-800 hover:border-amber-400 hover:shadow-xl transition-all duration-300 bg-white dark:bg-slate-900">
                <div class="w-14 h-14 rounded-lg bg-blue-100 dark:bg-blue-950/60 flex items-center justify-center mb-4 group-hover:bg-amber-100 dark:group-hover:bg-amber-950/60 transition-colors">
                    <svg class="w-7 h-7 text-blue-900 dark:text-blue-300 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-amber-500 transition-colors">Jadwal Kegiatan</h3>
                <p class="text-gray-600 dark:text-slate-400 text-sm">Lihat jadwal lengkap kegiatan sekolah untuk tahun akademik ini</p>
                <span class="inline-flex items-center mt-4 text-amber-500 font-semibold">Lihat selengkapnya <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>

            <a href="#" class="group p-8 rounded-2xl border border-gray-200 dark:border-slate-800 hover:border-amber-400 hover:shadow-xl transition-all duration-300 bg-white dark:bg-slate-900">
                <div class="w-14 h-14 rounded-lg bg-green-100 dark:bg-emerald-950/60 flex items-center justify-center mb-4 group-hover:bg-amber-100 dark:group-hover:bg-amber-950/60 transition-colors">
                    <svg class="w-7 h-7 text-green-900 dark:text-emerald-300 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-amber-500 transition-colors">Pengumuman Penting</h3>
                <p class="text-gray-600 dark:text-slate-400 text-sm">Dapatkan update pengumuman penting yang langsung dari administrasi sekolah</p>
                <span class="inline-flex items-center mt-4 text-amber-500 font-semibold">Lihat selengkapnya <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>

            <a href="#" class="group p-8 rounded-2xl border border-gray-200 dark:border-slate-800 hover:border-amber-400 hover:shadow-xl transition-all duration-300 bg-white dark:bg-slate-900">
                <div class="w-14 h-14 rounded-lg bg-purple-100 dark:bg-purple-950/60 flex items-center justify-center mb-4 group-hover:bg-amber-100 dark:group-hover:bg-amber-950/60 transition-colors">
                    <svg class="w-7 h-7 text-purple-900 dark:text-purple-300 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-amber-500 transition-colors">Download Dokumen</h3>
                <p class="text-gray-600 dark:text-slate-400 text-sm">Akses dokumen penting termasuk formulir pendaftaran dan peraturan sekolah</p>
                <span class="inline-flex items-center mt-4 text-amber-500 font-semibold">Lihat selengkapnya <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>
            </a>
        </div>
    </div>
</section>

<!-- JavaScript untuk Filter dan Search -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const newsCards = document.querySelectorAll('.news-card');
        let currentFilter = 'semua';

        // Filter berdasarkan kategori
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentFilter = this.dataset.filter;
                
                // Update active button
                filterButtons.forEach(btn => {
                    btn.classList.remove('bg-amber-400', 'text-blue-950', 'active');
                    btn.classList.add('border-2', 'border-gray-300', 'text-gray-700');
                });
                
                this.classList.remove('border-2', 'border-gray-300', 'text-gray-700');
                this.classList.add('bg-amber-400', 'text-blue-950', 'active');
                
                // Filter cards
                filterCards();
            });
        });

        // Search berdasarkan judul
        searchInput.addEventListener('keyup', function() {
            filterCards();
        });

        // Fungsi untuk filter cards
        function filterCards() {
            const searchTerm = searchInput.value.toLowerCase();
            let visibleCount = 0;

            newsCards.forEach(card => {
                const category = card.dataset.category;
                const title = card.dataset.title.toLowerCase();
                
                // Check kategori
                const categoryMatch = (currentFilter === 'semua') || (category === currentFilter);
                
                // Check search
                const searchMatch = title.includes(searchTerm);
                
                // Tampilkan card jika keduanya match
                if (categoryMatch && searchMatch) {
                    card.style.display = '';
                    // Animate
                    card.style.animation = 'none';
                    setTimeout(() => {
                        card.style.animation = 'fadeIn 0.3s ease-in';
                    }, 10);
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada hasil
            const newsGrid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2');
            let noResultsMsg = document.getElementById('noResults');
            
            if (visibleCount === 0) {
                if (!noResultsMsg) {
                    noResultsMsg = document.createElement('div');
                    noResultsMsg.id = 'noResults';
                    noResultsMsg.className = 'col-span-full text-center py-12';
                    noResultsMsg.innerHTML = `
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-lg font-medium">Tidak ada berita yang ditemukan</p>
                        <p class="text-gray-400 text-sm mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                    `;
                    newsGrid.appendChild(noResultsMsg);
                }
            } else {
                if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            }
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection