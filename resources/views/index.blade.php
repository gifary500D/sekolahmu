@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 min-h-screen flex items-center overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-72 h-72 sm:w-96 sm:h-96 bg-amber-400/10 rounded-full -mr-24 -mt-24 sm:-mr-48 sm:-mt-48"></div>
    <div class="absolute bottom-0 left-0 w-56 h-56 sm:w-72 sm:h-72 bg-cyan-400/10 rounded-full -ml-20 -mb-20 sm:-ml-36 sm:-mb-36"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-12 items-center">
            <!-- Content -->
            <div class="text-white text-center md:text-left">
                <span class="inline-block px-4 py-1.5 rounded-full bg-amber-400/15 border border-amber-400/30 text-amber-300 text-xs sm:text-sm font-semibold tracking-wide uppercase mb-5">
                    Sekolah Menengah Atas Negeri
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di <span class="text-amber-300">SMA Negeri 1 Medan</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl mb-8 text-blue-100 max-w-xl mx-auto md:mx-0">
                    Membangun generasi muda yang berkarakter, cerdas, dan berdaya saing global.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="/daftar" class="bg-amber-400 text-blue-950 px-8 py-3 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 text-center hover:shadow-lg hover:shadow-amber-400/30">
                        Daftar Sekarang
                    </a>
                    <a href="#tentang" class="border-2 border-white/40 text-white px-8 py-3 rounded-lg font-bold hover:bg-white/10 hover:border-white transition-all duration-300 text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Illustration -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-amber-400/10 rounded-3xl blur-3xl"></div>
                    <div class="relative bg-gradient-to-br from-white/10 to-white/5 rounded-3xl p-8 backdrop-blur-md border border-white/10">
                        <svg class="w-full h-auto" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Gedung Sekolah -->
                            <rect x="50" y="100" width="200" height="150" fill="white" opacity="0.95"/>
                            <rect x="50" y="100" width="200" height="20" fill="#1e3a8a"/>
                            <!-- Windows -->
                            <rect x="70" y="130" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="110" y="130" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="150" y="130" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="190" y="130" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="70" y="170" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="110" y="170" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="150" y="170" width="25" height="25" fill="#1e3a8a"/>
                            <rect x="190" y="170" width="25" height="25" fill="#1e3a8a"/>
                            <!-- Door -->
                            <rect x="135" y="200" width="30" height="50" fill="#f59e0b"/>
                            <!-- Roof -->
                            <polygon points="50,100 150,30 250,100" fill="#f59e0b"/>
                            <!-- Flag -->
                            <rect x="148" y="10" width="3" height="25" fill="#e5e7eb"/>
                            <rect x="151" y="10" width="18" height="12" fill="#f59e0b"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-14 sm:mt-20">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2 text-amber-300">50+</h3>
                <p class="text-blue-100">Tahun Berdiri</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2 text-amber-300">1000+</h3>
                <p class="text-blue-100">Siswa Aktif</p>
            </div>
            <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2 text-amber-300">95%</h3>
                <p class="text-blue-100">Lulus Ujian</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami -->
<section id="tentang" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-12 items-center">
            <!-- Content -->
            <div class="order-2 md:order-1">
                <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Tentang Sekolah</span>
                <h2 class="section-title">Tentang Kami</h2>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-6">
                    SMA Negeri 1 Medan adalah institusi pendidikan terkemuka yang berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan pendekatan holistik. Kami percaya bahwa setiap siswa memiliki potensi unik yang perlu dikembangkan secara optimal.
                </p>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed mb-8">
                    Dengan fasilitas modern, tenaga pengajar berpengalaman, dan lingkungan belajar yang kondusif, kami siap membentuk generasi pemimpin masa depan yang berakhlak mulia dan berdaya saing tinggi.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-900 text-amber-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Kurikulum Nasional</h4>
                            <p class="text-gray-600">Mengikuti standar kurikulum nasional terbaru</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-900 text-amber-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Ekstrakurikuler Lengkap</h4>
                            <p class="text-gray-600">Berbagai pilihan kegiatan pengembangan diri</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-900 text-amber-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Bimbingan Akademik</h4>
                            <p class="text-gray-600">Program bimbingan belajar dan konseling siswa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Placeholder -->
            <div class="order-1 md:order-2">
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 rounded-2xl aspect-square flex items-center justify-center text-white relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                    <div class="text-center relative z-10">
                        <svg class="w-24 h-24 sm:w-32 sm:h-32 mx-auto mb-4 text-amber-300" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 4l9 5.75M4.5 10.5v8.25A1.25 1.25 0 005.75 20h12.5A1.25 1.25 0 0019.5 18.75V10.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 20v-5.25h4.5V20" />
                        </svg>
                        <p class="text-lg sm:text-xl font-semibold text-blue-100">Foto Sekolah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tenaga Pengajar -->
