@extends('layouts.app')

@section('title', 'Manajemen Master Kelas')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Master Kelas</h1>
                <p class="text-sm text-slate-500">Kelola daftar rombongan belajar, tingkat, program keahlian, dan wali kelas.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center gap-2 self-start">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-xl shadow-sm text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 mb-6 rounded-r-xl shadow-sm text-xs">
                <b>Mohon periksa kembali input Anda:</b>
                <ul class="list-disc list-inside mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Kelas -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-fit">
                <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">Tambah Kelas Baru</h2>
                <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kelas <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" required placeholder="Contoh: X IPA 1" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Tingkat <span class="text-rose-500">*</span></label>
                        <select name="tingkat" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                            <option value="10">Kelas 10 (X)</option>
                            <option value="11">Kelas 11 (XI)</option>
                            <option value="12">Kelas 12 (XII)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Program / Jurusan <span class="text-rose-500">*</span></label>
                        <select name="program" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                            <option value="ipa">IPA (Ilmu Pengetahuan Alam)</option>
                            <option value="ips">IPS (Ilmu Pengetahuan Sosial)</option>
                            <option value="bahasa">Bahasa & Budaya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Wali Kelas</label>
                        <select name="wali_kelas_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                            <option value="">-- Pilih Guru Wali Kelas --</option>
                            @foreach($guruList as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-semibold transition-colors shadow-sm">
                        Simpan Kelas Baru
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Kelas -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h2 class="text-base font-bold text-slate-900">Daftar Rombongan Belajar</h2>
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">Total: {{ $kelasList->count() }} Kelas</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Nama Kelas</th>
                                <th class="py-3 px-4">Tingkat / Program</th>
                                <th class="py-3 px-4">Wali Kelas</th>
                                <th class="py-3 px-4">Jumlah Siswa</th>
                                <th class="py-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-xs text-slate-700">
                            @forelse($kelasList as $index => $kelas)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-4 font-semibold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $kelas->nama }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-md font-medium">Kelas {{ $kelas->tingkat }}</span>
                                        <span class="uppercase text-[10px] font-bold text-blue-700 ml-1">({{ $kelas->program }})</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $kelas->waliKelas->name ?? 'Belum ditentukan' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md font-semibold">{{ $kelas->siswa_count }} Siswa</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <form action="{{ route('admin.kelas.delete', $kelas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg font-semibold transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data kelas yang terdaftar.</td>
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
