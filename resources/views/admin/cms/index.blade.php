@extends('layouts.app')

@section('title', 'CMS Portal & Berita')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">CMS Portal &amp; Publikasi Berita</h1>
                <p class="text-sm text-slate-500">Kelola pengumuman, berita sekolah, dan artikel yang tampil di halaman utama.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center gap-2 self-start">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-xl shadow-sm text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Publikasi Berita -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-fit">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Buat Berita / Pengumuman</h2>
                <form action="{{ route('admin.cms.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Berita <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Judul pengumuman..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                            <option value="terbit">Terbit (Publik)</option>
                            <option value="arsip">Arsip (Draft)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Gambar Utama</label>
                        <input type="file" name="gambar" accept="image/*" class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Isi Berita / Konten <span class="text-rose-500">*</span></label>
                        <textarea name="konten" rows="5" required placeholder="Tulis isi berita di sini..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-600"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold transition-colors shadow-sm">
                        Publikasikan Berita
                    </button>
                </form>
            </div>

            <!-- Daftar Berita Terbit -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h2 class="text-base font-bold text-slate-900">Arsip Publikasi Berita</h2>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">Total: {{ $beritaList->count() }} Berita</span>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($beritaList as $berita)
                        @php
                            $pubTime = ($berita->diterbitkan_pada ?? $berita->created_at)?->format('d M Y, H:i') ?? '-';
                            $imgSrc = $berita->gambar_path ? asset('storage/' . $berita->gambar_path) : '';
                        @endphp
                        <div class="p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-slate-300 transition-colors">
                            <div class="flex items-start gap-3 flex-1">
                                @if($berita->gambar_path)
                                    <img src="{{ $imgSrc }}" alt="{{ $berita->judul }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0 border border-slate-200">
                                @endif
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $berita->status === 'terbit' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $berita->status }}
                                        </span>
                                        <span class="text-xs text-slate-400">{{ $pubTime }}</span>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-900">{{ $berita->judul }}</h3>
                                    <p class="text-xs text-slate-600 line-clamp-2">{{ $berita->konten }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 self-end sm:self-center">
                                <button 
                                    type="button" 
                                    onclick="openCmsNewsModal('{{ addslashes($berita->judul) }}', '{{ $pubTime }}', '{{ $imgSrc }}', '{{ addslashes(str_replace(["\r\n", "\r", "\n"], '\n', $berita->konten)) }}', '{{ ucfirst($berita->status) }}')"
                                    class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap"
                                >
                                    Pratinjau
                                </button>
                                <form action="{{ route('admin.cms.berita.delete', $berita->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400 text-xs">Belum ada berita atau pengumuman yang dipublikasikan.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Pratinjau CMS Berita -->
<div id="cmsNewsModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200">
        <div class="p-4 sm:p-6 bg-slate-900 text-white flex justify-between items-center">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-400 block mb-0.5">Pratinjau Konten Berita</span>
                <h3 id="cmsModalTitle" class="font-bold text-lg">Judul Berita</h3>
            </div>
            <button type="button" onclick="closeCmsNewsModal()" class="w-9 h-9 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-4">
            <div class="flex items-center gap-3">
                <span id="cmsModalStatus" class="px-2.5 py-1 rounded text-xs font-bold uppercase bg-emerald-100 text-emerald-800"></span>
                <span id="cmsModalTime" class="text-xs text-slate-500 font-mono"></span>
            </div>
            <div id="cmsModalImgWrapper" class="relative h-48 sm:h-56 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 hidden">
                <img id="cmsModalImg" src="" alt="Gambar Berita" class="w-full h-full object-cover">
            </div>
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                <p id="cmsModalContent" class="text-sm text-slate-800 leading-relaxed whitespace-pre-line"></p>
            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex justify-end">
            <button type="button" onclick="closeCmsNewsModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-xs font-semibold transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
function openCmsNewsModal(title, time, imgUrl, content, status) {
    document.getElementById('cmsModalTitle').textContent = title;
    document.getElementById('cmsModalTime').textContent = time;
    document.getElementById('cmsModalStatus').textContent = status;
    const imgWrapper = document.getElementById('cmsModalImgWrapper');
    const imgEl = document.getElementById('cmsModalImg');
    if (imgUrl) {
        imgEl.src = imgUrl;
        imgWrapper.classList.remove('hidden');
    } else {
        imgWrapper.classList.add('hidden');
    }
    document.getElementById('cmsModalContent').textContent = content;
    document.getElementById('cmsNewsModal').classList.remove('hidden');
}

function closeCmsNewsModal() {
    document.getElementById('cmsNewsModal').classList.add('hidden');
}
</script>
@endsection
