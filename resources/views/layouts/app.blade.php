<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - SMA Negeri 1 Medan</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="print:hidden bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
 <!-- Logo -->
<div class="flex items-center">
    <a href="/" class="flex items-center group">
        <!-- Logo Button -->
        <button class="relative w-10 h-10 outline-none border-none bg-transparent cursor-pointer flex-shrink-0">
            <!-- Ball belakang -->
            <div class="absolute inset-0 z-10 transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:translate-x-[52px] group-hover:scale-[0.97] group-hover:rotate-[180deg]">
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-700 to-cyan-600 shadow-[inset_-8px_-8px_16px_rgba(0,0,0,0.4),inset_6px_6px_14px_rgba(255,255,255,0.15),0_12px_20px_rgba(30,64,175,0.5)] border border-white/10 overflow-hidden">
                    <div class="absolute top-[8%] left-[10%] w-[65%] h-[35%] rounded-[50%] bg-[linear-gradient(135deg,rgba(255,255,255,0.35)_0%,transparent_100%)] -rotate-[25deg] blur-[1px]"></div>
                    <div class="absolute bottom-[8%] right-[10%] w-[55%] h-[25%] rounded-[50%] bg-[linear-gradient(315deg,rgba(255,255,255,0.15)_0%,transparent_100%)] -rotate-[25deg] blur-[1px]"></div>
                </div>
            </div>
            <!-- Ball depan (glass + foto) -->
            <div class="absolute inset-0 z-20 rounded-full">
                <div class="absolute inset-0 overflow-hidden rounded-full border border-white/30 shadow-[inset_0_1px_1px_rgba(255,255,255,0.3),0_4px_15px_rgba(30,64,175,0.3)] transition-shadow duration-500 group-hover:shadow-[inset_0_1px_1px_rgba(255,255,255,0.5),0_10px_30px_rgba(30,64,175,0.4)]">
                    <!-- Foto logo -->
                    <img src="{{ asset('images/logo-skansa.png') }}" alt="Logo SMAN 1 Medan" class="w-full h-full object-cover">
                    <!-- Glass overlay -->
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.12),rgba(255,255,255,0.01))]"></div>
                    <div class="absolute top-[4px] left-[6px] w-[60%] h-[22%] rounded-full bg-[linear-gradient(to_bottom,rgba(255,255,255,0.45),transparent)] blur-[2px]"></div>
                    <!-- Shimmer -->
                    <div class="absolute -inset-[50%] bg-[linear-gradient(130deg,transparent_40%,rgba(255,255,255,0.4)_50%,transparent_60%)] -translate-x-[150%] rotate-[25deg] transition-transform duration-1000 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:translate-x-[150%]"></div>
                </div>
            </div>
        </button>

        <!-- Teks — geser kanan saat hover biar tidak ketutup ball belakang -->
        <div class="hidden sm:block ml-3 transition-transform duration-700 ease-[cubic-bezier(0.23,1,0.32,1)] group-hover:translate-x-3">
            <h1 class="text-lg font-bold text-gray-900 leading-tight">SMA Negeri 1</h1>
            <p class="text-xs text-gray-500">Medan</p>
        </div>
    </a>
</div>
                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                    <a href="#tentang" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Tentang</a>
                    <a href="#program" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Program</a>
                    <a href="#fasilitas" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fasilitas</a>
                    <a href="/cek-status" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Cek Status</a>
                    <a href="/daftar" class="btn-primary">Daftar Sekarang</a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Menu Mobile -->
            <div id="nav-menu" class="hidden md:hidden pb-4 border-t border-gray-200">
                <a href="/" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium transition-colors">Beranda</a>
                <a href="#tentang" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium transition-colors">Tentang</a>
                <a href="#program" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium transition-colors">Program</a>
                <a href="#fasilitas" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium transition-colors">Fasilitas</a>
                <a href="/cek-status" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg font-medium transition-colors">Cek Status</a>
                <a href="/daftar" class="block mx-4 mt-4 py-2 px-4 btn-primary text-center">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="print:hidden bg-gray-900 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Tentang -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">SMA Negeri 1 Medan</h3>
                    <p class="text-sm leading-relaxed">Sekolah terdepan dalam mengembangkan karakter dan akademik siswa yang berkualitas.</p>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#program" class="hover:text-white transition-colors">Program</a></li>
                        <li><a href="#fasilitas" class="hover:text-white transition-colors">Fasilitas</a></li>
                        <li><a href="/cek-status" class="hover:text-white transition-colors">Cek Status Pendaftaran</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <span class="mr-2 mt-0.5 flex-shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></span>
                            <span>info@sman1medan.sch.id</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 mt-0.5 flex-shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.2l-2.26 1.13a11 11 0 005.52 5.52l1.13-2.26a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg></span>
                            <span>+62 61-1234-5678</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 mt-0.5 flex-shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.66 16.66L13.41 20.9a2 2 0 01-2.82 0l-4.25-4.24a8 8 0 1111.32 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                            <span>Jl. Gajah Mada No. 123, Medan</span>
                        </li>
                    </ul>
                </div>

                <!-- Media Sosial -->
                <div>
                    <h4 class="text-white font-bold mb-4">Media Sosial</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <span class="text-white text-sm">f</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <span class="text-white text-sm">𝕏</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.66-.9l.82-1.2A2 2 0 0110.07 4h3.86a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2024 SMA Negeri 1 Medan. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>