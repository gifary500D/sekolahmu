@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
@php
    $hour = date('H');
    if ($hour >= 4 && $hour < 12) {
        $greetings = 'Selamat Pagi';
    } elseif ($hour >= 12 && $hour < 15) {
        $greetings = 'Selamat Siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greetings = 'Selamat Sore';
    } else {
        $greetings = 'Selamat Malam';
    }
@endphp
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 text-emerald-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Guru &amp; Pengajar
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $greetings }}, {{ auth()->user()->name ?? 'Bapak/Ibu Guru' }}</h1>
                <p class="text-slate-600 text-sm mt-1">Kelola absensi kelas, penugasan mata pelajaran, dan penilaian siswa SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium border border-blue-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Semester Genap 2026/2027
                </span>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <!-- Kelas Diampu -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas Binaan</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ isset($kelasBinaan) ? count($kelasBinaan) : 0 }} Kelas</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-slate-600 font-medium">
                    <span>Terdaftar di sistem database</span>
                </div>
            </div>

            <!-- Tugas Aktif -->
            <a href="{{ route('guru.tugas.index') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-emerald-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas Dibuat</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ isset($tugasList) ? count($tugasList) : 0 }} Tugas</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-emerald-600 font-semibold flex items-center justify-between">
                    <span>Kelola &amp; Periksa Pengumpulan</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Total Siswa -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ $totalSiswa ?? 0 }} Siswa</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-emerald-600 font-medium">
                    <span>Terdaftar aktif di database</span>
                </div>
            </div>
        </div>

        <!-- Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Quick Actions & Classes -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat Pengajar</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('guru.absensi') }}" class="p-4 rounded-lg border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/50 transition-all group block">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h3 class="font-semibold text-slate-900">Input Absensi Kelas</h3>
                            </div>
                            <p class="text-xs text-slate-600">Catat kehadiran siswa hadir, izin, sakit, atau alpa hari ini.</p>
                        </a>

                        <a href="{{ route('guru.tugas.create') }}" class="p-4 rounded-lg border border-slate-200 hover:border-blue-500 hover:bg-blue-50/50 transition-all group block">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center group-hover:bg-blue-700 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-semibold text-slate-900">Buat Tugas Baru</h3>
                            </div>
                            <p class="text-xs text-slate-600">Unggah lembar tugas, deskripsi, dan tentukan tenggat waktu pengumpulan.</p>
                        </a>
                    </div>
                </div>

                <!-- Assigned Classes Table -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-900">Daftar Kelas Binaan</h2>
                        <span class="text-xs text-slate-500">Tahun Ajaran 2026/2027</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                                    <th class="py-3 px-6">Kelas</th>
                                    <th class="py-3 px-6">Jumlah Siswa</th>
                                    <th class="py-3 px-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 text-slate-700">
                                @forelse($kelasBinaan ?? [] as $kelas)
                                    <tr>
                                        <td class="py-4 px-6 font-semibold text-slate-900">{{ $kelas->nama }}</td>
                                        <td class="py-4 px-6">{{ $kelas->siswa->count() }} Siswa</td>
                                        <td class="py-4 px-6 text-right"><a href="{{ route('guru.absensi', ['kelas_id' => $kelas->id]) }}" class="text-blue-600 font-semibold hover:underline">Kelola Absensi</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 px-6 text-center text-slate-500">Belum ada kelas binaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col: Schedule & Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Tugas Terbaru yang Dibuat</h2>
                    <div class="space-y-3 text-xs">
                        @forelse($tugasList->take(3) as $tugas)
                            <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                                <span class="text-blue-600 font-bold block mb-1">Tenggat: {{ $tugas->tenggat }}</span>
                                <strong class="text-slate-900 text-sm block">{{ $tugas->judul }}</strong>
                                <span class="text-slate-500">{{ $tugas->mata_pelajaran }}</span>
                            </div>
                        @empty
                            <p class="text-slate-500 italic">Belum ada tugas yang dibuat.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-slate-900 text-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-white mb-2 text-sm">Pusat Bantuan Akademik</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">Butuh bantuan teknis penjadwalan atau rekap nilai? Hubungi bagian kurikulum sekolah.</p>
                    <a href="mailto:kurikulum@smapemdabahorok.sch.id" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">Hubungi Kurikulum</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
