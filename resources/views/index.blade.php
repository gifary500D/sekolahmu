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
                    Selamat Datang di <span class="text-amber-300">SMA Pemda Bahorok</span>
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
                    SMA Pemda Bahorok adalah institusi pendidikan terkemuka di Kabupaten Langkat yang berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan pendekatan holistik. Kami percaya bahwa setiap siswa memiliki potensi unik yang perlu dikembangkan secara optimal.
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
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 relative group">
                    <img 
                        src="https://images.unsplash.com/photo-1591123120675-6f7f1aae0e5b?q=80&w=1738&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=NHwxMjA3fDA%3D" 
                        alt="Gedung SMA Pemda Bahorok" 
                        class="w-full h-[380px] sm:h-[420px] object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent flex items-end p-6">
                        <div class="text-white">
                            <span class="text-xs font-semibold uppercase tracking-wider text-amber-300">Kampus Utama</span>
                            <h3 class="text-lg font-bold">Gedung Pembelajaran Terpadu</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tenaga Pengajar -->
<section id="guru" class="py-16 sm:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Pendidik Profesional</span>
            <h2 class="section-title mx-auto max-w-2xl">Tenaga Pengajar</h2>
            <p class="text-slate-600 text-base sm:text-lg max-w-2xl mx-auto">
                Daftar dewan guru dan staf pengajar berdedikasi tinggi di SMA Pemda Bahorok
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase text-xs tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">Nama Guru &amp; Gelar</th>
                            <th class="py-4 px-6">Bidang / Mata Pelajaran</th>
                            <th class="py-4 px-6">Jabatan / Tugas</th>
                            <th class="py-4 px-6">Kualifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">1</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Ibu Dr. Hj. Nurul Hidayah, M.Pd.</td>
                            <td class="py-4 px-6">Manajemen Pendidikan</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-blue-50 text-blue-800 text-xs font-semibold">Kepala Sekolah</span></td>
                            <td class="py-4 px-6 text-slate-600">S3 Manajemen Pendidikan</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">2</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Drs. Ahmad Fauzi, M.M.</td>
                            <td class="py-4 px-6">Matematika</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 text-xs font-semibold">Wakasek Kurikulum</span></td>
                            <td class="py-4 px-6 text-slate-600">S2 Magister Manajemen</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">3</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Ibu Sari Dewi, M.Si.</td>
                            <td class="py-4 px-6">Fisika / Sains</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Guru Mata Pelajaran</span></td>
                            <td class="py-4 px-6 text-slate-600">S2 Fisika Murni</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">4</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Bpk. Reza Pratama, M.Hum.</td>
                            <td class="py-4 px-6">Bahasa Inggris</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Pembina Bahasa</span></td>
                            <td class="py-4 px-6 text-slate-600">S2 Linguistik</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">5</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Ibu Nur Aisyah, M.Sc.</td>
                            <td class="py-4 px-6">Kimia</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Kepala Laboratorium</span></td>
                            <td class="py-4 px-6 text-slate-600">S2 Kimia Analitik</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">6</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Bpk. Hendra Gunawan, M.Pd.</td>
                            <td class="py-4 px-6">Biologi</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Pembina KIR</span></td>
                            <td class="py-4 px-6 text-slate-600">S2 Pendidikan Biologi</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">7</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Bpk. Dedi Kurniawan, S.Pd.</td>
                            <td class="py-4 px-6">Sejarah &amp; IPS</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Wali Kelas XI IPS 2</span></td>
                            <td class="py-4 px-6 text-slate-600">S1 Pendidikan Sejarah</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">8</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Ibu Rina Kartika, S.Pd.</td>
                            <td class="py-4 px-6">Matematika</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Wali Kelas X IPA 1</span></td>
                            <td class="py-4 px-6 text-slate-600">S1 Pendidikan Matematika</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 text-center font-medium text-slate-500">9</td>
                            <td class="py-4 px-6 font-semibold text-slate-900">Bpk. Arif Nugroho, S.Pd.</td>
                            <td class="py-4 px-6">PJOK &amp; Kesehatan</td>
                            <td class="py-4 px-6"><span class="px-2.5 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">Pembina Olahraga</span></td>
                            <td class="py-4 px-6 text-slate-600">S1 Pendidikan Olahraga</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Program Unggulan -->
<section id="program" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kurikulum</span>
            <h2 class="section-title mx-auto max-w-2xl">Program Unggulan Kami</h2>
            <p class="text-slate-600 text-base sm:text-lg max-w-2xl mx-auto">
                Kami menawarkan berbagai program pendidikan yang dirancang untuk mengembangkan potensi siswa secara holistik
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-blue-900 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program Akademik</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Program pembelajaran intensif dengan metode inovatif untuk meningkatkan prestasi akademik siswa di semua mata pelajaran.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-cyan-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program IPA</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Fokus pada pengembangan kemampuan sains dan matematika dengan pendekatan praktik dan eksperimen laboratorium.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-emerald-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a14.5 14.5 0 010 18M12 3a14.5 14.5 0 000 18" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program IPS</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Pengembangan pemahaman ilmu sosial, sejarah, dan budaya dengan perspektif global untuk mencetak pemimpin masa depan.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-amber-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3.75h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m6.334-12.138a48.996 48.996 0 014.166 2.372" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program Bahasa</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Pelatihan intensif dalam berbagai bahasa asing untuk meningkatkan kompetensi komunikasi internasional siswa.
                </p>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-rose-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program IT</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Pengembangan keterampilan teknologi informasi untuk mempersiapkan siswa menghadapi era digital dan industri 4.0.
                </p>
            </div>

            <!-- Card 6 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                <div class="w-14 h-14 bg-indigo-700 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Program Seni &amp; Budaya</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Pengembangan kreativitas dan apresiasi seni melalui berbagai kegiatan seni pertunjukan dan seni rupa daerah maupun nasional.
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Fasilitas 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=600&auto=format&fit=crop" alt="Ruang Kelas Modern" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Ruang Kelas Modern</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Dilengkapi dengan AC, proyektor, dan teknologi pembelajaran terkini.</p>
                </div>
            </div>

            <!-- Fasilitas 2 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=600&auto=format&fit=crop" alt="Laboratorium Lengkap" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Laboratorium Lengkap</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Lab Fisika, Kimia, Biologi, dan Komputer berstandar internasional.</p>
                </div>
            </div>

            <!-- Fasilitas 3 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=600&auto=format&fit=crop" alt="Perpustakaan Digital" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Perpustakaan Digital</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Koleksi buku fisik dan digital dengan sistem manajemen modern.</p>
                </div>
            </div>

            <!-- Fasilitas 4 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1576267423445-b2e0074d68a4?q=80&w=600&auto=format&fit=crop" alt="Lapangan Olahraga" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Lapangan Olahraga</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Lapangan basket, voli, dan futsal dengan standar kompetisi.</p>
                </div>
            </div>

            <!-- Fasilitas 5 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=600&auto=format&fit=crop" alt="Aula & Studio" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Aula &amp; Studio</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Aula serbaguna, studio musik, dan ruang seni untuk pengembangan bakat.</p>
                </div>
            </div>

            <!-- Fasilitas 6 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=600&auto=format&fit=crop" alt="Kantin & Koperasi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Kantin &amp; Koperasi</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Kantin dengan menu sehat dan koperasi untuk kebutuhan harian siswa.</p>
                </div>
            </div>

            <!-- Fasilitas 7 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=600&auto=format&fit=crop" alt="Ruang Kesehatan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">Ruang Kesehatan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Ruang UKS lengkap untuk penanganan pertolongan pertama darurat.</p>
                </div>
            </div>

            <!-- Fasilitas 8 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-slate-200 group">
                <div class="h-40 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=600&auto=format&fit=crop" alt="WiFi & Internet" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-900 mb-1 text-base">WiFi &amp; Internet</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Koneksi internet berkecepatan tinggi di seluruh area lingkungan sekolah.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <!-- Berita & Pengumuman -->
<section id="berita" class="py-16 sm:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Informasi Terbaru</span>
            <h2 class="section-title mx-auto max-w-2xl">Berita &amp; Pengumuman Sekolah</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Ikuti perkembangan, artikel, dan informasi resmi seputar kegiatan akademik SMA Pemda Bahorok
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($berita ?? [] as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col">
                    <img 
                        src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1000&auto=format&fit=crop' }}" 
                        alt="{{ $item->judul }}" 
                        class="w-full h-48 object-cover"
                    >
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">{{ $item->created_at->format('d M Y') }}</span>
                            <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $item->judul }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $item->konten }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Unsplash Mock Berita jika database kosong -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1000&auto=format&fit=crop" alt="Berita 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">18 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">Upacara Peringatan Hari Sumpah Pemuda</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">Siswa-siswi SMA Pemda Bahorok mengikuti upacara dengan khidmat mengenakan pakaian adat Nusantara.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop" alt="Berita 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">15 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">Pelatihan Literasi Digital &amp; Coding Dasar</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">Laboratorium komputer sekolah mengadakan pelatihan dasar pemrograman web untuk siswa kelas XI.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=1000&auto=format&fit=crop" alt="Berita 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">10 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">Juara Umum Olimpiade Sains Kabupaten</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">Tim Olimpiade Biologi dan Matematika berhasil membawa pulang piala juara umum tingkat kabupaten.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Agenda Kegiatan -->
