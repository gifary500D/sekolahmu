@extends('layouts.app')

@section('title', 'Kelola Tugas Guru')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 text-emerald-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Guru &amp; Pengajar
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Kelola Tugas &amp; Penugasan</h1>
                <p class="text-slate-600 text-sm mt-1">Buat tugas baru, pantau pengumpulan siswa, atau hapus tugas yang telah berakhir.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.tugas.create') }}" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm font-bold shadow-sm transition-all">
                    + Buat Tugas Baru
                </a>
                <a href="/dashboard" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-sm font-semibold transition-colors">
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Task List Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900">Daftar Tugas yang Anda Buat</h2>
                <span class="text-xs text-slate-500">Total: {{ count($tugasList) }} Tugas</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Judul &amp; Mata Pelajaran</th>
                            <th class="py-3 px-6">Kelas</th>
                            <th class="py-3 px-6">Prioritas</th>
                            <th class="py-3 px-6">Tenggat Waktu</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($tugasList as $tugas)
                            @php
                                $isExpired = now()->greaterThan(\Carbon\Carbon::parse($tugas->tenggat));
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 block text-base mb-0.5">{{ $tugas->judul }}</strong>
                                    <span class="text-xs text-blue-700 font-medium block">{{ $tugas->mata_pelajaran }}</span>
                                </td>
                                <td class="py-4 px-6 font-semibold">{{ $tugas->kelas->nama ?? 'Semua Kelas' }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded text-xs font-semibold {{ $tugas->prioritas === 'tinggi' ? 'bg-red-50 text-red-700' : ($tugas->prioritas === 'sedang' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700') }}">
                                        {{ ucfirst($tugas->prioritas) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-mono text-xs {{ $isExpired ? 'text-red-600 font-bold' : 'text-slate-700 font-semibold' }}">
                                    {{ $tugas->tenggat }}
                                    @if($isExpired)
                                        <span class="block text-[10px] text-red-500 font-sans font-bold">(Tenggat Terlewat)</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('guru.tugas.submissions', $tugas->id) }}" class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-800 rounded-lg text-xs font-semibold transition-colors inline-block">
                                        Periksa
                                    </a>
                                    <form action="{{ route('guru.tugas.delete', $tugas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-xs font-semibold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">Anda belum membuat tugas apapun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
