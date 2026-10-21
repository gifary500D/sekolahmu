@extends('layouts.app')

@section('title', 'Agenda Sekolah')

@section('content')

{{-- =============================================
     HERO SECTION
     ============================================= --}}
<section class="py-12 sm:py-16 bg-[#0F2F6B] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block bg-[#FFC20E]/20 border border-[#FFC20E]/30 text-[#FFC20E] text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wide mb-4">
            Jadwal & Kegiatan
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Agenda Sekolah</h1>
        <p class="text-base sm:text-lg text-blue-100 max-w-2xl mx-auto">
            Pantau seluruh jadwal kegiatan, acara, dan momen penting SMA Pemda Bahorok
        </p>
    </div>
</section>


{{-- =============================================
     FILTER & SEARCH
     ============================================= --}}
<section class="py-6 sm:py-8 bg-white border-b border-gray-200 sticky top-16 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Search --}}
            <div class="relative">
                <label for="searchInput" class="sr-only">Cari agenda</label>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari agenda..."
                    class="w-full px-5 py-3 pl-11 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E63D6] focus:border-transparent outline-none transition-all text-sm"
                >
                <svg class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- Filter Kategori --}}
            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
                <button data-filter="semua"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 bg-[#1E63D6] text-white rounded-full font-semibold text-sm whitespace-nowrap transition-colors">
                    Semua
                </button>
                <button data-filter="akademik"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 text-gray-600 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] transition-colors">
                    Akademik
                </button>
                <button data-filter="olahraga"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 text-gray-600 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] transition-colors">
                    Olahraga
                </button>
                <button data-filter="kegiatan"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 text-gray-600 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] transition-colors">
                    Kegiatan
                </button>
                <button data-filter="libur"
                    class="filter-btn flex-shrink-0 px-5 py-2.5 border-2 border-gray-300 text-gray-600 rounded-full font-semibold text-sm whitespace-nowrap hover:border-[#1E63D6] hover:text-[#1E63D6] transition-colors">
                    Libur
                </button>
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     AGENDA BULAN INI - HIGHLIGHT
     ============================================= --}}
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs uppercase mb-2">Segera Datang</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Agenda Bulan Ini</h2>
        </div>

        {{-- Highlight grid: 1 besar + 2 kecil --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

            {{-- Featured agenda card --}}
            <div class="lg:col-span-2 agenda-card rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 group"
                 data-category="akademik" data-title="ujian akhir semester">
                <div class="bg-[#0F2F6B] p-6 sm:p-8 flex gap-5 items-start">
                    {{-- Tanggal besar --}}
                    <div class="flex-shrink-0 text-center bg-white/10 rounded-xl px-4 py-3 min-w-[64px]">
                        <span class="block text-3xl font-bold text-[#FFC20E] leading-none">--</span>
                        <span class="block text-xs text-blue-200 uppercase mt-1 font-semibold tracking-wide">Bln</span>
                        <span class="block text-sm text-blue-300 mt-0.5">2026</span>
                    </div>
                    {{-- Detail --}}
                    <div class="flex-1 min-w-0">
                        <span class="inline-block bg-[#FFC20E]/20 border border-[#FFC20E]/30 text-[#FFC20E] text-xs font-bold px-3 py-0.5 rounded-full uppercase tracking-wide mb-3">
                            Akademik
                        </span>
                        <h3 class="text-lg sm:text-xl font-bold text-white mb-2 group-hover:text-[#FFC20E] transition-colors">
                            Judul agenda utama akan diisi dari database
                        </h3>
                        <p class="text-blue-200 text-sm mb-4 leading-relaxed">
                            Deskripsi agenda akan ditampilkan di sini setelah data tersedia dari pihak sekolah.
                        </p>
                        <div class="flex flex-wrap gap-4 text-blue-300 text-xs">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m8-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                --:-- WIB s.d. --:-- WIB
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                Lokasi belum tersedia
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs text-gray-400">Ditambahkan oleh Admin</span>
                    <a href="#" class="text-[#1E63D6] font-semibold text-sm hover:text-[#0F2F6B] transition-colors inline-flex items-center gap-1">
                        Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- 2 agenda kecil --}}
            <div class="flex flex-col gap-4">
                @for ($i = 0; $i < 2; $i++)
                <div class="agenda-card bg-white rounded-xl border border-gray-100 hover:border-[#1E63D6]/30 hover:shadow-lg transition-all duration-300 group overflow-hidden"
                     data-category="kegiatan" data-title="agenda kegiatan sekolah">
                    <div class="flex items-stretch">
                        <div class="w-16 bg-[#1F8A4C] flex flex-col items-center justify-center py-4 flex-shrink-0">
                            <span class="text-2xl font-bold text-white leading-none">--</span>
                            <span class="text-xs text-green-200 uppercase mt-1 font-semibold">Bln</span>
                        </div>
                        <div class="p-4 flex-1 min-w-0">
                            <span class="text-xs font-bold text-[#1F8A4C] uppercase tracking-wide">Kegiatan</span>
                            <h4 class="text-sm font-bold text-gray-900 mt-1 mb-2 group-hover:text-[#1E63D6] transition-colors line-clamp-2">
                                Judul agenda akan diisi dari database
                            </h4>
                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m8-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                --:-- WIB
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     SEMUA AGENDA - LIST VIEW
     ============================================= --}}
<section class="py-12 sm:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">Semua Agenda</h2>
            <p class="text-gray-500 text-base">Jelajahi daftar lengkap kegiatan sekolah</p>
        </div>

        {{-- Toggle tampilan: list / grid --}}
        <div class="flex items-center gap-2 mb-6">
            <button id="viewList" aria-label="Tampilan daftar"
                class="view-btn w-9 h-9 rounded-lg bg-[#1E63D6] text-white flex items-center justify-center transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <button id="viewGrid" aria-label="Tampilan grid"
                class="view-btn w-9 h-9 rounded-lg border border-gray-300 text-gray-500 flex items-center justify-center hover:border-[#1E63D6] hover:text-[#1E63D6] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                </svg>
            </button>
        </div>

        {{-- Kontainer agenda --}}
        <div id="agendaContainer" class="space-y-4">

            {{-- Kategori warna helper (tidak tampil) --}}
            @php
            $categories = [
                ['key' => 'akademik',  'label' => 'Akademik',  'color' => 'bg-[#0F2F6B]', 'text' => 'text-[#1E63D6]',  'border' => 'border-[#1E63D6]/20'],
                ['key' => 'olahraga',  'label' => 'Olahraga',  'color' => 'bg-[#1F8A4C]', 'text' => 'text-[#1F8A4C]',  'border' => 'border-[#1F8A4C]/20'],
                ['key' => 'kegiatan',  'label' => 'Kegiatan',  'color' => 'bg-[#1E63D6]', 'text' => 'text-[#1E63D6]',  'border' => 'border-[#1E63D6]/20'],
                ['key' => 'libur',     'label' => 'Libur',     'color' => 'bg-gray-500',   'text' => 'text-gray-500',   'border' => 'border-gray-200'],
            ];
            // Kosongkan: ganti dengan $agendas dari controller
            $agendas = [
                ['cat' => 0, 'tgl' => '--', 'bln' => 'Okt', 'judul' => 'Ujian Tengah Semester Ganjil',          'desc' => 'Pelaksanaan UTS untuk semua kelas.',              'waktu' => '--:--', 'lokasi' => 'Ruang Kelas'],
                ['cat' => 2, 'tgl' => '--', 'bln' => 'Okt', 'judul' => 'Upacara Peringatan Sumpah Pemuda',      'desc' => 'Upacara bendera memperingati hari Sumpah Pemuda.','waktu' => '07.00', 'lokasi' => 'Lapangan Upacara'],
                ['cat' => 1, 'tgl' => '--', 'bln' => 'Nov', 'judul' => 'Turnamen Olahraga Antar Kelas',         'desc' => 'Pertandingan berbagai cabang olahraga.',          'waktu' => '08.00', 'lokasi' => 'Lapangan Sekolah'],
                ['cat' => 0, 'tgl' => '--', 'bln' => 'Nov', 'judul' => 'Pameran Karya Ilmiah Siswa',            'desc' => 'Pameran hasil penelitian dan karya tulis siswa.', 'waktu' => '09.00', 'lokasi' => 'Aula Sekolah'],
                ['cat' => 3, 'tgl' => '--', 'bln' => 'Nov', 'judul' => 'Libur Hari Pahlawan',                   'desc' => 'Hari libur nasional memperingati Hari Pahlawan.',  'waktu' => '-',    'lokasi' => '-'],
                ['cat' => 2, 'tgl' => '--', 'bln' => 'Des', 'judul' => 'Festival Seni & Budaya Tahunan',        'desc' => 'Penampilan seni dari seluruh kelas.',             'waktu' => '08.00', 'lokasi' => 'Aula Sekolah'],
            ];
            @endphp

            @foreach ($agendas as $item)
            @php $cat = $categories[$item['cat']]; @endphp
            <div class="agenda-card bg-white rounded-xl border border-gray-100 hover:border-[#1E63D6]/20 hover:shadow-lg transition-all duration-300 group overflow-hidden"
                 data-category="{{ $cat['key'] }}"
                 data-title="{{ strtolower($item['judul']) }}">
                <div class="flex items-stretch">

                    {{-- Tanggal sidebar --}}
                    <div class="w-16 sm:w-20 {{ $cat['color'] }} flex flex-col items-center justify-center py-4 flex-shrink-0">
                        <span class="text-xl sm:text-2xl font-bold text-white leading-none">{{ $item['tgl'] }}</span>
                        <span class="text-xs text-white/70 uppercase mt-1 font-semibold">{{ $item['bln'] }}</span>
                    </div>

                    {{-- Konten --}}
                    <div class="flex-1 min-w-0 p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="text-xs font-bold {{ $cat['text'] }} uppercase tracking-wide">{{ $cat['label'] }}</span>
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-[#1E63D6] transition-colors text-sm sm:text-base mb-1">
                                {{ $item['judul'] }}
                            </h3>
                            <p class="text-gray-500 text-xs sm:text-sm line-clamp-1">{{ $item['desc'] }}</p>
                        </div>

                        {{-- Meta info --}}
                        <div class="flex sm:flex-col items-center sm:items-end gap-3 sm:gap-2 flex-shrink-0">
                            @if($item['waktu'] !== '-')
                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m8-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $item['waktu'] }} WIB
                            </span>
                            @endif
                            @if($item['lokasi'] !== '-')
                            <span class="flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                {{ $item['lokasi'] }}
                            </span>
                            @endif
                            <a href="#" class="text-[#1E63D6] text-xs font-semibold hover:text-[#0F2F6B] transition-colors whitespace-nowrap">
                                Detail &rsaquo;
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

            {{-- State kosong (ditampilkan via JS) --}}
            <div id="noResults" class="hidden text-center py-16">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v1.5M17.25 3v1.5M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-semibold text-base">Tidak ada agenda yang ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
            </div>

        </div>

        {{-- Pagination --}}
        <div class="flex justify-center items-center gap-2 mt-10" role="navigation" aria-label="Halaman agenda">
            <button aria-label="Halaman sebelumnya"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button aria-current="page" class="w-9 h-9 rounded-lg bg-[#1E63D6] text-white font-semibold text-sm">1</button>
            <button class="w-9 h-9 rounded-lg border border-gray-300 text-gray-600 font-semibold text-sm hover:bg-gray-100 transition-colors">2</button>
            <button class="w-9 h-9 rounded-lg border border-gray-300 text-gray-600 font-semibold text-sm hover:bg-gray-100 transition-colors">3</button>
            <button aria-label="Halaman berikutnya"
                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

    </div>
