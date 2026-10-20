@extends('layouts.app')

@section('title', 'Jadwal Pelajaran Kelas')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-purple-50 text-purple-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Akademik Siswa
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Jadwal Pelajaran (Roster)</h1>
                <p class="text-slate-600 text-sm mt-1">Jadwal kegiatan belajar mengajar harian untuk kelas {{ $user->kelas->nama ?? 'Siswa' }}.</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-sm font-semibold transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Roster Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900">Rombongan Belajar: {{ $user->kelas->nama ?? '-' }}</h2>
                <span class="text-xs text-slate-500">Tahun Ajaran 2026/2027</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Hari</th>
                            <th class="py-3 px-6">Jam Pelajaran</th>
                            <th class="py-3 px-6">Mata Pelajaran</th>
                            <th class="py-3 px-6">Guru Pengampu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($rosters as $roster)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-900">{{ $roster->hari }}</td>
                                <td class="py-4 px-6 font-mono text-xs">{{ $roster->jam_mulai }} - {{ $roster->jam_selesai }}</td>
                                <td class="py-4 px-6 font-semibold text-blue-700">{{ $roster->mata_pelajaran }}</td>
                                <td class="py-4 px-6">{{ $roster->guru->name ?? 'Guru Pengampu' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500 text-xs">
                                    Belum ada jadwal pelajaran (roster) yang diatur untuk kelas Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