<section id="agenda" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-500 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Kalender Akademik</span>
            <h2 class="section-title mx-auto max-w-2xl">Agenda Kegiatan Sekolah</h2>
            <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">
                Catat tanggal penting dan jadwal kegiatan ekstrakurikuler serta ujian mendatang
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($agenda ?? [] as $ag)
                <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-between">
                    <div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-lg text-xs font-bold inline-block mb-3">
                            {{ \Carbon\Carbon::parse($ag->tanggal)->format('d M Y') }}
                        </span>
                        <h3 class="font-bold text-slate-900 text-base mb-2">{{ $ag->judul }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $ag->deskripsi ?? 'Kegiatan resmi sekolah.' }}</p>
                    </div>
                </div>
            @empty
                <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold inline-block mb-3">25 Okt 2026</span>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Ujian Tengah Semester (UTS)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pelaksanaan UTS Genap seluruh tingkat kelas X, XI, dan XII.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-xs font-bold inline-block mb-3">02 Nov 2026</span>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Pekan Olahraga Antar Kelas (Classmeeting)</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pertandingan persahabatan futsal, basket, dan bulu tangkis.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50">
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-lg text-xs font-bold inline-block mb-3">15 Nov 2026</span>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Pameran Karya Seni Siswa</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Pameran seni rupa dan prakarya hasil praktik siswa seni budaya.</p>
                </div>
                <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50">
                    <span class="px-3 py-1 bg-rose-100 text-rose-800 rounded-lg text-xs font-bold inline-block mb-3">30 Nov 2026</span>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Rapat Pleno Orang Tua Siswa</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Sosialisasi program semester dan laporan perkembangan akademik.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Galeri Foto -->
<section id="galeri" class="py-16 sm:py-20 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
            <span class="inline-block text-amber-400 font-bold tracking-widest text-xs sm:text-sm uppercase mb-2">Dokumentasi</span>
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">Galeri Foto Kegiatan Sekolah</h2>
            <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto">
                Momen kebersamaan, fasilitas, dan aktivitas belajar mengajar di lingkungan SMA Pemda Bahorok
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galeri ?? [] as $foto)
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img 
                        src="{{ $foto->gambar ? asset('storage/' . $foto->gambar) : 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1000&auto=format&fit=crop' }}" 
                        alt="Galeri Sekolah" 
                        class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">{{ $foto->judul ?? 'Aktivitas Sekolah' }}</p>
                    </div>
                </div>
            @empty
                <!-- Fallback Unsplash Mock Galeri -->
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1000&auto=format&fit=crop" alt="Lab Komputer" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Praktikum Komputer Modern</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1000&auto=format&fit=crop" alt="Perpustakaan" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Suasana Perpustakaan &amp; Ruang Baca</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=1000&auto=format&fit=crop" alt="Laboratorium Sains" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Praktikum Kimia &amp; Biologi</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop" alt="Kegiatan Olahraga" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Lapangan Olahraga &amp; Ekstrakurikuler</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1000&auto=format&fit=crop" alt="Upacara Bendera" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Upacara Bendera Hari Senin</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=1000&auto=format&fit=crop" alt="Diskusi Kelompok" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Diskusi Kelompok &amp; Kolaborasi Siswa</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section> --}}

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
                    src="https://www.google.com/maps?q=Bahorok,+Kabupaten+Langkat,+Sumatera+Utara&output=embed"
                    class="w-full h-full min-h-[300px] sm:min-h-[380px] lg:min-h-full"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi SMA Pemda Bahorok">
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
                        <p class="text-sm text-gray-600 leading-relaxed">Jl. Pendidikan No. 1, Kecamatan Bahorok, Kabupaten Langkat, Sumatera Utara, Indonesia</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-blue-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                        <p class="text-sm text-gray-600">+62 811-1234-5678</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-slate-900 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-1">Email</h4>
                        <p class="text-sm text-gray-600">info@smasmkpemdabahorok.sch.id</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5 sm:p-6 flex items-start gap-4">
                    <div class="flex-shrink-0 w-11 h-11 rounded-lg bg-slate-800 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
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
            Daftarkan dirimu sekarang dan jadilah bagian dari keluarga besar SMA Pemda Bahorok
        </p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection