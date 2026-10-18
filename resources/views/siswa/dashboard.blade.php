@extends('layouts.app')

@section('title', 'Dashboard Siswa')

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
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Portal Siswa Akademik
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $greetings }}, {{ auth()->user()->name ?? 'Siswa' }}</h1>
                <p class="text-slate-600 text-sm mt-1">Pantau tugas sekolah, jadwal pelajaran, dan catatan kehadiran Anda di SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-sm font-medium border border-emerald-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Status: Aktif
                </span>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <!-- Tugas Aktif -->
            <a href="{{ route('siswa.tugas') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-blue-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas Aktif</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ isset($tugasList) ? count($tugasList) : 0 }} Tugas</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center group-hover:bg-blue-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-blue-600 font-semibold flex items-center justify-between">
                    <span>Kelola &amp; Kumpulkan Tugas</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Kehadiran -->
            <a href="{{ route('siswa.absensi') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-blue-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kehadiran Bulan Ini</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ $attendanceRate ?? 100 }}%</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-blue-600 font-semibold flex items-center justify-between">
                    <span>Lihat Rekap Absensi</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Kelas -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kelas / Rombel</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">{{ auth()->user()->kelas->nama ?? 'Belum ada kelas' }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-slate-600 font-medium">
                    <span>Terdaftar di SMA Pemda Bahorok</span>
                </div>
            </div>
        </div>

        <!-- Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Assignments List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-900">Daftar Tugas &amp; Penugasan</h2>
                        <a href="{{ route('siswa.tugas') }}" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @forelse($tugasList ?? [] as $tugas)
                            @php
                                $sub = $submitted[$tugas->id] ?? null;
                                $status = $sub ? $sub->status : 'belum';
                                
                                $tenggat = \Carbon\Carbon::parse($tugas->tenggat);
                                $diffHours = now()->diffInHours($tenggat, false);
                                if ($diffHours < 0) {
                                    $timeLabel = 'Tenggat terlewat';
                                    $badgeColor = 'bg-red-100 text-red-800';
                                } elseif ($diffHours < 24) {
                                    $timeLabel = $diffHours . ' jam lagi';
                                    $badgeColor = 'bg-amber-100 text-amber-800';
                                } else {
                                    $days = ceil($diffHours / 24);
                                    $timeLabel = $days . ' hari lagi';
                                    $badgeColor = 'bg-blue-100 text-blue-800';
                                }
                            @endphp
                            <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-slate-50/50 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-block px-2.5 py-0.5 rounded {{ $badgeColor }} text-xs font-semibold">Tenggat: {{ $timeLabel }}</span>
                                        <span class="text-xs text-blue-700 font-medium">{{ $tugas->mata_pelajaran ?? 'Umum' }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-900 text-base mb-1">{{ $tugas->judul }}</h3>
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ Str::limit($tugas->deskripsi, 70) }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($status === 'selesai')
                                        <span class="px-3 py-1.5 rounded bg-emerald-50 text-emerald-800 text-xs font-semibold block text-center mb-1">Sudah Dikumpulkan</span>
                                        <a href="{{ route('siswa.tugas') }}" class="text-xs text-blue-600 hover:underline block text-center">Kelola Berkas</a>
                                    @else
                                        <a href="{{ route('siswa.tugas') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-semibold transition-colors block text-center">Kumpulkan Tugas</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-500 text-sm">
                                Belum ada penugasan baru.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Col: Profile & Announcements -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-slate-900">Profil Singkat</h2>
                        <a href="{{ route('siswa.password.form') }}" class="text-xs text-blue-600 font-semibold hover:underline">Ganti Sandi</a>
                    </div>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Nomor NISN</span>
                            <span class="font-semibold text-slate-900 font-mono">{{ auth()->user()->nisn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Email</span>
                            <span class="font-semibold text-slate-900">{{ auth()->user()->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Tahun Bergabung</span>
                            <span class="font-semibold text-slate-900">{{ auth()->user()->created_at?->format('Y') ?? 2026 }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-slate-500">Status Akun</span>
                            <span class="font-semibold text-emerald-600">Aktif (Aman)</span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 text-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="font-bold text-white mb-3 text-sm">Pengumuman Sekolah Terbaru</h3>
                    @forelse($pengumuman ?? [] as $berita)
                        <div class="mb-3 pb-3 border-b border-slate-800 last:mb-0 last:pb-0 last:border-0">
                            <h4 class="font-semibold text-white text-xs mb-1">{{ $berita->judul }}</h4>
                            <p class="text-[11px] text-slate-400 leading-relaxed">{{ Str::limit($berita->ringkasan, 80) }}</p>
                            <span class="text-[10px] text-slate-500 mt-1 block">{{ $berita->diterbitkan_pada?->format('d M Y') ?? 'Terbaru' }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada pengumuman sekolah saat ini.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
