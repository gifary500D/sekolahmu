@extends('layouts.app')

@section('title', 'Rekapitulasi Absensi Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 text-emerald-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Kehadiran Akademik
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Rekapitulasi Absensi</h1>
                <p class="text-slate-600 text-sm mt-1">Pantau catatan kehadiran harian Anda di kelas SMA Pemda Bahorok.</p>
            </div>
            <div>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-sm font-semibold transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900">Riwayat Kehadiran Kelas</h2>
                <span class="text-xs text-slate-500">Tahun Ajaran 2026/2027</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Tanggal</th>
                            <th class="py-3 px-6">Kelas</th>
                            <th class="py-3 px-6">Status Kehadiran Anda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($absensiList as $absensi)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 font-mono text-xs font-semibold text-slate-900">{{ $absensi->tanggal }}</td>
                                <td class="py-4 px-6 font-medium">{{ $absensi->kelas }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded bg-emerald-50 text-emerald-800 text-xs font-semibold">Hadir</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-500">Belum ada data absensi tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
