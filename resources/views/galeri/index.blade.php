@extends('layouts.app')

@section('title', 'Galeri Foto Kegiatan Sekolah')

@section('content')
<div class="min-h-screen bg-slate-900 dark:bg-slate-950 text-white py-12 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <span class="inline-block text-amber-400 font-bold tracking-widest text-xs uppercase mb-2 bg-amber-950/60 px-3 py-1 rounded-full border border-amber-500/30">Dokumentasi Visual</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-4">Galeri Foto Kegiatan Sekolah</h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Momen kebersamaan, fasilitas modern, dan aktivitas belajar mengajar di lingkungan SMA Pemda Bahorok.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galeriList ?? [] as $foto)
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img 
                        src="{{ $foto->gambar_path ? asset('storage/' . $foto->gambar_path) : 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop' }}" 
                        alt="Galeri Sekolah" 
                        class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">{{ $foto->judul ?? 'Aktivitas Sekolah' }}</p>
                    </div>
                </div>
            @empty
                <!-- Fallback Unsplash Mock Galeri dengan ukuran responsif -->
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=800&auto=format&fit=crop" alt="Lab Komputer" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Praktikum Komputer Modern</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=800&auto=format&fit=crop" alt="Perpustakaan" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Suasana Perpustakaan &amp; Ruang Baca</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=800&auto=format&fit=crop" alt="Laboratorium Sains" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Praktikum Kimia &amp; Biologi</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop" alt="Kegiatan Olahraga" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Lapangan Olahraga &amp; Ekstrakurikuler</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop" alt="Upacara Bendera" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Upacara Bendera Hari Senin</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg border border-slate-800 group relative">
                    <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop" alt="Diskusi Kelompok" class="w-full h-48 sm:h-56 md:h-64 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
                        <p class="font-bold text-sm text-white">Diskusi Kelompok &amp; Kolaborasi Siswa</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(method_exists($galeriList, 'links'))
            <div class="mt-12">
                {{ $galeriList->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
