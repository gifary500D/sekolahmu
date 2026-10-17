<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Beranda') - SMA Negeri 1 Medan</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-['Poppins']">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center h-16">

                <!-- LOGO DAN NAMA SEKOLAH -->
                <a href="{{ url('/') }}" class="flex items-center group">

                    <div class="relative w-10 h-10 flex-shrink-0">

                        <!-- Bola belakang -->
                        <div class="absolute inset-0 z-10 rounded-full
                            bg-gradient-to-br from-blue-700 to-cyan-600
                            shadow-lg transition-transform duration-700
                            group-hover:translate-x-10
                            group-hover:rotate-180">
                        </div>

                        <!-- Logo sekolah -->
                        <div class="absolute inset-0 z-20 rounded-full
                            overflow-hidden border border-white/50 shadow-md">

                            <img
                                src="{{ asset('images/logo-skansa.png') }}"
                                alt="Logo SMA Negeri 1 Medan"
                                class="w-full h-full object-cover"
                            >
                        </div>
                    </div>

                    <div class="hidden sm:block ml-3
                        transition-transform duration-700
                        group-hover:translate-x-3">

                        <h1 class="text-lg font-bold text-gray-900 leading-tight">
                            SMA Negeri 1
                        </h1>

                        <p class="text-xs text-gray-500">Medan</p>
                    </div>
                </a>

                <!-- MENU DESKTOP -->
                <div class="hidden md:flex items-center space-x-6">

                    <a href="{{ url('/') }}"
                       class="font-medium transition-colors
                       {{ request()->is('/') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Beranda
                    </a>

                    <a href="{{ url('/tentang') }}"
                       class="font-medium transition-colors
                       {{ request()->is('tentang') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Tentang
                    </a>

                    <a href="{{ url('/berita') }}"
                       class="font-medium transition-colors
                       {{ request()->is('berita*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Berita
                    </a>

                    <a href="{{ url('/guru') }}"
                       class="font-medium transition-colors
                       {{ request()->is('guru') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Guru
                    </a>

                    <a href="{{ url('/fasilitas') }}"
                       class="font-medium transition-colors
                       {{ request()->is('fasilitas') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                        Fasilitas
                    </a>

                    <a href="{{ url('/daftar') }}"
                       class="btn-primary">
                        Daftar Sekarang
                    </a>

                </div>

                <!-- TOMBOL MENU MOBILE -->
                <button
                    id="mobile-menu-btn"
                    type="button"
                    aria-label="Buka menu navigasi"
                    aria-controls="nav-menu"
                    aria-expanded="false"
                    class="md:hidden p-2 rounded-lg hover:bg-gray-100">

                    <svg class="w-6 h-6 text-gray-700"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>

            </div>

            <!-- MENU MOBILE -->
            <div id="nav-menu"
                 class="hidden md:hidden pb-4 border-t border-gray-200">

                <a href="{{ url('/') }}"
                   class="block px-4 py-2 rounded-lg font-medium
                   {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    Beranda
                </a>

                <a href="{{ url('/tentang') }}"
                   class="block px-4 py-2 rounded-lg font-medium
                   {{ request()->is('tentang') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    Tentang
                </a>

                <a href="{{ url('/berita') }}"
                   class="block px-4 py-2 rounded-lg font-medium
                   {{ request()->is('berita*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    Berita
                </a>

                <a href="{{ url('/guru') }}"
                   class="block px-4 py-2 rounded-lg font-medium
                   {{ request()->is('guru') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    Guru
                </a>

                <a href="{{ url('/fasilitas') }}"
                   class="block px-4 py-2 rounded-lg font-medium
                   {{ request()->is('fasilitas') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600' }}">
                    Fasilitas
                </a>

                <a href="{{ url('/daftar') }}"
                   class="block mx-4 mt-4 py-2 px-4 btn-primary text-center">
                    Daftar Sekarang
                </a>

            </div>

        </div>
    </nav>

    <!-- KONTEN HALAMAN -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-300 mt-20">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-8">

                <!-- TENTANG SEKOLAH -->
                <div>
                    <h3 class="text-white font-bold text-lg mb-4">
                        SMA Negeri 1 Medan
                    </h3>

                    <p class="text-sm leading-relaxed">
                        Sekolah terdepan dalam mengembangkan karakter
                        dan akademik siswa yang berkualitas.
                    </p>
                </div>

                <!-- NAVIGASI -->
                <div>
                    <h4 class="text-white font-bold mb-4">Navigasi</h4>

                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="hover:text-white">Beranda</a></li>
                        <li><a href="{{ url('/tentang') }}" class="hover:text-white">Tentang Kami</a></li>
                        <li><a href="{{ url('/berita') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ url('/guru') }}" class="hover:text-white">Guru</a></li>
                        <li><a href="{{ url('/fasilitas') }}" class="hover:text-white">Fasilitas</a></li>
                    </ul>
                </div>

                <!-- KONTAK -->
                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>

                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start">
                            <span class="mr-2">📧</span>
                            <span>info@sman1medan.sch.id</span>
                        </li>

                        <li class="flex items-start">
                            <span class="mr-2">📞</span>
                            <span>+62 61-1234-5678</span>
                        </li>

                        <li class="flex items-start">
                            <span class="mr-2">📍</span>
                            <span>Medan, Sumatera Utara</span>
                        </li>
                    </ul>
                </div>

                <!-- MEDIA SOSIAL -->
                <div>
                    <h4 class="text-white font-bold mb-4">Media Sosial</h4>

                    <div class="flex space-x-4">

                        <a href="#"
                           aria-label="Facebook"
                           class="w-10 h-10 bg-blue-600 rounded-full
                           flex items-center justify-center hover:bg-blue-700">
                            <span class="text-white font-bold">f</span>
                        </a>

                        <a href="#"
                           aria-label="X"
                           class="w-10 h-10 bg-blue-400 rounded-full
                           flex items-center justify-center hover:bg-blue-500">
                            <span class="text-white">𝕏</span>
                        </a>

                        <a href="#"
                           aria-label="Instagram"
                           class="w-10 h-10 bg-pink-600 rounded-full
                           flex items-center justify-center hover:bg-pink-700">
                            <span class="text-white">📷</span>
                        </a>

                    </div>
                </div>

            </div>

            <!-- COPYRIGHT -->
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>
                    &copy; {{ date('Y') }} SMA Negeri 1 Medan.
                    Semua hak dilindungi.
                </p>
            </div>

        </div>
    </footer>

</body>
</html>
```