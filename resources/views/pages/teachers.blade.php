@extends('layouts.app')

@section('title', 'Tenaga Pengajar')

@section('content')
<!-- Hero Section -->
<section class="py-12 sm:py-16 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Tenaga Pengajar Profesional</h1>
        <p class="text-lg text-blue-100 max-w-2xl mx-auto">Tim guru berpengalaman dan berdedikasi tinggi untuk mendidik generasi muda</p>
    </div>
</section>

<!-- Teachers Grid Section -->
<section class="py-16 sm:py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Teacher Card 1 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-blue-400 to-blue-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1494783367193-149034c05e41?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-950/60 text-blue-900 dark:text-blue-300 rounded-full text-xs font-bold mb-3">Matematika</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Drs. Ahmad Fauzi, M.M</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Pendidik berpengalaman lebih dari 20 tahun di bidang matematika. Spesialis dalam pembelajaran inovatif dan problem-solving.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Sertifikasi Internasional</span>
                    </div>
                </div>
            </div>

            <!-- Teacher Card 2 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-green-400 to-green-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-green-100 dark:bg-emerald-950/60 text-green-900 dark:text-emerald-300 rounded-full text-xs font-bold mb-3">Fisika</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ibu Sari Dewi, M.Si</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Ahli dalam pembelajaran sains eksperimental. Rutin mengikuti workshop internasional untuk pengembangan metode pengajaran.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Peneliti Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Teacher Card 3 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-amber-400 to-amber-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-900 dark:text-amber-300 rounded-full text-xs font-bold mb-3">Bahasa Inggris</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Bpk. Reza Pratama, M.Hum</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Pendidik bahasa asing dengan pengalaman mengajar di luar negeri. Fokus pada pengembangan komunikasi yang efektif.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Native Speaker</span>
                    </div>
                </div>
            </div>

            <!-- Teacher Card 4 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-red-400 to-red-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-950/60 text-red-900 dark:text-red-300 rounded-full text-xs font-bold mb-3">Kimia</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Ibu Nur Aisyah, M.Sc</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Spesialis dalam kimia organik dan analitik dengan praktik laboratorium yang mendalam. Mentor pemenang olimpiade kimia nasional.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Pelatih Olimpiade</span>
                    </div>
                </div>
            </div>

            <!-- Teacher Card 5 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-950/60 text-purple-900 dark:text-purple-300 rounded-full text-xs font-bold mb-3">Biologi</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Bpk. Hendra Gunawan, M.Pd</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Pendidik biologi dengan konsentrasi pada pembelajaran kontekstual dan lingkungan. Aktif dalam program konservasi alam.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Konservasionalis</span>
                    </div>
                </div>
            </div>

            <!-- Teacher Card 6 -->
            <div class="bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-gray-200 dark:border-slate-800 hover:shadow-2xl transition-all duration-300 group">
                <div class="relative h-64 bg-gradient-to-br from-cyan-400 to-cyan-600 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1494783367193-149034c05e41?w=400&h=500&fit=crop" alt="Teacher" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                </div>
                <div class="p-6">
                    <span class="inline-block px-3 py-1 bg-cyan-100 dark:bg-cyan-950/60 text-cyan-900 dark:text-cyan-300 rounded-full text-xs font-bold mb-3">Sejarah</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Bpk. Bambang Sutrisno, M.Hum</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-sm mb-4">
                        Historiawan dengan minat pada sejarah lokal dan nasional. Mengintegrasikan teknologi digital dalam pembelajaran sejarah.
                    </p>
                    <div class="flex gap-2">
                        <span class="text-xs bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 px-3 py-1 rounded-full">Penulis Buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 sm:py-20 bg-gray-50 dark:bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Statistik Tenaga Pengajar</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-800">
                <div class="text-5xl font-bold text-blue-900 dark:text-blue-400 mb-3">100+</div>
                <p class="text-gray-600 dark:text-slate-400 text-lg font-semibold">Total Guru</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-800">
                <div class="text-5xl font-bold text-green-900 dark:text-emerald-400 mb-3">95%</div>
                <p class="text-gray-600 dark:text-slate-400 text-lg font-semibold">Bersertifikat S2+</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-800">
                <div class="text-5xl font-bold text-purple-900 dark:text-purple-400 mb-3">25+</div>
                <p class="text-gray-600 dark:text-slate-400 text-lg font-semibold">Tahun Pengalaman Rata-rata</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-xl p-8 text-center hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-slate-800">
                <div class="text-5xl font-bold text-amber-600 dark:text-amber-400 mb-3">50+</div>
                <p class="text-gray-600 dark:text-slate-400 text-lg font-semibold">Penghargaan Nasional</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 sm:py-20 bg-gradient-to-br from-blue-950 via-blue-900 to-indigo-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Belajar Bersama Guru Terbaik</h2>
        <p class="text-lg text-blue-100 mb-8">Dapatkan pendidikan berkualitas dari tenaga pendidik yang berpengalaman dan berdedikasi</p>
        <a href="/daftar" class="inline-block bg-amber-400 text-blue-950 px-10 py-4 rounded-lg font-bold hover:bg-amber-300 transition-all duration-300 hover:shadow-xl hover:shadow-amber-400/30">
            Daftar Sekarang
        </a>
    </div>
</section>
@endsection