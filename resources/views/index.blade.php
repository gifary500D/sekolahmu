@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 min-h-screen flex items-center overflow-hidden">
    <!-- Background Decoration -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full -ml-36 -mb-36"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="text-white">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Selamat Datang di SMA Negeri 1 Medan
                </h1>
                <p class="text-lg md:text-xl mb-8 text-blue-100">
                    Membangun generasi muda yang berkarakter, cerdas, dan berdaya saing global.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/daftar" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition-all duration-300 text-center hover:shadow-lg">
                        Daftar Sekarang
                    </a>
                    <a href="#tentang" class="border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white/20 transition-all duration-300 text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <!-- Illustration -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-3xl blur-3xl"></div>
                    <div class="relative bg-gradient-to-br from-white/30 to-white/10 rounded-3xl p-8 backdrop-blur-md border border-white/30">
                        <svg class="w-full h-auto" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Gedung Sekolah -->
                            <rect x="50" y="100" width="200" height="150" fill="white" opacity="0.9"/>
                            <rect x="50" y="100" width="200" height="20" fill="#1E40AF"/>
                            <!-- Windows -->
                            <rect x="70" y="130" width="25" height="25" fill="#1E40AF"/>
                            <rect x="110" y="130" width="25" height="25" fill="#1E40AF"/>
                            <rect x="150" y="130" width="25" height="25" fill="#1E40AF"/>
                            <rect x="190" y="130" width="25" height="25" fill="#1E40AF"/>
                            <rect x="70" y="170" width="25" height="25" fill="#1E40AF"/>
                            <rect x="110" y="170" width="25" height="25" fill="#1E40AF"/>
                            <rect x="150" y="170" width="25" height="25" fill="#1E40AF"/>
                            <rect x="190" y="170" width="25" height="25" fill="#1E40AF"/>
                            <!-- Door -->
                            <rect x="135" y="200" width="30" height="50" fill="#1E40AF"/>
                            <!-- Roof -->
                            <polygon points="50,100 150,30 250,100" fill="#0EA5E9"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-20">
            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2">50+</h3>
                <p class="text-blue-100">Tahun Berdiri</p>
            </div>
            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2">1000+</h3>
                <p class="text-blue-100">Siswa Aktif</p>
            </div>
            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-6 text-white text-center">
                <h3 class="text-3xl font-bold mb-2">95%</h3>
                <p class="text-blue-100">Lulus Ujian</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami -->
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div>
                <h2 class="section-title">Tentang Kami</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    SMA Negeri 1 Medan adalah institusi pendidikan terkemuka yang berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan pendekatan holistik. Kami percaya bahwa setiap siswa memiliki potensi unik yang perlu dikembangkan secara optimal.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Dengan fasilitas modern, tenaga pengajar berpengalaman, dan lingkungan belajar yang kondusif, kami siap membentuk generasi pemimpin masa depan yang berakhlak mulia dan berdaya saing tinggi.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-600 text-white">
                                ✓
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Kurikulum Nasional</h4>
                            <p class="text-gray-600">Mengikuti standar kurikulum nasional terbaru</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-600 text-white">
                                ✓
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Ekstrakurikuler Lengkap</h4>
                            <p class="text-gray-600">Berbagai pilihan kegiatan pengembangan diri</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-md bg-blue-600 text-white">
                                ✓
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
            <div>
                <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl aspect-square flex items-center justify-center text-white">
                    <div class="text-center">
                        <svg class="w-32 h-32 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C6.596 6.253 2 10.849 2 16.5S6.596 26.747 12 26.747s10-4.596 10-10.247S17.404 6.253 12 6.253z" />
                        </svg>
                        <p class="text-xl font-semibold opacity-80">Foto Sekolah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="guru" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title mx-auto max-w-2xl">Tenaga Pengajar</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
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
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
                </div>
            </div>
             <div class="teacher-panel" style="background-image: url('{{ asset('images/guru5.jpg') }}')">
                <div class="teacher-overlay"></div>
                <div class="teacher-info">
                    <span class="teacher-subject">Biologi</span>
                    <span class="teacher-name">Bpk. Hendra Gunawan, M.Pd</span>
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
<section id="program" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title mx-auto max-w-2xl">Program Unggulan Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Kami menawarkan berbagai program pendidikan yang dirancang untuk mengembangkan potensi siswa
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="card">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">📚</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Akademik</h3>
                <p class="text-gray-600 leading-relaxed">
                    Program pembelajaran intensif dengan metode yang inovatif untuk meningkatkan prestasi akademik siswa di semua mata pelajaran.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="card">
                <div class="w-16 h-16 bg-cyan-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">🎯</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IPA</h3>
                <p class="text-gray-600 leading-relaxed">
                    Fokus pada pengembangan kemampuan sains dan matematika dengan pendekatan praktik dan eksperimen langsung di laboratorium.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="card">
                <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">🌍</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IPS</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan pemahaman tentang ilmu sosial, sejarah, dan budaya dengan perspektif global untuk mencetak pemimpin masa depan.
                </p>
            </div>

            <!-- Card 4 -->
            <div class="card">
                <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">🌐</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Bahasa</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pelatihan intensif dalam berbagai bahasa asing untuk meningkatkan kompetensi komunikasi internasional siswa.
                </p>
            </div>

            <!-- Card 5 -->
            <div class="card">
                <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">💻</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program IT</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan keterampilan teknologi informasi untuk mempersiapkan siswa menghadapi era digital dan industri 4.0.
                </p>
            </div>

            <!-- Card 6 -->
            <div class="card">
                <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                    <span class="text-3xl">🎨</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Program Seni & Budaya</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengembangan kreativitas dan apresiasi seni melalui berbagai kegiatan seni pertunjukan dan seni rupa.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas -->
<section id="fasilitas" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title mx-auto max-w-2xl">Fasilitas & Sarana</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Dilengkapi dengan fasilitas modern untuk mendukung proses pembelajaran yang optimal
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Fasilitas 1 -->
            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">🏫</div>
                <h3 class="font-semibold text-gray-900 mb-2">Ruang Kelas Modern</h3>
                <p class="text-sm text-gray-600">Dilengkapi dengan AC, proyektor, dan teknologi pembelajaran terkini</p>
            </div>

            <!-- Fasilitas 2 -->
            <div class="bg-gradient-to-br from-cyan-100 to-cyan-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">🔬</div>
                <h3 class="font-semibold text-gray-900 mb-2">Laboratorium Lengkap</h3>
                <p class="text-sm text-gray-600">Lab Fisika, Kimia, Biologi, dan Komputer yang berstandar internasional</p>
            </div>

            <!-- Fasilitas 3 -->
            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">📚</div>
                <h3 class="font-semibold text-gray-900 mb-2">Perpustakaan Digital</h3>
                <p class="text-sm text-gray-600">Koleksi buku fisik dan digital dengan sistem manajemen modern</p>
            </div>

            <!-- Fasilitas 4 -->
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">⚽</div>
                <h3 class="font-semibold text-gray-900 mb-2">Lapangan Olahraga</h3>
                <p class="text-sm text-gray-600">Lapangan basket, voli, dan futsal dengan kondisi standar kompetisi</p>
            </div>

            <!-- Fasilitas 5 -->
            <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">🎭</div>
                <h3 class="font-semibold text-gray-900 mb-2">Aula & Studio</h3>
                <p class="text-sm text-gray-600">Aula serbaguna, studio musik, dan ruang seni untuk berbagai kegiatan</p>
            </div>

            <!-- Fasilitas 6 -->
            <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">🍴</div>
                <h3 class="font-semibold text-gray-900 mb-2">Kantin & Koperasi</h3>
                <p class="text-sm text-gray-600">Kantin dengan menu sehat dan koperasi untuk kebutuhan siswa</p>
            </div>

            <!-- Fasilitas 7 -->
            <div class="bg-gradient-to-br from-pink-100 to-pink-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">🏥</div>
                <h3 class="font-semibold text-gray-900 mb-2">Ruang Kesehatan</h3>
                <p class="text-sm text-gray-600">Ruang UKS dengan peralatan kesehatan untuk penanganan darurat</p>
            </div>

            <!-- Fasilitas 8 -->
            <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="text-4xl mb-3">📱</div>
                <h3 class="font-semibold text-gray-900 mb-2">WiFi & Internet</h3>
                <p class="text-sm text-gray-600">Koneksi WiFi gratis di seluruh area sekolah untuk pembelajaran digital</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-cyan-500">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Bergabung Bersama Kami?</h2>
        <p class="text-lg md:text-xl mb-8 text-blue-100">
            Daftarkan dirimu sekarang dan jadilah bagian dari keluarga besar SMA Negeri 1 Medan
        </p>
        <a href="/daftar" class="inline-block bg-white text-blue-600 px-10 py-4 rounded-lg font-bold hover:bg-blue-50 transition-all duration-300 hover:shadow-xl">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection