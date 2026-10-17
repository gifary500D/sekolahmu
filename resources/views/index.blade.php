@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- =============================================
     HERO SECTION - BRD M1-F01
     ============================================= --}}
<section class="relative bg-[#0F2F6B] overflow-hidden w-full aspect-[2/1] min-h-[300px] max-h-[640px]">

    {{-- Carousel Background --}}
    <div class="absolute inset-0">
        <div class="hero-carousel w-full h-full">
            <div class="hero-slide active"
                 style="background-image: url('{{ asset('images/spanduk1.jpg') }}');">
            </div>
            <div class="hero-slide"
                 style="background-image: url('{{ asset('images/spanduk2.jpg') }}');">
            </div>
            <div class="hero-slide"
                 style="background-image: url('{{ asset('images/spanduk3.jpg') }}');">
            </div>
        </div>
        <div class="absolute inset-0 bg-[#0F2F6B]/70"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative z-10 w-full flex items-center">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-12 items-center w-full">

            {{-- Konten Hero --}}
            <div class="text-white text-center md:text-left">
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#FFC20E]/15 border border-[#FFC20E]/30 text-[#FFC20E] text-xs sm:text-sm font-semibold tracking-wide uppercase mb-3">
                    Sekolah Menengah Atas Negeri
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight">
                    Selamat Datang di <span class="text-[#FFC20E]">SMA Negeri 1 Medan</span>
                </h1>
                <p class="text-sm sm:text-base md:text-lg mb-6 text-blue-100 max-w-xl mx-auto md:mx-0">
                    Membangun generasi muda yang berkarakter, cerdas, dan berdaya saing global.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start">
                    <a href="{{ url('/daftar') }}"
                       class="bg-[#FFC20E] text-[#0F2F6B] px-6 py-2.5 rounded-lg font-bold hover:bg-yellow-300 transition-all duration-300 text-center hover:shadow-lg hover:shadow-[#FFC20E]/30 text-sm sm:text-base">
                        Daftar Sekarang
                    </a>
                    <a href="#tentang"
                       class="border-2 border-white/40 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-white/10 hover:border-white transition-all duration-300 text-center text-sm sm:text-base">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            {{-- Ilustrasi Hero --}}
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-[#FFC20E]/10 rounded-3xl blur-3xl"></div>
                    <div class="relative bg-white/5 rounded-3xl p-6 backdrop-blur-md border border-white/10 aspect-square flex items-center justify-center">
                        {{-- Kosongkan: isi dengan gambar gedung/logo sekolah --}}
                        <div class="text-center text-white/40">
                            <div class="w-24 h-24 mx-auto mb-3 rounded-full bg-white/10 border-2 border-dashed border-white/20 flex items-center justify-center">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            </div>
                            <p class="text-sm">Foto / Ilustrasi Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Carousel Controls --}}
    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
        <button onclick="prevSlide()" aria-label="Slide sebelumnya" class="carousel-control">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <div class="flex gap-2 items-center">
            <button onclick="goToSlide(0)" aria-label="Slide 1" class="carousel-dot active"></button>
            <button onclick="goToSlide(1)" aria-label="Slide 2" class="carousel-dot"></button>
            <button onclick="goToSlide(2)" aria-label="Slide 3" class="carousel-dot"></button>
        </div>
        <button onclick="nextSlide()" aria-label="Slide berikutnya" class="carousel-control">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</section>


{{-- =============================================
     PENGUMUMAN - BRD M1-F01 (tambahan dari BRD)
     ============================================= --}}
<div class="bg-[#1E63D6] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 py-3 overflow-hidden">
            <span class="flex-shrink-0 bg-[#FFC20E] text-[#0F2F6B] text-xs font-bold px-3 py-1 rounded uppercase tracking-wide">
                Pengumuman
            </span>
            <div class="overflow-hidden flex-1">
                <div class="marquee-track flex gap-12 text-sm font-medium whitespace-nowrap">
                    {{-- Kosongkan: isi dengan data pengumuman dari database --}}
                    <span>Pengumuman sekolah akan ditampilkan di sini setelah data tersedia.</span>
                    <span>Informasi kegiatan dan agenda penting akan diperbarui secara berkala.</span>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- =============================================
     BERITA TERBARU - BRD M1-F03
     ============================================= --}}
