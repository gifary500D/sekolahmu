@extends('layouts.app')

@section('title', 'Fasilitas')

@section('content')
<!-- Hero Section -->
<section class="py-12 sm:py-16 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Fasilitas & Sarana</h1>
        <p class="text-lg text-blue-100 max-w-2xl mx-auto">Lengkap dengan fasilitas modern untuk mendukung pembelajaran optimal</p>
    </div>
</section>

<!-- Facilities Grid Section -->
<section class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <!-- Ruang Kelas Modern -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1427504494785-cdcdfeabc846?w=500&h=300&fit=crop" alt="Ruang Kelas" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">Ruang Kelas Modern</h3>
                    <p class="text-gray-600 mb-4">Dilengkapi dengan sistem AC, proyektor interaktif, smart board, dan koneksi internet berkecepatan tinggi untuk pembelajaran digital.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-blue-600">✓</span> AC dan pencahayaan LED</li>
                        <li class="flex gap-2"><span class="text-blue-600">✓</span> Smart board interaktif</li>
                        <li class="flex gap-2"><span class="text-blue-600">✓</span> WiFi gratis</li>
                    </ul>
                </div>
            </div>

            <!-- Laboratorium -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=500&h=300&fit=crop" alt="Laboratorium" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors">Laboratorium Lengkap</h3>
                    <p class="text-gray-600 mb-4">Dilengkapi peralatan laboratorium berstandar internasional untuk praktikum fisika, kimia, biologi, dan komputer.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-green-600">✓</span> Lab Fisika, Kimia, Biologi</li>
                        <li class="flex gap-2"><span class="text-green-600">✓</span> Peralatan standar internasional</li>
                        <li class="flex gap-2"><span class="text-green-600">✓</span> Lab Komputer dengan 30 unit PC</li>
                    </ul>
                </div>
            </div>

            <!-- Perpustakaan -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-amber-400 to-amber-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507842217343-583f7270bfba?w=500&h=300&fit=crop" alt="Perpustakaan" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-600 transition-colors">Perpustakaan Digital</h3>
                    <p class="text-gray-600 mb-4">Koleksi buku fisik dan digital dengan sistem manajemen modern serta akses ke basis data jurnal internasional.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-amber-600">✓</span> 5000+ koleksi buku</li>
                        <li class="flex gap-2"><span class="text-amber-600">✓</span> Akses e-book dan jurnal</li>
                        <li class="flex gap-2"><span class="text-amber-600">✓</span> Ruang baca nyaman</li>
                    </ul>
                </div>
            </div>

            <!-- Lapangan Olahraga -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-red-400 to-red-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=500&h=300&fit=crop" alt="Lapangan" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-red-600 transition-colors">Lapangan Olahraga</h3>
                    <p class="text-gray-600 mb-4">Dengan standar kompetisi internasional meliputi lapangan basket, voli, futsal, dan lintasan atletik lengkap.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-red-600">✓</span> Lapangan basket & voli</li>
                        <li class="flex gap-2"><span class="text-red-600">✓</span> Lapangan futsal indoor</li>
                        <li class="flex gap-2"><span class="text-red-600">✓</span> Lintasan atletik 400m</li>
                    </ul>
                </div>
            </div>

            <!-- Aula & Studio -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?w=500&h=300&fit=crop" alt="Aula" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors">Aula & Studio</h3>
                    <p class="text-gray-600 mb-4">Aula serbaguna dengan kapasitas 500 orang, studio musik, dan ruang seni untuk berbagai kegiatan ekstrakurikuler.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-purple-600">✓</span> Aula 500 kapasitas</li>
                        <li class="flex gap-2"><span class="text-purple-600">✓</span> Studio musik bersuara</li>
                        <li class="flex gap-2"><span class="text-purple-600">✓</span> Ruang seni dan teater</li>
                    </ul>
                </div>
            </div>

            <!-- Kantin & Koperasi -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-2xl transition-all duration-300 group">
                <div class="h-48 bg-gradient-to-br from-indigo-400 to-indigo-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500&h=300&fit=crop" alt="Kantin" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">Kantin & Koperasi</h3>
                    <p class="text-gray-600 mb-4">Kantin dengan menu sehat dan bergizi, serta koperasi sekolah untuk pemenuhan kebutuhan sehari-hari siswa.</p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex gap-2"><span class="text-indigo-600">✓</span> Menu sehat & higienis</li>
                        <li class="flex gap-2"><span class="text-indigo-600">✓</span> Harga terjangkau</li>
                        <li class="flex gap-2"><span class="text-indigo-600">✓</span> Koperasi lengkap</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Additional Facilities -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl p-6 border border-rose-200 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-lg bg-rose-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Ruang Kesehatan UKS</h3>
                <p class="text-sm text-gray-600">Dilengkapi dengan peralatan kesehatan lengkap dan perawat untuk penanganan darurat.</p>
            </div>

            <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-lg bg-cyan-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856a9.75 9.75 0 0113.788 0M1.924 8.674a14.25 14.25 0 0120.152 0M12 18.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">WiFi & Internet</h3>
                <p class="text-sm text-gray-600">Koneksi WiFi gratis dan internet berkecepatan tinggi di seluruh area sekolah.</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200 hover:shadow-lg transition-all duration-300 group">
                <div class="w-12 h-12 rounded-lg bg-emerald-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Sistem Keamanan</h3>
                <p class="text-sm text-gray-600">Sistem CCTV dan keamanan 24 jam untuk menjaga keselamatan siswa dan aset sekolah.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Summary -->
<section class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Komitmen Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Menyediakan lingkungan belajar yang aman, nyaman, dan mendukung pengembangan potensi siswa secara maksimal</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-900 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Fasilitas Berkualitas Tinggi</h3>
                    <p class="text-gray-600">Semua fasilitas dirawat dengan baik dan terus diupgrade mengikuti perkembangan teknologi pendidikan terkini.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-900 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Akses yang Luas</h3>
                    <p class="text-gray-600">Semua siswa dapat mengakses fasilitas sekolah selama jam belajar dan kegiatan ekstrakurikuler.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-900 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Keselamatan Terjamin</h3>
                    <p class="text-gray-600">Dilengkapi dengan sistem keamanan modern dan penuh perhatian terhadap kesejahteraan siswa.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-900 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Inovasi Berkelanjutan</h3>
                    <p class="text-gray-600">Terus berinovasi dan mengembangkan fasilitas untuk mendukung pembelajaran abad 21.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Rasakan Pengalaman Belajar Terbaik</h2>
        <p class="text-lg text-blue-100 mb-8">Bergabunglah dengan ribuan siswa yang telah merasakan manfaat fasilitas berkualitas kami</p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection