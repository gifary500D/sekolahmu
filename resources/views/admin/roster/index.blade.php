@extends('layouts.app')

@section('title', 'Manajemen Roster / Jadwal Pelajaran')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-amber-50 text-amber-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manajemen Roster &amp; Jadwal Pelajaran</h1>
                <p class="text-slate-600 text-sm mt-1">Kelola jadwal kegiatan belajar mengajar per kelas untuk tahun ajaran aktif.</p>
            </div>
            <div>
                <a href="/dashboard" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-sm font-semibold transition-colors">
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Menambahkan Jadwal</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Roster -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 h-fit">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Tambah Jadwal Pelajaran</h2>
                <form action="{{ route('admin.roster.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-slate-700 mb-1">Rombongan Belajar (Kelas)</label>
                        <select id="kelas_id" name="kelas_id" required class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="mata_pelajaran" class="block text-sm font-semibold text-slate-700 mb-1">Mata Pelajaran</label>
                        <input type="text" id="mata_pelajaran" name="mata_pelajaran" required value="{{ old('mata_pelajaran') }}" placeholder="Contoh: Matematika" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="guru_id" class="block text-sm font-semibold text-slate-700 mb-1">Guru Pengampu</label>
                        <select id="guru_id" name="guru_id" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guruList as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="hari" class="block text-sm font-semibold text-slate-700 mb-1">Hari</label>
                        <select id="hari" name="hari" required class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="jam_mulai" class="block text-sm font-semibold text-slate-700 mb-1">Jam Mulai</label>
                            <input type="time" id="jam_mulai" name="jam_mulai" required value="{{ old('jam_mulai', '07:30') }}" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="jam_selesai" class="block text-sm font-semibold text-slate-700 mb-1">Jam Selesai</label>
                            <input type="time" id="jam_selesai" name="jam_selesai" required value="{{ old('jam_selesai', '09:00') }}" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Ajaran</label>
                            <input type="text" id="tahun_ajaran" name="tahun_ajaran" required value="2026/2027" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="semester" class="block text-sm font-semibold text-slate-700 mb-1">Semester</label>
                            <select id="semester" name="semester" required class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg text-sm transition-colors shadow-sm">
                        Simpan Jadwal Pelajaran
                    </button>
                </form>
            </div>

            <!-- List Roster -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden h-fit">
                <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-900">Daftar Roster &amp; Jadwal</h2>
                    <span class="text-xs text-slate-500 font-semibold">Total: {{ count($rosters) }} Jadwal</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                                <th class="py-3 px-6">Kelas &amp; Hari</th>
                                <th class="py-3 px-6">Mata Pelajaran &amp; Guru</th>
                                <th class="py-3 px-6">Waktu</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            @forelse($rosters as $roster)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-4 px-6">
                                        <span class="font-bold block text-slate-900">{{ $roster->kelas->nama ?? '-' }}</span>
                                        <span class="text-xs text-amber-700 font-semibold uppercase">{{ $roster->hari }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <strong class="text-slate-900 block">{{ $roster->mata_pelajaran }}</strong>
                                        <span class="text-xs text-slate-500">{{ $roster->guru->name ?? 'Belum Ditentukan' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-600 font-mono">
                                        {{ substr($roster->jam_mulai, 0, 5) }} - {{ substr($roster->jam_selesai, 0, 5) }} WIB
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <form action="{{ route('admin.roster.delete', $roster->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 font-semibold rounded-lg text-xs transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500 text-sm">Belum ada jadwal pelajaran (roster) yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