</section>


{{-- =============================================
     CTA SECTION
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
     INFORMASI BERGUNA
     ============================================= --}}
<section class="py-12 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Informasi Terkait</h2>
            <p class="text-gray-500 text-base">Akses informasi penting sekolah lainnya</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <a href="{{ url('/berita') }}"
               class="group p-6 sm:p-8 rounded-2xl border border-gray-200 hover:border-[#1E63D6]/40 hover:shadow-xl transition-all duration-300 bg-white">
                <div class="w-12 h-12 rounded-xl bg-[#0F2F6B]/10 flex items-center justify-center mb-4 group-hover:bg-[#FFC20E]/20 transition-colors">
                    <svg class="w-6 h-6 text-[#0F2F6B] group-hover:text-[#1E63D6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 7.5h1.5m-1.5 3h1.5m-4.5 5.25h4.5m6 .75a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l4.122 4.12A1.5 1.5 0 0115.75 9.33V16.5z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-[#1E63D6] transition-colors">Berita Sekolah</h3>
                <p class="text-gray-500 text-sm mb-4">Baca berita dan informasi terkini dari sekolah</p>
                <span class="inline-flex items-center text-[#1E63D6] text-sm font-semibold group-hover:gap-2 gap-1 transition-all">
                    Lihat selengkapnya
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </a>

            <a href="{{ url('/galeri') }}"
               class="group p-6 sm:p-8 rounded-2xl border border-gray-200 hover:border-[#1F8A4C]/40 hover:shadow-xl transition-all duration-300 bg-white">
                <div class="w-12 h-12 rounded-xl bg-[#1F8A4C]/10 flex items-center justify-center mb-4 group-hover:bg-[#FFC20E]/20 transition-colors">
                    <svg class="w-6 h-6 text-[#1F8A4C] group-hover:text-[#1E63D6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-[#1E63D6] transition-colors">Galeri Kegiatan</h3>
                <p class="text-gray-500 text-sm mb-4">Lihat dokumentasi foto kegiatan sekolah</p>
                <span class="inline-flex items-center text-[#1E63D6] text-sm font-semibold group-hover:gap-2 gap-1 transition-all">
                    Lihat selengkapnya
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </a>

            <a href="{{ url('/daftar') }}"
               class="group p-6 sm:p-8 rounded-2xl border border-gray-200 hover:border-[#FFC20E]/60 hover:shadow-xl transition-all duration-300 bg-white">
                <div class="w-12 h-12 rounded-xl bg-[#FFC20E]/20 flex items-center justify-center mb-4 group-hover:bg-[#FFC20E]/40 transition-colors">
                    <svg class="w-6 h-6 text-[#0F2F6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a3 3 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-[#1E63D6] transition-colors">Pendaftaran PPDB</h3>
                <p class="text-gray-500 text-sm mb-4">Informasi dan jadwal penerimaan peserta didik baru</p>
                <span class="inline-flex items-center text-[#1E63D6] text-sm font-semibold group-hover:gap-2 gap-1 transition-all">
                    Lihat selengkapnya
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </a>

        </div>
    </div>
