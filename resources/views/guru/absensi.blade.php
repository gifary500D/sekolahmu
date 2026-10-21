@extends('layouts.app')

@section('title', 'Kelola Absensi Kelas Guru')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Guru &amp; Pengajar
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Rekapitulasi &amp; Input Absensi Siswa</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Centang kehadiran harian per siswa di kelas binaan SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.absensi.export', ['kelas' => $selectedKelas?->nama]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm">
                    Ekspor Rekap Absensi CSV
                </a>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
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

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Menyimpan Absensi</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Filter & Pilih Kelas -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 h-fit">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Pilih Rombel Kelas</h2>
                <form action="{{ route('guru.absensi') }}" method="GET" class="space-y-4">
                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Kelas Binaan</label>
                        <select id="kelas_id" name="kelas_id" onchange="this.form.submit()" class="w-full px-3 py-2.5 border border-slate-300 dark:border-slate-700 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600">
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ (isset($selectedKelasId) && $selectedKelasId == $kelas->id) ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                    <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-2">Petunjuk Pengisian</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pilih kelas di atas, lalu centang status kehadiran masing-masing siswa (Hadir, Sakit, Izin, atau Alpa) pada tanggal hari ini sebelum menyimpan.
                    </p>
                </div>
            </div>

            <!-- Form Absensi Siswa Per Kelas -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/60">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Siswa Kelas: {{ $selectedKelas->nama ?? 'Pilih Kelas' }}</h2>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Total Siswa: {{ count($siswaList) }}</span>
                    </div>
                </div>
                
                @if($selectedKelas && count($siswaList) > 0)
                    <form action="{{ route('guru.absensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kelas" value="{{ $selectedKelas->nama }}">
                        
                        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row gap-4 items-center justify-between bg-white dark:bg-slate-900">
                            <div>
                                <label for="tanggal" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Tanggal Absensi</label>
                                <input type="date" id="tanggal" name="tanggal" required value="{{ date('Y-m-d') }}" class="px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600">
                            </div>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-lg text-xs transition-colors shadow-sm">
                                Simpan Absensi Kelas Ini
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                               <thead>
                                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                                        <th class="py-3 px-6">No</th>
                                        <th class="py-3 px-6">Nama Siswa / NISN</th>
                                        <th class="py-3 px-6 text-center">Status Kehadiran</th>
                                    </tr>
                               </thead>
                               <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                                    @foreach($siswaList as $index => $siswa)
                                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                            <td class="py-3 px-6 font-medium text-slate-500 dark:text-slate-400 w-16 text-center">{{ $index + 1 }}</td>
                                            <td class="py-3 px-6">
                                                <strong class="text-slate-900 dark:text-white block">{{ $siswa->name }}</strong>
                                                <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">NISN: {{ $siswa->nisn ?? '-' }}</span>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <select name="status_kehadiran[{{ $siswa->id }}]" class="px-3 py-1.5 border border-slate-300 dark:border-slate-700 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-blue-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                                                    <option value="Hadir" selected>Hadir</option>
                                                    <option value="Sakit">Sakit</option>
                                                    <option value="Izin">Izin</option>
                                                    <option value="Alpa">Alpa</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                               </tbody>
                            </table>
                        </div>
                    </form>
                @else
                    <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                        Silakan pilih kelas terlebih dahulu untuk mengisi absensi siswa.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
