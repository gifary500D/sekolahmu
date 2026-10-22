@extends('layouts.app')

@section('title', 'Masuk Sistem')

@section('content')
<div class="min-h-[calc(100vh-160px)] bg-slate-100 dark:bg-slate-950 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 transition-colors">
    <div class="max-w-md w-full bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 sm:p-10">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 mb-3 shadow-sm">
                <img src="{{ asset('images/logo-pendidikan.svg') }}" alt="Logo Pendidikan" class="w-10 h-10 object-contain drop-shadow-sm" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><polygon points=\'50,5 95,38 77,90 23,90 5,38\' fill=\'%230F2F6B\' stroke=\'%23F59E0B\' stroke-width=\'5\'/><circle cx=\'50\' cy=\'50\' r=\'18\' fill=\'%23F59E0B\'/></svg>';">
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Masuk ke Portal</h1>
            <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">SMA/SMK Pemda Bahorok, Kabupaten Langkat</p>
        </div>

        <!-- Errors -->
        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/60 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm">
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
                <label for="login" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email atau NISN</label>
                <input 
                    id="login" 
                    name="login" 
                    type="text" 
                    required 
                    value="{{ old('login') }}"
                    placeholder="Masukkan Email atau NISN Anda"
                    class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    required 
                    placeholder="••••••••"
                    class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-sm transition-all"
                >
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded focus:ring-blue-500">
                    <span class="ml-2 text-slate-700 dark:text-slate-300 font-medium">Ingat saya</span>
                </label>
                <a href="#" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Lupa sandi?</a>
            </div>

            <button 
                type="submit" 
                class="w-full py-3 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-sm transition-all shadow-sm active:scale-[0.99]"
            >
                Masuk Sistem
            </button>
        </form>

        <!-- Quick Demo Login Helper Box -->
        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800">
            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3 text-center">Demo Cepat Akses (Klik untuk Isi)</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="fillDemo('suclyn@sekolah.sch.id', 'password')" class="px-2 py-2.5 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900/60 text-blue-800 dark:text-blue-300 rounded-xl text-xs font-bold transition-colors border border-blue-200 dark:border-blue-800 flex flex-col items-center gap-0.5">
                    <span>Admin</span>
                    <span class="text-[10px] font-normal text-blue-600 dark:text-blue-400">Suclyn</span>
                </button>
                <button type="button" onclick="fillDemo('rina.kartika@demo.sch.id', 'password')" class="px-2 py-2.5 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 text-emerald-800 dark:text-emerald-300 rounded-xl text-xs font-bold transition-colors border border-emerald-200 dark:border-emerald-800 flex flex-col items-center gap-0.5">
                    <span>Guru</span>
                    <span class="text-[10px] font-normal text-emerald-600 dark:text-emerald-400">Rina S.Pd</span>
                </button>
                <button type="button" onclick="fillDemo('alya.murid@demo.sch.id', 'password')" class="px-2 py-2.5 bg-amber-50 dark:bg-amber-950/60 hover:bg-amber-100 dark:hover:bg-amber-900/60 text-amber-800 dark:text-amber-300 rounded-xl text-xs font-bold transition-colors border border-amber-200 dark:border-amber-800 flex flex-col items-center gap-0.5">
                    <span>Siswa</span>
                    <span class="text-[10px] font-normal text-amber-600 dark:text-amber-400">Alya (NISN)</span>
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
