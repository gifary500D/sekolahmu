@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Kehadiran Akademik
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Rekapitulasi Absensi</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Pantau catatan kehadiran harian Anda di kelas {{ $user->kelas->nama ?? 'Siswa' }}.</p>
            </div>
            <div>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Kehadiran Kelas {{ $user->kelas->nama ?? '' }}</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tahun Ajaran 2026/2027</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Tanggal</th>
                            <th class="py-3 px-6">Kelas</th>
                            <th class="py-3 px-6">Status Kehadiran Anda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($absensiList as $absensi)
                            @php
                                $status = $absensi->data_kehadiran[$user->id] ?? 'Hadir';
                                $badgeClass = match($status) {
                                    'Sakit' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60',
                                    'Izin' => 'bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60',
                                    'Alpa' => 'bg-red-50 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800/60',
                                    default => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-6 font-mono text-xs font-semibold text-slate-900 dark:text-white">{{ $absensi->tanggal }}</td>
                                <td class="py-4 px-6 font-medium">{{ $absensi->kelas }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded {{ $badgeClass }} text-xs font-semibold">{{ $status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada data absensi tercatat untuk kelas Anda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
