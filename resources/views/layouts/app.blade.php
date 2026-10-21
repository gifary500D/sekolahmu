<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - SMA Pemda Bahorok</title>
    
    <!-- Anti-flicker Theme Script -->
    <script>
        (function() {
            try {
                const theme = localStorage.getItem('theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();

        window.toggleDarkMode = function () {
            const isDark = document.documentElement.classList.toggle('dark');
            try {
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            } catch (e) {}
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: isDark ? 'dark' : 'light' } }));
        };
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-['Poppins',sans-serif] text-slate-800 dark:text-slate-100 antialiased selection:bg-blue-600 selection:text-white transition-colors duration-200 overflow-x-hidden">
    <!-- Navbar -->
    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-50 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center group gap-3">
                        <div class="w-12 h-12 flex items-center justify-center bg-transparent group-hover:scale-105 transition-transform">
                            <img src="{{ asset('images/logo-skansa.png') }}" alt="Logo SMA/SMK Pemda Bahorok" class="w-11 h-11 object-contain drop-shadow-sm">
                        </div>
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-700 dark:text-blue-400 block">Yayasan Pendidikan</span>
                            <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white leading-tight">SMA Pemda Bahorok</h1>
                        </div>
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="/" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Beranda</a>
                    <a href="/#tentang" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Tentang</a>
                    <a href="/#program" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Program</a>
                    <a href="{{ route('berita.index') }}" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Berita</a>
                    <a href="{{ route('agenda.index') }}" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Agenda</a>
                    <a href="{{ route('galeri.index') }}" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Galeri</a>
                    <a href="/#fasilitas" class="px-3.5 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 hover:bg-blue-50/60 dark:hover:bg-slate-800 font-medium text-sm rounded-lg transition-all">Fasilitas</a>
                    
                    <div class="h-6 w-px bg-slate-200 dark:bg-slate-700 mx-2"></div>

                    <!-- Theme Toggle Desktop -->
                    <button type="button" onclick="toggleDarkMode()" aria-label="Ganti Tema Gelap/Terang" title="Ganti Tema Gelap / Terang" class="p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 mr-1">
                        <!-- Sun Icon (Shown in Dark Mode) -->
                        <svg class="w-5 h-5 hidden dark:block text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon (Shown in Light Mode) -->
                        <svg class="w-5 h-5 block dark:hidden text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    @auth
                        <a href="/dashboard" class="px-4 py-2 bg-blue-50 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 font-semibold rounded-lg text-sm hover:bg-blue-100 dark:hover:bg-blue-900/60 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-slate-900 dark:bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 dark:hover:bg-slate-700 border dark:border-slate-700 transition-colors shadow-sm">Keluar</button>
                        </form>
                    @else
                        <a href="/login" class="px-4 py-2 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-400 font-semibold text-sm transition-colors">Masuk</a>
                        <a href="/daftar" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-sm shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/35 transition-all">Daftar SPMB</a>
                    @endauth
                </div>

                <!-- Mobile Action & Menu Button -->
                <div class="flex items-center gap-1.5 md:hidden">
                    <button type="button" onclick="toggleDarkMode()" aria-label="Ganti Tema Gelap/Terang" title="Ganti Tema Gelap / Terang" class="p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition-colors">
                        <svg class="w-5 h-5 hidden dark:block text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <button id="mobile-menu-btn" aria-label="Toggle menu" class="p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div id="nav-menu" class="hidden md:hidden pb-6 pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2">
                <a href="/" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Beranda</a>
                <a href="/#tentang" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Tentang</a>
                <a href="/#program" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Program</a>
                <a href="{{ route('berita.index') }}" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Berita</a>
                <a href="{{ route('agenda.index') }}" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Agenda</a>
                <a href="{{ route('galeri.index') }}" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Galeri</a>
                <a href="/#fasilitas" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-800 hover:text-blue-700 dark:hover:text-blue-400 rounded-lg font-medium text-sm transition-colors">Fasilitas</a>
                
                <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-2">
                    @auth
                        <a href="/dashboard" class="block px-4 py-2.5 bg-blue-50 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 font-semibold rounded-lg text-sm">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2.5 text-red-600 dark:text-red-400 font-semibold hover:bg-red-50 dark:hover:bg-red-950/30 rounded-lg text-sm">Keluar</button>
                        </form>
                    @else
                        <a href="/login" class="block px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg font-medium text-sm">Masuk Sistem</a>
                        <div class="pt-1">
                            <a href="/daftar" class="block w-full py-3 bg-blue-700 text-white font-bold rounded-xl text-center text-sm shadow-md shadow-blue-500/20">Daftar SPMB Sekarang</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-blue-950 via-slate-900 to-indigo-950 text-slate-300 mt-20 relative overflow-hidden pt-12">
        <!-- SVG Wave Divider -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none z-10">
            <svg class="relative block w-full h-12 sm:h-16 text-slate-50 dark:text-slate-950 transition-colors" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M0,0 C150,90 350,-40 500,60 C650,160 900,10 1200,40 L1200,0 L0,0 Z" fill="currentColor"></path>
            </svg>
        </div>

        <!-- Subtle background glowing accents -->
        <div class="absolute top-20 -left-40 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-14 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-12 mb-12">
                
                <!-- Col 1: Brand & Bio -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-skansa.png') }}" alt="Logo SMA Pemda Bahorok" class="w-12 h-12 object-contain">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-widest text-blue-400 block">Yayasan Pendidikan</span>
                            <h3 class="text-xl font-extrabold text-white">SMA Pemda Bahorok</h3>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Pusat pendidikan menengah unggulan di Kabupaten Langkat yang berkomitmen mencetak generasi cerdas, berkarakter mulia, dan siap menghadapi masa depan.
                    </p>
                    <div class="pt-1 flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-900/50 border border-blue-700/50 text-blue-300 text-xs font-semibold">
                            Terakreditasi A
                        </span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Utama -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Navigasi Utama
                    </h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="/" class="text-slate-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="/#tentang" class="text-slate-400 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="/#program" class="text-slate-400 hover:text-white transition-colors">Program Keahlian</a></li>
                        <li><a href="/#fasilitas" class="text-slate-400 hover:text-white transition-colors">Fasilitas Sekolah</a></li>
                        <li><a href="/daftar" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">Pendaftaran SPMB</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kontak & Alamat -->
                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-5 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Kontak &amp; Alamat
                    </h4>
                    <ul class="space-y-3.5 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="break-all">sma.pemda@gmail.com</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>JL. Veteran Bahorok, Kec. Bohorok, Kab. Langkat, Prov. Sumatera Utara</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Copyright & Bottom Bar -->
            <div class="border-t border-blue-900/50 pt-6 text-center text-xs text-slate-400">
                <p>&copy; 2026 SMA Pemda Bahorok. Seluruh hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <!-- Dynamic Greeting & Mobile Menu Script -->
    <script>
        (function () {
            const mobileBtn = document.getElementById('mobile-menu-btn');
            if (mobileBtn) {
                mobileBtn.addEventListener('click', function () {
                    const menu = document.getElementById('nav-menu');
                    if (menu) menu.classList.toggle('hidden');
                });
            }

            function getDeviceGreeting() {
                const hour = new Date().getHours();
                if (hour >= 4 && hour <= 10) {
                    return 'Selamat Pagi';
                } else if (hour >= 11 && hour <= 14) {
                    return 'Selamat Siang';
                } else if (hour >= 15 && hour <= 17) {
                    return 'Selamat Sore';
                } else {
                    return 'Selamat Malam';
                }
            }

            function updateDynamicGreetings() {
                const greeting = getDeviceGreeting();
                document.querySelectorAll('[data-greeting], .dynamic-greeting').forEach(function (el) {
                    el.textContent = greeting;
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', updateDynamicGreetings);
            } else {
                updateDynamicGreetings();
            }
        })();
    </script>
</body>
</html>
