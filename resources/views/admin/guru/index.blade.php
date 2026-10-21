@extends('layouts.app')

@section('title', 'Manajemen Data Guru & Staf')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Manajemen Data Guru &amp; Staf Pengajar</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Daftar tenaga pendidik dan administrator aktif di SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    + Tambah Guru / Staf
                </a>
                <a href="/dashboard" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Kesalahan</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Guru Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Guru &amp; Administrator</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Total: {{ count($guruList) }} Pengajar / Staf</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Nama &amp; Gelar</th>
                            <th class="py-3 px-6">Alamat Email</th>
                            <th class="py-3 px-6">Peran (Role)</th>
                            <th class="py-3 px-6">Tanggal Bergabung</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($guruList as $guru)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                    {{ $guru->name }}
                                </td>
                                <td class="py-4 px-6 text-slate-600 dark:text-slate-400">
                                    {{ $guru->email }}
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $badgeColor = $guru->role == 'admin' ? 'bg-purple-50 dark:bg-purple-950/60 text-purple-800 dark:text-purple-300' : 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300';
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-md {{ $badgeColor }} text-xs font-semibold uppercase">
                                        {{ $guru->role }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $guru->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($guru->id !== auth()->id())
                                        <form action="{{ route('admin.users.delete', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 dark:bg-red-950/50 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 font-semibold rounded-lg text-xs transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Akun Anda</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400 text-sm">Belum ada data guru terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
