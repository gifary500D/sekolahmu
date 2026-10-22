@extends('layouts.app')

@section('title', 'Buat Tugas Baru')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-800/60">
                <div>
                    <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-1">
                        Formulir Pengajar
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white">Buat Penugasan Baru</h1>
                </div>
                <a href="{{ route('guru.tugas.index') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Kembali
                </a>
            </div>

            @if($errors->any())
                <div class="p-6 sm:px-8 pt-6">
                    <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 rounded-r-lg text-sm">
                        <p class="font-semibold mb-1">Mohon perbaiki kesalahan berikut:</p>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('guru.tugas.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div>
                    <label for="judul" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                    <input type="text" id="judul" name="judul" required value="{{ old('judul') }}" placeholder="Contoh: Laporan Praktikum Fotosintesis" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="mata_pelajaran" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select id="mata_pelajaran" name="mata_pelajaran" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            <optgroup label="Kelompok Umum (Wajib)">
                                <option value="Pendidikan Agama dan Budi Pekerti" {{ old('mata_pelajaran') == 'Pendidikan Agama dan Budi Pekerti' ? 'selected' : '' }}>Pendidikan Agama dan Budi Pekerti</option>
                                <option value="Pendidikan Pancasila dan Kewarganegaraan" {{ old('mata_pelajaran') == 'Pendidikan Pancasila dan Kewarganegaraan' ? 'selected' : '' }}>Pendidikan Pancasila dan Kewarganegaraan</option>
                                <option value="Bahasa Indonesia" {{ old('mata_pelajaran') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="Matematika" {{ old('mata_pelajaran') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                <option value="Sejarah Indonesia" {{ old('mata_pelajaran') == 'Sejarah Indonesia' ? 'selected' : '' }}>Sejarah Indonesia</option>
                                <option value="Bahasa Inggris" {{ old('mata_pelajaran') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                <option value="Seni Budaya" {{ old('mata_pelajaran') == 'Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                                <option value="PJOK" {{ old('mata_pelajaran') == 'PJOK' ? 'selected' : '' }}>PJOK</option>
                                <option value="Prakarya dan Kewirausahaan" {{ old('mata_pelajaran') == 'Prakarya dan Kewirausahaan' ? 'selected' : '' }}>Prakarya dan Kewirausahaan</option>
                            </optgroup>
                            <optgroup label="Peminatan MIPA (IPA)">
                                <option value="Matematika Peminatan" {{ old('mata_pelajaran') == 'Matematika Peminatan' ? 'selected' : '' }}>Matematika Peminatan</option>
                                <option value="Biologi" {{ old('mata_pelajaran') == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                                <option value="Fisika" {{ old('mata_pelajaran') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                                <option value="Kimia" {{ old('mata_pelajaran') == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                            </optgroup>
                            <optgroup label="Peminatan IPS">
                                <option value="Geografi" {{ old('mata_pelajaran') == 'Geografi' ? 'selected' : '' }}>Geografi</option>
                                <option value="Sejarah Peminatan" {{ old('mata_pelajaran') == 'Sejarah Peminatan' ? 'selected' : '' }}>Sejarah Peminatan</option>
                                <option value="Sosiologi" {{ old('mata_pelajaran') == 'Sosiologi' ? 'selected' : '' }}>Sosiologi</option>
                                <option value="Ekonomi" {{ old('mata_pelajaran') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            </optgroup>
                            <optgroup label="Peminatan Kejuruan Terapan (SMK)">
                                <option value="Teknologi Informasi dan Jaringan" {{ old('mata_pelajaran') == 'Teknologi Informasi dan Jaringan' ? 'selected' : '' }}>Teknologi Informasi dan Jaringan</option>
                                <option value="Administrasi dan Akuntansi Terapan" {{ old('mata_pelajaran') == 'Administrasi dan Akuntansi Terapan' ? 'selected' : '' }}>Administrasi dan Akuntansi Terapan</option>
                                <option value="Keahlian Kejuruan Terapan" {{ old('mata_pelajaran') == 'Keahlian Kejuruan Terapan' ? 'selected' : '' }}>Keahlian Kejuruan Terapan</option>
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Target Kelas <span class="text-red-500">*</span></label>
                        <select id="kelas_id" name="kelas_id" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="tenggat" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tenggat Waktu <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="tenggat" name="tenggat" required value="{{ old('tenggat') }}" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                    </div>

                    <div>
                        <label for="prioritas" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tingkat Prioritas <span class="text-red-500">*</span></label>
                        <select id="prioritas" name="prioritas" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">
                            <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Deskripsi &amp; Petunjuk Tugas</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" placeholder="Tuliskan instruksi pengerjaan tugas secara rinci di sini..." class="w-full px-4 py-3 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <a href="{{ route('guru.tugas.index') }}" class="px-6 py-3 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm font-bold shadow-sm transition-all">Terbitkan Tugas</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