<section id="berita" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Informasi Terkini</span>
            <h2 class="section-title mx-auto max-w-2xl">Berita Terbaru</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Dapatkan informasi terkini seputar kegiatan dan prestasi SMA Negeri 1 Medan
            </p>
        </div>

        {{-- State: Data berita (akan diisi dari database) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">

            {{-- Card Berita: kosongkan gambar, isi dari DB --}}
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300 group">
                <div class="relative h-48 overflow-hidden bg-[#0F2F6B]/10 flex items-center justify-center">
                    {{-- Kosongkan: ganti dengan {{ $berita->thumbnail }} --}}
                    <div class="text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5" />
                        </svg>
                        <p class="text-xs">Gambar Berita</p>
                    </div>
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-[#FFC20E] uppercase tracking-wide">Kategori</span>
                    <h3 class="text-lg font-bold text-gray-900 mt-2 mb-3 group-hover:text-[#1E63D6] transition-colors line-clamp-2">
                        Judul berita akan ditampilkan di sini
                    </h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        Ringkasan berita akan ditampilkan di sini setelah data tersedia dari database.
                    </p>
                    <a href="#" class="text-[#1E63D6] font-semibold text-sm hover:text-[#0F2F6B] transition-colors inline-flex items-center gap-1">
                        Baca Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endfor

        </div>

        <div class="text-center mt-12">
            <a href="{{ url('/berita') }}" class="btn-primary">Lihat Semua Berita</a>
        </div>
    </div>
</section>


{{-- =============================================
     AGENDA - BRD M1-F04 (BARU - wajib BRD)
     ============================================= --}}
<section id="agenda" class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kegiatan Sekolah</span>
            <h2 class="section-title mx-auto max-w-2xl">Agenda Mendatang</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Pantau jadwal kegiatan dan acara penting sekolah
            </p>
        </div>

        {{-- Layout agenda: daftar kiri + highlight kanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Daftar Agenda --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Item agenda - kosongkan, isi dari DB --}}
                @for ($i = 0; $i < 4; $i++)
                <div class="bg-white rounded-xl p-5 border border-gray-100 hover:border-[#1E63D6]/30 hover:shadow-lg transition-all duration-300 flex gap-4 items-start group">
                    {{-- Tanggal --}}
                    <div class="flex-shrink-0 w-14 h-14 rounded-xl bg-[#0F2F6B] flex flex-col items-center justify-center text-white group-hover:bg-[#1E63D6] transition-colors">
                        <span class="text-lg font-bold leading-none">--</span>
                        <span class="text-xs uppercase mt-0.5 text-[#FFC20E]">Bln</span>
                    </div>
                    {{-- Detail --}}
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 group-hover:text-[#1E63D6] transition-colors mb-1">
                            Judul agenda akan diisi dari database
                        </h4>
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">
                            Deskripsi agenda akan ditampilkan di sini.
                        </p>
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m8-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                --:-- WIB
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                </svg>
                                Lokasi belum tersedia
                            </span>
                        </div>
                    </div>
                </div>
                @endfor

            </div>

            {{-- Kalender Mini / Highlight --}}
            <div class="lg:col-span-1">
                <div class="bg-[#0F2F6B] rounded-xl p-6 text-white h-full min-h-[280px] flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-lg mb-1">Kalender Akademik</h3>
                        <p class="text-blue-200 text-sm mb-6">Tahun Pelajaran 2026/2027</p>
                        {{-- Kosongkan: isi dengan komponen kalender atau highlight semester --}}
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/10">
                                <div class="w-2 h-2 rounded-full bg-[#FFC20E] flex-shrink-0"></div>
                                <span class="text-sm">Data semester akan diisi dari database</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-white/10">
                                <div class="w-2 h-2 rounded-full bg-[#1F8A4C] flex-shrink-0"></div>
                                <span class="text-sm">Informasi libur nasional</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="mt-6 block text-center bg-[#FFC20E] text-[#0F2F6B] font-bold py-2.5 rounded-lg hover:bg-yellow-300 transition-colors text-sm">
                        Lihat Semua Agenda
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     TENTANG KAMI - BRD M1-F02
     ============================================= --}}
<section id="tentang" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">

            {{-- Gambar --}}
            <div class="order-1 md:order-1">
                <div class="bg-[#0F2F6B] rounded-2xl aspect-[4/3] flex items-center justify-center text-white relative overflow-hidden group hover:shadow-2xl transition-shadow">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                    {{-- Kosongkan: ganti dengan <img> foto gedung sekolah --}}
                    <div class="text-center relative z-10">
                        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-white/10 border-2 border-dashed border-white/20 flex items-center justify-center">
                            <svg class="w-9 h-9 text-[#FFC20E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <p class="text-sm text-blue-200">Foto Gedung Sekolah</p>
                    </div>
                </div>
            </div>

            {{-- Konten --}}
            <div class="order-2 md:order-2">
                <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Tentang Sekolah</span>
                <h2 class="section-title">Tentang Kami</h2>
                {{-- Kosongkan: isi dengan deskripsi resmi dari sekolah --}}
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-4">
                    SMA Negeri 1 Medan adalah institusi pendidikan terkemuka yang berkomitmen memberikan
                    pendidikan berkualitas tinggi dengan pendekatan holistik.
                </p>
                <p class="text-gray-500 text-sm leading-relaxed mb-8 border-l-4 border-[#FFC20E] pl-4">
                    Informasi visi, misi, dan sejarah sekolah akan ditampilkan di sini setelah dikonfirmasi pihak sekolah.
                </p>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#0F2F6B] flex items-center justify-center group-hover:bg-[#FFC20E] transition-colors">
                            <svg class="w-5 h-5 text-[#FFC20E] group-hover:text-[#0F2F6B] transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-[#1E63D6] transition-colors">Kurikulum Nasional</h4>
                            <p class="text-gray-500 text-sm">Mengikuti standar kurikulum nasional terbaru</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#0F2F6B] flex items-center justify-center group-hover:bg-[#FFC20E] transition-colors">
                            <svg class="w-5 h-5 text-[#FFC20E] group-hover:text-[#0F2F6B] transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-[#1E63D6] transition-colors">Ekstrakurikuler Lengkap</h4>
                            <p class="text-gray-500 text-sm">Berbagai pilihan kegiatan pengembangan diri</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 group">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-[#0F2F6B] flex items-center justify-center group-hover:bg-[#FFC20E] transition-colors">
                            <svg class="w-5 h-5 text-[#FFC20E] group-hover:text-[#0F2F6B] transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 group-hover:text-[#1E63D6] transition-colors">Bimbingan Akademik</h4>
                            <p class="text-gray-500 text-sm">Program bimbingan belajar dan konseling siswa</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/tentang') }}" class="inline-flex items-center gap-2 mt-8 text-[#1E63D6] font-semibold hover:text-[#0F2F6B] transition-colors">
                    Selengkapnya
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     GALERI - BRD M1-F06 (BARU - wajib BRD)
     ============================================= --}}
