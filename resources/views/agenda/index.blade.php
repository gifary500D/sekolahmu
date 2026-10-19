@extends('layouts.app')

@section('title', 'Agenda Kegiatan Sekolah')

@section('content')
<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <span class="inline-block text-amber-600 font-bold tracking-widest text-xs uppercase mb-2 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">Kalender Akademik</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">Agenda Kegiatan Sekolah</h1>
            <p class="text-slate-600 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Catat tanggal penting, jadwal ujian, kegiatan ekstrakurikuler, dan acara resmi SMA Pemda Bahorok.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($agendaList ?? [] as $ag)
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-lg text-xs font-bold inline-block mb-3">
                            {{ \Carbon\Carbon::parse($ag->mulai)->format('d M Y') }}
                        </span>
                        <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $ag->judul }}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $ag->deskripsi ?? 'Kegiatan resmi sekolah.' }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold inline-block mb-3">25 Okt 2026</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Ujian Tengah Semester (UTS)</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pelaksanaan UTS Genap seluruh tingkat kelas X, XI, dan XII.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-lg text-xs font-bold inline-block mb-3">02 Nov 2026</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Pekan Olahraga Antar Kelas</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pertandingan persahabatan futsal, basket, dan bulu tangkis antar kelas.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-lg text-xs font-bold inline-block mb-3">15 Nov 2026</span>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Pameran Karya Seni Siswa</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">Pameran seni rupa dan prakarya hasil praktik siswa seni budaya.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($agendaList, 'links'))
            <div class="mt-12">
                {{ $agendaList->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
