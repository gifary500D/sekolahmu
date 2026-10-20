@extends('layouts.app')

@section('title', 'Manajemen Pengguna Sistem')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Manajemen Pengguna Sistem</h1>
                <p class="text-slate-600 text-sm mt-1">Kelola akun Admin, Guru, dan Siswa SMA Pemda Bahorok.</p>
            </div>
            <div>
                <a href="/dashboard" class="inline-flex items-center px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-sm font-semibold transition-colors">
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

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Kesalahan</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Menambahkan Pengguna</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Tambah Pengguna Baru -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 h-fit">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Tambah Pengguna Baru</h2>
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Nama lengkap & gelar" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="email@sekolah.sch.id" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1">NISN (Khusus Siswa)</label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" placeholder="10 digit NISN" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">Peran (Role)</label>
                        <select id="role" name="role" required class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru / Pengajar</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>

                    <div>
                        <label for="kelas_id" class="block text-sm font-semibold text-slate-700 mb-1">Kelas (Opsional untuk Siswa)</label>
                        <select id="kelas_id" name="kelas_id" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                        <input type="password" id="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" class="w-full px-3 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600">
                    </div>

                    <button type="submit" class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-sm transition-colors shadow-sm">
                        Simpan Pengguna Baru
                    </button>
                </form>
            </div>

            <!-- List Pengguna -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-slate-900">Daftar Pengguna Sistem</h2>
                    <span class="text-xs text-slate-500">Total: {{ count($users) }} Akun</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                                <th class="py-3 px-6">Nama &amp; Email</th>
                                <th class="py-3 px-6">Peran</th>
                                <th class="py-3 px-6">Kelas / NISN</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-4 px-6">
                                        <strong class="text-slate-900 block text-base mb-0.5">{{ $user->name }}</strong>
                                        <span class="text-xs text-slate-500">{{ $user->email }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $roleColor = match($user->role) {
                                                'admin' => 'bg-red-50 text-red-800',
                                                'guru' => 'bg-emerald-50 text-emerald-800',
                                                default => 'bg-blue-50 text-blue-800'
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded {{ $roleColor }} text-xs font-semibold uppercase">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-xs text-slate-600">
                                        @if($user->isSiswa())
                                            <span class="font-semibold text-slate-900 block mb-1">Kelas Saat Ini: {{ $user->kelas->nama ?? 'Belum ada kelas' }}</span>
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="flex items-center gap-2 mt-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="name" value="{{ $user->name }}">
                                                <input type="hidden" name="email" value="{{ $user->email }}">
                                                <input type="hidden" name="role" value="{{ $user->role }}">
                                                <input type="hidden" name="nisn" value="{{ $user->nisn }}">
                                                <select name="kelas_id" onchange="this.form.submit()" class="px-2.5 py-1.5 border border-slate-300 rounded-lg text-xs bg-white font-medium focus:ring-2 focus:ring-blue-600 text-slate-800">
                                                    <option value="">-- Pilih / Ubah Kelas --</option>
                                                    @foreach($kelasList as $kelas)
                                                        <option value="{{ $kelas->id }}" {{ $user->kelas_id == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            <span class="text-[11px] text-slate-500 block mt-1">NISN: {{ $user->nisn ?? '-' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg text-xs font-semibold transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500">Belum ada pengguna.</td>
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
