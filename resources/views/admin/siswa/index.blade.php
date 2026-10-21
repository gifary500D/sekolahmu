@extends('layouts.app')

@section('title', 'Manajemen Data Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Manajemen Data Siswa</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Daftar seluruh siswa aktif beserta penempatan rombongan belajar (kelas).</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    + Tambah / Kelola Pengguna
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

        <!-- Siswa Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Siswa Aktif</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Total: {{ count($siswaList) }} Siswa</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Nama Siswa</th>
                            <th class="py-3 px-6">NISN &amp; Email</th>
                            <th class="py-3 px-6">Rombel / Kelas</th>
                            <th class="py-3 px-6">Tanggal Bergabung</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($siswaList as $siswa)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">
                                    {{ $siswa->name }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-mono text-xs block font-semibold text-blue-700 dark:text-blue-400">NISN: {{ $siswa->nisn ?? '-' }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $siswa->email }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 text-xs font-semibold">
                                        {{ $siswa->kelas->nama ?? 'Belum Ditentukan' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $siswa->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route('admin.users.delete', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 dark:bg-red-950/50 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 font-semibold rounded-lg text-xs transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400 text-sm">Belum ada data siswa terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
