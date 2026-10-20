@extends('layouts.app')

@section('title', 'Masuk Sistem')

@section('content')
<div class="min-h-[calc(100vh-160px)] bg-slate-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8 sm:p-10">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-3">
                Autentikasi Pengguna
            </span>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Masuk ke Portal</h1>
            <p class="text-slate-600 text-sm mt-1">SMA Pemda Bahorok, Kabupaten Langkat</p>
        </div>

        <!-- Errors -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm">
                <p class="font-semibold mb-1">Gagal Masuk</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-5" id="loginForm">
            @csrf
            
            <div>
                <label for="login" class="block text-sm font-semibold text-slate-700 mb-1.5">Email atau NISN</label>
                <input 
                    id="login" 
                    name="login" 
                    type="text" 
                    required 
                    value="{{ old('login') }}"
                    placeholder="Masukkan Email atau NISN Anda"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                >
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-slate-700 font-medium">Ingat saya</span>
                </label>
                <a href="#" class="text-blue-600 font-semibold hover:underline">Lupa sandi?</a>
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-sm transition-all shadow-sm active:scale-[0.99]"
            >
                Masuk Sistem
            </button>
        </form>

        <!-- Quick Demo Login Helper Box -->
        <div class="mt-8 pt-6 border-t border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3 text-center">Demo Cepat Akses (Klik untuk Isi)</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillDemo('suclyn@sekolah.sch.id', 'password')" class="px-2 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-800 rounded-xl text-xs font-bold transition-colors border border-blue-200 flex flex-col items-center gap-0.5">
                    <span>Admin</span>
                    <span class="text-[10px] font-normal text-blue-600">Suclyn</span>
                </button>
                <button type="button" onclick="fillDemo('rina.kartika@demo.sch.id', 'password')" class="px-2 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-bold transition-colors border border-emerald-200 flex flex-col items-center gap-0.5">
                    <span>Guru</span>
                    <span class="text-[10px] font-normal text-emerald-600">Rina S.Pd</span>
                </button>
                <button type="button" onclick="fillDemo('alya.murid@demo.sch.id', 'password')" class="px-2 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-xl text-xs font-bold transition-colors border border-amber-200 flex flex-col items-center gap-0.5">
                    <span>Siswa</span>
                    <span class="text-[10px] font-normal text-amber-600">Alya (NISN)</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
function fillDemo(login, password) {
    document.getElementById('login').value = login;
    document.getElementById('password').value = password;
}
</script>
@endsection