<section id="galeri" class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Dokumentasi</span>
            <h2 class="section-title mx-auto max-w-2xl">Galeri Sekolah</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Sekilas kegiatan dan momen berharga di SMA Negeri 1 Medan
            </p>
        </div>

        {{-- Grid Galeri --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">

            {{-- Item galeri kosong - isi dengan gambar dari DB --}}
            @for ($i = 0; $i < 8; $i++)
            <div class="relative group rounded-xl overflow-hidden bg-[#0F2F6B]/10 aspect-square border border-gray-200 hover:shadow-xl transition-all duration-300 cursor-pointer">
                {{-- Kosongkan: ganti dengan <img src="{{ $item->image_path }}" alt="{{ $item->alt_text }}" ...> --}}
                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3.75 6h16.5" />
                    </svg>
                    <span class="text-xs">Foto {{ $i + 1 }}</span>
                </div>
                <div class="absolute inset-0 bg-[#0F2F6B]/0 group-hover:bg-[#0F2F6B]/50 transition-colors duration-300 flex items-center justify-center">
                    <span class="text-white font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Lihat
                    </span>
                </div>
            </div>
            @endfor

        </div>

        <div class="text-center mt-10">
            <a href="{{ url('/galeri') }}" class="btn-outline">Lihat Semua Galeri</a>
        </div>
    </div>
</section>


{{-- =============================================
     TENAGA PENGAJAR - BRD (ada di halaman /guru)
     ============================================= --}}
<section id="guru" class="relative py-16 sm:py-20 bg-slate-900">

    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none" style="transform: translateY(-1px);">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-16 sm:h-20">
            <path d="M0,40 C180,80 360,0 540,40 C720,80 900,0 1080,40 C1260,80 1440,20 1440,20 L1440,0 L0,0 Z" fill="#f9fafb"/>
            <path d="M0,60 C200,20 400,80 600,50 C800,20 1000,70 1200,45 C1320,30 1400,55 1440,50 L1440,0 L0,0 Z" fill="#f9fafb" opacity="0.4"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Pendidik Kami</span>
            <h2 class="section-title mx-auto max-w-2xl text-white">Tenaga Pengajar</h2>
            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto">
                Didukung oleh guru-guru berpengalaman dan berdedikasi tinggi
            </p>
        </div>

        {{-- Teacher accordion panels - kosongkan gambar, isi dari DB --}}
        <div class="teacher-card" id="teacherCard">
            {{-- Panel akan diisi dari data sekolah. Contoh placeholder: --}}
            <div class="teacher-panel" style="background-color: #0F2F6B; --panel-color: #1E63D6;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-color: #1E63D6; --panel-color: #1E63D6;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-color: #1F8A4C; --panel-color: #1F8A4C;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-color: #0F2F6B; --panel-color: #1E63D6;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-color: #1E63D6; --panel-color: #1E63D6;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-color: #1F8A4C; --panel-color: #1F8A4C;">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Mata Pelajaran</span>
                    <span class="teacher-name">Nama Guru, Gelar</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ url('/guru') }}" class="inline-block bg-[#FFC20E] text-[#0F2F6B] px-8 py-3 rounded-lg font-bold hover:bg-yellow-300 transition-all duration-300">
                Lihat Semua Guru
            </a>
        </div>
    </div>
</section>


{{-- =============================================
     FASILITAS - BRD M1-F06
     ============================================= --}}
<section id="fasilitas" class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Sarana Prasarana</span>
            <h2 class="section-title mx-auto max-w-2xl">Fasilitas &amp; Sarana</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Dilengkapi dengan fasilitas modern untuk mendukung proses pembelajaran yang optimal
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            @php
            $fasilitas = [
                ['label' => 'Ruang Kelas Modern', 'desc' => 'Dilengkapi AC, proyektor, dan teknologi terkini', 'bg' => 'bg-[#0F2F6B]'],
                ['label' => 'Laboratorium Lengkap', 'desc' => 'Lab berstandar internasional', 'bg' => 'bg-[#1E63D6]'],
                ['label' => 'Perpustakaan Digital', 'desc' => 'Koleksi buku fisik dan digital', 'bg' => 'bg-[#1F8A4C]'],
                ['label' => 'Lapangan Olahraga', 'desc' => 'Standar kompetisi nasional', 'bg' => 'bg-[#1E63D6]'],
                ['label' => 'Aula Serbaguna', 'desc' => 'Ruang serbaguna modern', 'bg' => 'bg-[#0F2F6B]'],
                ['label' => 'Kantin & Koperasi', 'desc' => 'Menu sehat dan berkualitas', 'bg' => 'bg-[#1F8A4C]'],
                ['label' => 'Ruang Kesehatan', 'desc' => 'Penanganan darurat tersedia', 'bg' => 'bg-[#1E63D6]'],
                ['label' => 'WiFi & Internet', 'desc' => 'Koneksi gratis di seluruh area', 'bg' => 'bg-[#0F2F6B]'],
            ];
            @endphp

            @foreach ($fasilitas as $item)
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 group">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg {{ $item['bg'] }} flex items-center justify-center group-hover:scale-110 transition-transform">
                    {{-- Kosongkan: ganti dengan ikon SVG sesuai fasilitas --}}
                    <div class="w-6 h-6 rounded bg-[#FFC20E]/40 border border-dashed border-[#FFC20E]/60"></div>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base group-hover:text-[#1E63D6] transition-colors">{{ $item['label'] }}</h3>
                <p class="text-xs sm:text-sm text-gray-500">{{ $item['desc'] }}</p>
            </div>
            @endforeach

        </div>

        <div class="text-center mt-12">
            <a href="{{ url('/fasilitas') }}" class="btn-secondary">Lihat Semua Fasilitas</a>
        </div>
    </div>
</section>


{{-- =============================================
     LOKASI & KONTAK - BRD M1-F06
     ============================================= --}}
<section id="lokasi" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12">
            <span class="inline-block text-[#FFC20E] font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kunjungi Kami</span>
            <h2 class="section-title mx-auto max-w-2xl">Lokasi &amp; Kontak</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Temukan kami di lokasi yang strategis dan mudah dijangkau
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10 items-stretch">

            {{-- Peta --}}
            <div class="lg:col-span-3 rounded-2xl overflow-hidden shadow-lg border border-gray-100 min-h-[300px] sm:min-h-[380px]">
                <iframe
                    src="https://www.google.com/maps?q=SMA+Negeri+1+Medan&output=embed"
                    class="w-full h-full min-h-[300px] sm:min-h-[380px]"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi SMA Negeri 1 Medan">
                </iframe>
            </div>

            {{-- Info Kontak --}}
            <div class="lg:col-span-2 flex flex-col gap-4">
                @php
                $kontak = [
                    ['label' => 'Alamat', 'val' => 'Jl. Teladan No. 17, Medan Kota, Kota Medan, Sumatera Utara', 'bg' => 'bg-[#0F2F6B]'],
                    ['label' => 'Telepon', 'val' => '(061) 123-4567', 'bg' => 'bg-[#1E63D6]'],
                    ['label' => 'Email', 'val' => 'info@sman1medan.sch.id', 'bg' => 'bg-[#1F8A4C]'],
                    ['label' => 'Jam Operasional', 'val' => 'Senin - Jumat, 07.00 - 16.00 WIB', 'bg' => 'bg-[#0F2F6B]'],
                ];
                @endphp

                @foreach ($kontak as $k)
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 flex items-start gap-4 hover:border-[#1E63D6]/30 hover:shadow-lg transition-all duration-300 group">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg {{ $k['bg'] }} flex items-center justify-center group-hover:bg-[#FFC20E] transition-colors">
                        {{-- Kosongkan: isi dengan ikon SVG sesuai kontak --}}
                        <div class="w-4 h-4 rounded bg-[#FFC20E]/40 border border-dashed border-[#FFC20E]/60 group-hover:bg-[#0F2F6B]/30 transition-colors"></div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1 text-sm group-hover:text-[#1E63D6] transition-colors">{{ $k['label'] }}</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $k['val'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     CTA PPDB - BRD M1-F01, M2
     ============================================= --}}
<section class="py-16 sm:py-20 bg-[#0F2F6B] relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <span class="inline-block bg-[#FFC20E]/20 border border-[#FFC20E]/30 text-[#FFC20E] text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wide mb-4">
            PPDB / SPMB
        </span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">Siap Bergabung Bersama Kami?</h2>
        <p class="text-base sm:text-lg md:text-xl mb-8 text-blue-100">
            Daftarkan dirimu sekarang dan jadilah bagian dari keluarga besar SMA Negeri 1 Medan
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/daftar') }}"
               class="inline-block bg-[#FFC20E] text-[#0F2F6B] px-10 py-4 rounded-lg font-bold hover:bg-yellow-300 transition-all duration-300 hover:shadow-xl">
                Daftar Sekarang
            </a>
            <a href="{{ url('/daftar') }}#cek-status"
               class="inline-block border-2 border-white/30 text-white px-10 py-4 rounded-lg font-bold hover:bg-white/10 hover:border-white transition-all duration-300">
                Cek Status Pendaftaran
            </a>
        </div>
    </div>
</section>


{{-- =============================================
     JAVASCRIPT
     ============================================= --}}
<script>
// --- Carousel ---
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const totalSlides = slides.length;

function showSlide(n) {
    slides.forEach(s => s.classList.remove('active'));
    slides[n].classList.add('active');
    document.querySelectorAll('.carousel-dot').forEach((d, i) => {
        d.classList.toggle('active', i === n);
    });
}
function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; showSlide(currentSlide); }
function prevSlide() { currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; showSlide(currentSlide); }
function goToSlide(n) { currentSlide = n; showSlide(n); }

setInterval(nextSlide, 5000);

// --- Teacher Accordion Rows ---
document.addEventListener('DOMContentLoaded', function () {
    const card = document.getElementById('teacherCard');
    if (!card) return;

    const originalPanels = Array.from(card.querySelectorAll('.teacher-panel'));

    function buildRows() {
        card.innerHTML = '';
        const containerWidth = card.offsetWidth;
        const panelMinWidth = 60;
        const gap = 8;
        const countPerRow = Math.max(1, Math.floor((containerWidth + gap) / (panelMinWidth + gap)));

        for (let i = 0; i < originalPanels.length; i += countPerRow) {
            const row = document.createElement('div');
            row.className = 'teacher-row';
            originalPanels.slice(i, i + countPerRow).forEach(p => row.appendChild(p));
            card.appendChild(row);
        }

        card.querySelectorAll('.teacher-panel').forEach(function (panel) {
            panel.addEventListener('click', function () {
                const isActive = this.classList.contains('active');
                card.querySelectorAll('.teacher-panel').forEach(p => p.classList.remove('active'));
                if (!isActive) this.classList.add('active');
            });
        });
    }

    buildRows();

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(buildRows, 150);
    });
});
</script>

@endsection