@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<!-- Hero Section -->
<section class="py-12 sm:py-16 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang SMA Pemda Bahorok</h1>
        <p class="text-lg text-blue-100 max-w-2xl mx-auto">Mengenal lebih jauh tentang institusi pendidikan terkemuka kami</p>
    </div>
</section>

<!-- Content Section -->
<section class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Visi & Misi</h2>
                
                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-amber-500 mb-4">Visi</h3>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Menjadi sekolah menengah atas unggul yang menghasilkan peserta didik berkarakter, cerdas, 
                        kreatif, dan berdaya saing tinggi di tingkat nasional maupun internasional.
                    </p>
                </div>

                <div class="mb-10">
                    <h3 class="text-2xl font-semibold text-amber-500 mb-4">Misi</h3>
                    <ul class="space-y-4">
                        <li class="flex gap-4 group">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-400 text-blue-950 flex items-center justify-center font-bold text-sm group-hover:scale-110 transition-transform">1</span>
                            <span class="text-gray-700 text-lg">Menyelenggarakan pendidikan berkualitas tinggi yang mengintegrasikan nilai-nilai keagamaan dan kebangsaan</span>
                        </li>
                        <li class="flex gap-4 group">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-400 text-blue-950 flex items-center justify-center font-bold text-sm group-hover:scale-110 transition-transform">2</span>
                            <span class="text-gray-700 text-lg">Mengembangkan potensi peserta didik secara optimal melalui pembelajaran inovatif dan berbasis teknologi</span>
                        </li>
                        <li class="flex gap-4 group">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-400 text-blue-950 flex items-center justify-center font-bold text-sm group-hover:scale-110 transition-transform">3</span>
                            <span class="text-gray-700 text-lg">Membangun budaya sekolah yang inklusif, demokratis, dan berorientasi pada keunggulan</span>
                        </li>
                        <li class="flex gap-4 group">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-400 text-blue-950 flex items-center justify-center font-bold text-sm group-hover:scale-110 transition-transform">4</span>
                            <span class="text-gray-700 text-lg">Mempersiapkan peserta didik untuk menjadi warga negara yang bertanggung jawab dan berdaya saing global</span>
                        </li>
                    </ul>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-6 mt-12">Sejarah Singkat</h2>
                <div class="prose max-w-none text-gray-700">
                    <p class="mb-4">
                        SMA Pemda Bahorok didirikan sebagai salah satu institusi pendidikan terkemuka di Bahorok, Langkat. 
                        Dengan dedikasi dan pengalaman, sekolah kami telah mencetak ribuan alumni yang sukses dan berpengaruh di berbagai bidang.
                    </p>
                    <p class="mb-4">
                        Perjalanan kami dimulai dengan dedikasi para pendiri dan pengajar yang percaya pada kekuatan pendidikan dalam mengubah 
                        kehidupan generasi muda. Hingga kini, komitmen kami terhadap keunggulan akademik dan pembentukan karakter tetap menjadi 
                        fondasi utama dalam setiap kegiatan pembelajaran.
                    </p>
                    <p>
                        Dengan berbagai penghargaan dan prestasi yang telah diraih, SMA Pemda Bahorok terus berinovasi dan berkembang untuk 
                        memenuhi standar pendidikan unggul dan kebutuhan zaman.
                    </p>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div>
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 rounded-2xl p-8 text-white sticky top-20">
                    <h3 class="text-2xl font-bold mb-6">Informasi Penting</h3>
                    
                    <div class="space-y-6">
                        <div class="pb-6 border-b border-white/20">
                            <p class="text-amber-300 font-semibold text-sm uppercase tracking-wide mb-2">Berdiri Sejak</p>
                            <p class="text-3xl font-bold">1973</p>
                        </div>

                        <div class="pb-6 border-b border-white/20">
                            <p class="text-amber-300 font-semibold text-sm uppercase tracking-wide mb-2">Jumlah Siswa</p>
                            <p class="text-3xl font-bold">1000+</p>
                        </div>

                        <div class="pb-6 border-b border-white/20">
                            <p class="text-amber-300 font-semibold text-sm uppercase tracking-wide mb-2">Tenaga Pengajar</p>
                            <p class="text-3xl font-bold">100+</p>
                        </div>

                        <div>
                            <p class="text-amber-300 font-semibold text-sm uppercase tracking-wide mb-2">Tingkat Kelulusan</p>
                            <p class="text-3xl font-bold">95%</p>
                        </div>
                    </div>

                    <a href="/daftar" class="block mt-8 w-full bg-amber-400 text-blue-950 py-3 rounded-lg font-bold text-center hover:bg-amber-300 transition-all duration-300 hover:shadow-lg">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 sm:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Nilai-Nilai Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Prinsip-prinsip yang kami pegang teguh dalam setiap aspek pendidikan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="w-16 h-16 rounded-full bg-blue-100 mx-auto mb-6 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-8 h-8 text-blue-900 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-500 transition-colors">Integritas</h3>
                <p class="text-gray-600">Menjunjung tinggi nilai-nilai kejujuran dan kebenaran dalam setiap tindakan</p>
            </div>

            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="w-16 h-16 rounded-full bg-green-100 mx-auto mb-6 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-8 h-8 text-green-900 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-500 transition-colors">Keunggulan</h3>
                <p class="text-gray-600">Berupaya maksimal untuk mencapai standar tertinggi dalam segala hal</p>
            </div>

            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="w-16 h-16 rounded-full bg-purple-100 mx-auto mb-6 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-8 h-8 text-purple-900 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 19H9a6 6 0 016-6v0a6 6 0 016 6v0h-6z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-500 transition-colors">Kebersamaan</h3>
                <p class="text-gray-600">Membangun lingkungan yang solid, inklusif, dan saling mendukung</p>
            </div>

            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 group border border-gray-100">
                <div class="w-16 h-16 rounded-full bg-rose-100 mx-auto mb-6 flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-8 h-8 text-rose-900 group-hover:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-500 transition-colors">Inovasi</h3>
                <p class="text-gray-600">Terus berinovasi dan beradaptasi dengan perkembangan zaman</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ingin Bergabung Dengan Kami?</h2>
        <p class="text-lg text-blue-100 mb-8">Daftarkan diri Anda dan menjadi bagian dari keluarga besar SMA Pemda Bahorok</p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection