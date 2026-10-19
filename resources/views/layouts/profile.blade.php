@extends('layouts.app')

@section('title', 'Profil & Pengaturan Akun')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Profil &amp; Keamanan Akun</h1>
                <p class="text-sm text-slate-500">Perbarui informasi profil atau ganti kata sandi akun Anda.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center gap-2">
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
                <b>Mohon perbaiki kesalahan berikut:</b>
                <ul class="list-disc list-inside mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Ubah Kata Sandi (Opsional)</h3>
                    <p class="text-xs text-slate-500 mb-4">Biarkan kosong jika tidak ingin mengubah kata sandi saat ini.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-3 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-bold transition-colors shadow-sm">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
