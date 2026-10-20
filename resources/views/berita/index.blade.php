@extends('layouts.app')

@section('title', 'Berita & Pengumuman Sekolah')

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <span class="inline-block text-blue-700 font-bold tracking-widest text-xs uppercase mb-2 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">Informasi Resmi</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Berita &amp; Pengumuman Sekolah</h1>
            <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Ikuti perkembangan terbaru, artikel kegiatan, dan pengumuman penting dari civitas akademika SMA Pemda Bahorok.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($beritaList ?? [] as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col">
                    <img 
                        src="{{ $item->gambar_path ? asset('storage/' . $item->gambar_path) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop' }}" 
                        alt="{{ $item->judul }}" 
                        class="w-full h-44 sm:h-52 object-cover"
                    >
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">{{ $item->created_at->format('d M Y') }}</span>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug">{{ $item->judul }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $item->konten }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Unsplash Mock Berita -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop" alt="Berita 1" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">18 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Upacara Peringatan Hari Sumpah Pemuda</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Siswa-siswi SMA Pemda Bahorok mengikuti upacara dengan khidmat mengenakan pakaian adat Nusantara.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop" alt="Berita 2" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">15 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Pelatihan Literasi Digital &amp; Coding Dasar</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Laboratorium komputer sekolah mengadakan pelatihan dasar pemrograman web untuk siswa kelas XI.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop" alt="Berita 3" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6">
                        <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">10 Oktober 2026</span>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Juara Umum Olimpiade Sains Kabupaten</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Tim Olimpiade Biologi dan Matematika berhasil membawa pulang piala juara umum tingkat kabupaten.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(method_exists($beritaList, 'links'))
            <div class="mt-12">
                {{ $beritaList->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
