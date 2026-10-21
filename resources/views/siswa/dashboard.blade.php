@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
@php
    $hour = (int) now()->timezone('Asia/Jakarta')->format('G');
    if ($hour >= 4 && $hour <= 10) {
        $greetings = 'Selamat Pagi';
    } elseif ($hour >= 11 && $hour <= 14) {
        $greetings = 'Selamat Siang';
    } elseif ($hour >= 15 && $hour <= 17) {
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
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900"><span class="dynamic-greeting" data-greeting>{{ $greetings }}</span>, {{ auth()->user()->name ?? 'Siswa' }}</h1>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
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

            <!-- Jadwal Pelajaran -->
            <a href="{{ route('siswa.roster') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-blue-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jadwal Pelajaran</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">Roster Kelas</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center group-hover:bg-indigo-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-indigo-600 font-semibold flex items-center justify-between">
                    <span>Lihat Jadwal Harian</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Transkrip Nilai -->
            <a href="{{ route('siswa.nilai') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-blue-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Transkrip Nilai</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">Nilai &amp; Rapor</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center group-hover:bg-purple-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-purple-600 font-semibold flex items-center justify-between">
                    <span>Lihat Nilai &amp; Catatan Guru</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Profil Akun -->
            <a href="{{ route('profile.form') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-blue-500 transition-all block group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengaturan Akun</p>
                        <h3 class="text-3xl font-bold text-slate-900 mt-2">Profil &amp; Sandi</h3>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-cyan-50 text-cyan-700 flex items-center justify-center group-hover:bg-cyan-700 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756.24 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-cyan-600 font-semibold flex items-center justify-between">
                    <span>Ubah Profil &amp; Kata Sandi</span>
                    <span>&rarr;</span>
                </div>
            </a>
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
