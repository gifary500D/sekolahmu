@extends('layouts.app')

@section('title', 'Dashboard Administrator')

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
        <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 rounded-2xl shadow-md p-6 sm:p-8 mb-8 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span class="inline-block px-3.5 py-1 rounded-full bg-blue-700/60 text-blue-100 text-xs font-semibold uppercase tracking-wider mb-3 border border-blue-600/50">
                    Panel Kontrol Administrator
                </span>
                <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight"><span class="dynamic-greeting" data-greeting>{{ $greetings }}</span>, {{ auth()->user()->name ?? 'Administrator' }}</h1>
                <p class="text-blue-200 text-sm mt-2 max-w-2xl leading-relaxed">Kelola sistem akademik terpadu, verifikasi pendaftaran peserta didik baru (SPMB), dan pengaturan pengguna secara real-time.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                <a href="{{ route('admin.spmb.index') }}" class="px-5 py-2.5 bg-amber-400 hover:bg-amber-350 text-blue-950 font-bold rounded-xl text-sm shadow-md transition-all text-center">
                    Verifikasi SPMB ({{ $pendingSpmb }})
                </a>
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl text-sm border border-white/20 transition-all text-center">
                    Manajemen Pengguna
                </a>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Siswa Aktif -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa Aktif</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalSiswa, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-blue-600 font-semibold">
                    <span>Terdaftar di rombongan belajar</span>
                </div>
            </div>

            <!-- Guru & Admin -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Guru &amp; Staf</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalGuru + $totalAdmin, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-emerald-600 font-semibold">
                    <span>{{ $totalGuru }} Guru, {{ $totalAdmin }} Admin</span>
                </div>
            </div>

            <!-- Kelas Rombel -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rombongan Belajar</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalKelas, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-amber-600 font-semibold">
                    <span>Tingkat X, XI, dan XII</span>
                </div>
            </div>

            <!-- Pendaftar SPMB -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendaftar SPMB</p>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalSpmb, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs text-cyan-700 font-semibold">
                    <span>{{ $acceptedSpmb }} Diterima, {{ $pendingSpmb }} Pending</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Management Modules -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Main Menu Overview -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center justify-between">
                        <span>Modul Administrasi Utama</span>
                        <span class="text-xs font-normal text-slate-500">Akses Cepat</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <a href="{{ route('admin.siswa.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-blue-600 hover:bg-blue-50/40 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center group-hover:bg-blue-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Tabel Data Siswa</h3>
                                    <span class="text-xs text-blue-600 font-medium">Daftar Aktif &amp; Kelas</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Lihat tabel lengkap seluruh siswa aktif dan rombongan belajar.</p>
                        </a>

                        <a href="{{ route('admin.kelas.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-emerald-600 hover:bg-emerald-50/40 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Master Data Kelas</h3>
                                    <span class="text-xs text-emerald-600 font-medium">Rombel &amp; Wali Kelas</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Tambah, ubah, atau hapus rombongan belajar dan tentukan wali kelas.</p>
                        </a>

                        <a href="{{ route('admin.cms.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-indigo-600 hover:bg-indigo-50/40 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center group-hover:bg-indigo-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">CMS Portal &amp; Berita</h3>
                                    <span class="text-xs text-indigo-600 font-medium">Publikasi Sekolah</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Buat dan publikasikan berita, pengumuman, atau artikel ke halaman depan.</p>
                        </a>

                        <a href="{{ route('admin.spmb.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-amber-600 hover:bg-amber-50/40 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center group-hover:bg-amber-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Verifikasi Berkas SPMB</h3>
                                    <span class="text-xs text-amber-600 font-medium">{{ $pendingSpmb }} Menunggu Validasi</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Periksa dan validasi dokumen calon peserta didik baru.</p>
                        </a>

                        <a href="{{ route('admin.roster.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-purple-600 hover:bg-purple-50/40 transition-all group">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center group-hover:bg-purple-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Jadwal Pelajaran (Roster)</h3>
                                    <span class="text-xs text-purple-600 font-medium">Pengaturan Waktu</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Atur jadwal mata pelajaran per kelas, hari, dan guru pengampu.</p>
                        </a>

                        <a href="{{ route('admin.users.index') }}" class="p-5 rounded-xl border border-slate-200 hover:border-cyan-600 hover:bg-cyan-50/40 transition-all group sm:col-span-2">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center group-hover:bg-cyan-700 group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756.24 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Manajemen Pengguna Sistem &amp; Penempatan Kelas</h3>
                                    <span class="text-xs text-cyan-600 font-medium">Akun &amp; Kredensial</span>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">Tambah pengguna baru, reset kata sandi, dan atur penempatan kelas siswa secara instan.</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Col: System Status & Recent Activity -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center justify-between">
                        <span>Pendaftar SPMB Terbaru</span>
                        <a href="{{ route('admin.spmb.index') }}" class="text-xs text-blue-700 hover:underline font-semibold">Semua</a>
                    </h2>
                    <div class="space-y-4">
                        @forelse($recentSpmb as $spmb)
                            <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 text-xs font-bold">SP</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $spmb->nama_lengkap }}</p>
                                    <p class="text-[11px] text-slate-500">{{ $spmb->jalur_pendaftaran }} • <span class="font-medium text-slate-700">{{ $spmb->status }}</span></p>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $spmb->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500">Belum ada data pendaftar SPMB.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center justify-between">
                        <span>Pengguna Baru</span>
                        <a href="{{ route('admin.users.index') }}" class="text-xs text-blue-700 hover:underline font-semibold">Semua</a>
                    </h2>
                    <div class="space-y-4">
                        @forelse($recentUsers as $usr)
                            <div class="flex items-start gap-3 pb-3 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0 text-xs font-bold">{{ strtoupper(substr($usr->role, 0, 1)) }}</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-slate-900 truncate">{{ $usr->name }}</p>
                                    <p class="text-[11px] text-slate-500">Peran: <span class="uppercase font-medium text-slate-700">{{ $usr->role }}</span></p>
                                    <span class="text-[10px] text-slate-400 mt-0.5 block">{{ $usr->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500">Belum ada data pengguna baru.</p>
                        @endforelse
                    </div>
                </div>

                <!-- System Info Box -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-950 text-slate-200 rounded-2xl p-6 shadow-sm border border-slate-800">
                    <h3 class="font-bold text-white mb-2 text-sm">Informasi Server &amp; Sistem</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">Sistem operasional akademik berjalan normal pada Laravel 12.</p>
                    <div class="text-xs space-y-2 border-t border-slate-800 pt-3">
                        <div class="flex justify-between"><span>Lingkungan</span><span class="text-emerald-400 font-semibold">Production</span></div>
                        <div class="flex justify-between"><span>Database</span><span class="text-slate-300 font-semibold">MySQL / SQLite</span></div>
                        <div class="flex justify-between"><span>Keamanan</span><span class="text-blue-400 font-semibold">SSL &amp; CSRF Active</span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
