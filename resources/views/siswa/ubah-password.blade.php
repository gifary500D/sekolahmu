@extends('layouts.app')

@section('title', 'Ubah Kata Sandi Wajib')

@section('content')
<div class="min-h-[calc(100vh-160px)] bg-slate-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-10">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-md bg-amber-50 text-amber-800 text-xs font-semibold uppercase tracking-wider mb-3">
                Keamanan Akun Wajib
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Ubah Kata Sandi</h1>
            <p class="text-slate-600 text-sm mt-1">Demi keamanan akun, Anda diwajibkan mengganti kata sandi default sebelum mengakses Portal Siswa.</p>
        </div>

        <!-- Errors -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm">
                <p class="font-semibold mb-1">Gagal Memperbarui Kata Sandi</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('siswa.password.update') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    minlength="8"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm transition-all"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    required 
                    minlength="8"
                    placeholder="Ulangi kata sandi baru"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 text-sm transition-all"
                >
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-sm transition-all shadow-sm active:scale-[0.99]"
            >
                Simpan &amp; Lanjutkan ke Dashboard
            </button>
        </form>

    </div>
</div>
@endsection