</section>


{{-- =============================================
     JAVASCRIPT
     ============================================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput   = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const noResults     = document.getElementById('noResults');
    const viewListBtn   = document.getElementById('viewList');
    const viewGridBtn   = document.getElementById('viewGrid');
    const container     = document.getElementById('agendaContainer');

    let currentFilter = 'semua';

    // ---- Filter kategori ----
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            currentFilter = this.dataset.filter;

            filterButtons.forEach(b => {
                b.classList.remove('bg-[#1E63D6]', 'text-white');
                b.classList.add('border-2', 'border-gray-300', 'text-gray-600');
            });
            this.classList.remove('border-2', 'border-gray-300', 'text-gray-600');
            this.classList.add('bg-[#1E63D6]', 'text-white');

            filterCards();
        });
    });

    // ---- Pencarian ----
    searchInput.addEventListener('input', filterCards);

    function filterCards() {
        const term  = searchInput.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.agenda-card');
        let visible = 0;

        cards.forEach(card => {
            const catMatch   = currentFilter === 'semua' || card.dataset.category === currentFilter;
            const termMatch  = !term || card.dataset.title.includes(term);
            const show       = catMatch && termMatch;

            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.classList.toggle('hidden', visible > 0);
    }

    // ---- Toggle list / grid ----
    viewListBtn.addEventListener('click', function () {
        container.classList.remove('grid', 'grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'gap-4');
        container.classList.add('space-y-4');

        this.classList.add('bg-[#1E63D6]', 'text-white');
        this.classList.remove('border', 'border-gray-300', 'text-gray-500');
        viewGridBtn.classList.remove('bg-[#1E63D6]', 'text-white');
        viewGridBtn.classList.add('border', 'border-gray-300', 'text-gray-500');
    });

    viewGridBtn.addEventListener('click', function () {
        container.classList.remove('space-y-4');
        container.classList.add('grid', 'grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-3', 'gap-4');

        this.classList.add('bg-[#1E63D6]', 'text-white');
        this.classList.remove('border', 'border-gray-300', 'text-gray-500');
        viewListBtn.classList.remove('bg-[#1E63D6]', 'text-white');
        viewListBtn.classList.add('border', 'border-gray-300', 'text-gray-500');
    });
});
</script>

@endsection