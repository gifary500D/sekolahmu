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
                        <div class="p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:border-slate-300 transition-colors">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $berita->status === 'terbit' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $berita->status }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $berita->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900">{{ $berita->judul }}</h3>
                                <p class="text-xs text-slate-600 line-clamp-2">{{ $berita->konten }}</p>
                            </div>
                            <form action="{{ route('admin.cms.berita.delete', $berita->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400 text-xs">Belum ada berita atau pengumuman yang dipublikasikan.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
