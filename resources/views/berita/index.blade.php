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
                @php
                    $pubDate = ($item->diterbitkan_pada ?? $item->created_at)?->format('d M Y') ?? date('d M Y');
                    $imgUrl = $item->gambar_path ? asset('storage/' . $item->gambar_path) : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800&auto=format&fit=crop';
                @endphp
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-md transition-shadow flex flex-col">
                    <img 
                        src="{{ $imgUrl }}" 
                        alt="{{ $item->judul }}" 
                        class="w-full h-44 sm:h-52 object-cover"
                    >
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">{{ $pubDate }}</span>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2 leading-snug">{{ $item->judul }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">{{ $item->konten }}</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4">
                            <button 
                                type="button" 
                                onclick="openNewsModal('{{ addslashes($item->judul) }}', '{{ $pubDate }}', '{{ $imgUrl }}', '{{ addslashes(str_replace(["\r\n", "\r", "\n"], '\n', $item->konten)) }}')"
                                class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1 group transition-colors"
                            >
                                Baca Selengkapnya <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Unsplash Mock Berita -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop" alt="Berita 1" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">18 Oktober 2026</span>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Upacara Peringatan Hari Sumpah Pemuda</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">Siswa-siswi SMA Pemda Bahorok mengikuti upacara dengan khidmat mengenakan pakaian adat Nusantara. Acara diisi dengan pembacaan teks ikrar Sumpah Pemuda serta penampilan paduan suara sekolah.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4">
                            <button 
                                type="button" 
                                onclick="openNewsModal('Upacara Peringatan Hari Sumpah Pemuda', '18 Oktober 2026', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800&auto=format&fit=crop', 'Siswa-siswi SMA Pemda Bahorok mengikuti upacara dengan khidmat mengenakan pakaian adat Nusantara. Acara diisi dengan pembacaan teks ikrar Sumpah Pemuda serta penampilan paduan suara sekolah yang membawakan lagu-lagu nasional.')"
                                class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1 group transition-colors"
                            >
                                Baca Selengkapnya <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop" alt="Berita 2" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">15 Oktober 2026</span>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Pelatihan Literasi Digital &amp; Coding Dasar</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">Laboratorium komputer sekolah mengadakan pelatihan dasar pemrograman web untuk siswa kelas XI dalam menyambut era industri digital 5.0.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4">
                            <button 
                                type="button" 
                                onclick="openNewsModal('Pelatihan Literasi Digital &amp; Coding Dasar', '15 Oktober 2026', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=800&auto=format&fit=crop', 'Laboratorium komputer sekolah mengadakan pelatihan dasar pemrograman web untuk siswa kelas XI dalam menyambut era industri digital 5.0. Pelatihan dipandu oleh instruktur praktisi teknologi informasi.')"
                                class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1 group transition-colors"
                            >
                                Baca Selengkapnya <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 flex flex-col">
                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop" alt="Berita 3" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block mb-2">10 Oktober 2026</span>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-2">Juara Umum Olimpiade Sains Kabupaten</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">Tim Olimpiade Biologi dan Matematika berhasil membawa pulang piala juara umum tingkat kabupaten dengan perolehan medali emas terbanyak.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 mt-4">
                            <button 
                                type="button" 
                                onclick="openNewsModal('Juara Umum Olimpiade Sains Kabupaten', '10 Oktober 2026', 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=800&auto=format&fit=crop', 'Tim Olimpiade Biologi dan Matematika berhasil membawa pulang piala juara umum tingkat kabupaten dengan perolehan medali emas terbanyak. Kepala Sekolah mengapresiasi kerja keras para guru pembimbing dan siswa berprestasi.')"
                                class="text-xs font-bold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1 group transition-colors"
                            >
                                Baca Selengkapnya <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </button>
                        </div>
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

<!-- Modal Detail Berita -->
<div id="newsDetailModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200">
        <div class="relative h-56 sm:h-64 bg-slate-900 overflow-hidden flex-shrink-0">
            <img id="newsModalImg" src="" alt="Gambar Berita" class="w-full h-full object-cover">
            <button type="button" onclick="closeNewsModal()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-950/70 hover:bg-slate-950 text-white flex items-center justify-center transition-colors shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-3">
            <span id="newsModalDate" class="text-xs font-semibold text-blue-600 uppercase tracking-wider block"></span>
            <h3 id="newsModalTitle" class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug"></h3>
            <p id="newsModalContent" class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"></p>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
            <button type="button" onclick="closeNewsModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-xs font-semibold transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
function openNewsModal(title, date, imgUrl, content) {
    document.getElementById('newsModalTitle').textContent = title;
    document.getElementById('newsModalDate').textContent = date;
    const imgEl = document.getElementById('newsModalImg');
    if (imgUrl) {
        imgEl.src = imgUrl;
        imgEl.parentElement.classList.remove('hidden');
    } else {
        imgEl.parentElement.classList.add('hidden');
    }
    document.getElementById('newsModalContent').textContent = content;
    document.getElementById('newsDetailModal').classList.remove('hidden');
}

function closeNewsModal() {
    document.getElementById('newsDetailModal').classList.add('hidden');
}
</script>

    </div>
</div>
@endsection