<section id="guru" class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Pendidik Kami</span>
            <h2 class="section-title mx-auto max-w-2xl">Tenaga Pengajar</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Didukung oleh guru-guru berpengalaman dan berdedikasi tinggi
            </p>
        </div>

        <div class="teacher-card">
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru1.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Matematika</span>
                    <span class="teacher-name">Drs. Ahmad Fauzi, M.M</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru2.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Fisika</span>
                    <span class="teacher-name">Ibu Sari Dewi, M.Si</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru3.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Bahasa Inggris</span>
                    <span class="teacher-name">Bpk. Reza Pratama, M.Hum</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru4.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Kimia</span>
                    <span class="teacher-name">Ibu Nur Aisyah, M.Sc</span>
                </div>
            </div>
            <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const card = document.querySelector('.teacher-card');
    const panels = Array.from(card.querySelectorAll('.teacher-panel'));

    function buildRows() {
        card.innerHTML = '';
        const containerWidth = card.offsetWidth;
        const panelWidth = 60;
        const gap = 8;
        const countPerRow = Math.floor((containerWidth + gap) / (panelWidth + gap));

        for (let i = 0; i < panels.length; i += countPerRow) {
            const row = document.createElement('div');
            row.className = 'teacher-row';
            const rowPanels = panels.slice(i, i + countPerRow);
            rowPanels.forEach(p => row.appendChild(p));
            card.appendChild(row);
        }
    }

    buildRows();
    window.addEventListener('resize', buildRows);
});
</script>

<!-- Program Unggulan -->
<section id="program" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kurikulum</span>
            <h2 class="section-title mx-auto max-w-2xl">Program Unggulan Kami</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Kami menawarkan berbagai program pendidikan yang dirancang untuk mengembangkan potensi siswa
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Card 1 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-900 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Akademik</h3>
                <p class="text-gray-600 leading-relaxed">
                    Program pembelajaran intensif dengan metode yang inovatif untuk meningkatkan prestasi akademik siswa di semua mata pelajaran.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-cyan-700 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IPA</h3>
                <p class="text-gray-600 leading-relaxed">
                    Fokus pada pengembangan kemampuan sains dan matematika dengan pendekatan praktik dan eksperimen langsung di laboratorium.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-emerald-700 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a14.5 14.5 0 010 18M12 3a14.5 14.5 0 000 18" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IPS</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan pemahaman tentang ilmu sosial, sejarah, dan budaya dengan perspektif global untuk mencetak pemimpin masa depan.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3.75h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m6.334-12.138a48.996 48.996 0 014.166 2.372" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Bahasa</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pelatihan intensif dalam berbagai bahasa asing untuk meningkatkan kompetensi komunikasi internasional siswa.
                </p>
            </div>

            <!-- Card 5 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-rose-700 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IT</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan keterampilan teknologi informasi untuk mempersiapkan siswa menghadapi era digital dan industri 4.0.
                </p>
            </div>

            <!-- Card 6 -->
            <div class="card">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-purple-700 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Seni &amp; Budaya</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan kreativitas dan apresiasi seni melalui berbagai kegiatan seni pertunjukan dan seni rupa.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas -->
<section id="fasilitas" class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Sarana Prasarana</span>
            <h2 class="section-title mx-auto max-w-2xl">Fasilitas &amp; Sarana</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Dilengkapi dengan fasilitas modern untuk mendukung proses pembelajaran yang optimal
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Fasilitas 1 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-blue-900 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Ruang Kelas Modern</h3>
                <p class="text-xs sm:text-sm text-gray-600">Dilengkapi dengan AC, proyektor, dan teknologi pembelajaran terkini</p>
            </div>

            <!-- Fasilitas 2 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-cyan-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5m4.75-11.396c.251.023.501.05.75.082m0 0a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Laboratorium Lengkap</h3>
                <p class="text-xs sm:text-sm text-gray-600">Lab Fisika, Kimia, Biologi, dan Komputer yang berstandar internasional</p>
            </div>

            <!-- Fasilitas 3 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-emerald-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Perpustakaan Digital</h3>
                <p class="text-xs sm:text-sm text-gray-600">Koleksi buku fisik dan digital dengan sistem manajemen modern</p>
            </div>

            <!-- Fasilitas 4 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-amber-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a15 15 0 000 18m0-18a15 15 0 010 18M3.6 9h16.8M3.6 15h16.8" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Lapangan Olahraga</h3>
                <p class="text-xs sm:text-sm text-gray-600">Lapangan basket, voli, dan futsal dengan kondisi standar kompetisi</p>
            </div>

            <!-- Fasilitas 5 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-rose-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.75L6.75 12 9 14.25m6-4.5L17.25 12 15 14.25m-3-6l-1.5 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5h15a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5h-15A1.5 1.5 0 003 6v12a1.5 1.5 0 001.5 1.5z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Aula &amp; Studio</h3>
                <p class="text-xs sm:text-sm text-gray-600">Aula serbaguna, studio musik, dan ruang seni untuk berbagai kegiatan</p>
            </div>

            <!-- Fasilitas 6 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-purple-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5M3 6.75h18M3 6.75a1.5 1.5 0 011.5-1.5h15A1.5 1.5 0 0121 6.75m-18 0v10.5A1.5 1.5 0 004.5 18.75h15a1.5 1.5 0 001.5-1.5V6.75" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Kantin &amp; Koperasi</h3>
                <p class="text-xs sm:text-sm text-gray-600">Kantin dengan menu sehat dan koperasi untuk kebutuhan siswa</p>
            </div>

            <!-- Fasilitas 7 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-red-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">Ruang Kesehatan</h3>
                <p class="text-xs sm:text-sm text-gray-600">Ruang UKS dengan peralatan kesehatan untuk penanganan darurat</p>
            </div>

            <!-- Fasilitas 8 -->
            <div class="bg-white rounded-xl p-5 sm:p-6 text-center shadow-sm hover:shadow-lg transition-shadow border border-gray-100">
                <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-indigo-700 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856a9.75 9.75 0 0113.788 0M1.924 8.674a14.25 14.25 0 0120.152 0M12 18.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1 text-sm sm:text-base">WiFi &amp; Internet</h3>
                <p class="text-xs sm:text-sm text-gray-600">Koneksi WiFi gratis di seluruh area sekolah untuk pembelajaran digital</p>
            </div>
        </div>
    </div>
</section>

<!-- Lokasi -->
<section id="lokasi" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kunjungi Kami</span>
            <h2 class="section-title mx-auto max-w-2xl">Lokasi Sekolah</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Temukan kami di lokasi yang strategis dan mudah dijangkau
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-10 items-stretch">
            <!-- Peta -->
            <div class="lg:col-span-3 rounded-2xl overflow-hidden shadow-lg border border-gray-100 min-h-[300px] sm:min-h-[380px] lg:min-h-full">
                <iframe
                    src="https://www.google.com/maps?q=SMA+Negeri+1+Medan&output=embed"
                    class="w-full h-full min-h-[300px] sm:min-h-[380px] lg:min-h-full"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi SMA Negeri 1 Medan">
                </iframe>
            </div>

            <!-- Info Kontak -->
            <div class="lg:col-span-2 flex flex-col gap-4">
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-blue-900 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Alamat</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">Jl. Teladan No. 17, Kecamatan Medan Kota, Kota Medan, Sumatera Utara, Indonesia</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-cyan-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                        <p class="text-sm text-gray-600">(061) 123-4567</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                        <p class="text-sm text-gray-600">info@sman1medan.sch.id</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Jam Operasional</h4>
                        <p class="text-sm text-gray-600">Senin - Jumat, 07.00 - 16.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 28px 28px;"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white relative z-10">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">Siap Bergabung Bersama Kami?</h2>
        <p class="text-base sm:text-lg md:text-xl mb-8 text-blue-100">
            Daftarkan dirimu sekarang dan jadilah bagian dari keluarga besar SMA Negeri 1 Medan
        </p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection