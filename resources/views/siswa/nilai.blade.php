@extends('layouts.app')

@section('title', 'Transkrip Nilai Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Transkrip &amp; Rekapitulasi Nilai Tugas</h1>
                <p class="text-sm text-slate-500">Daftar nilai dan catatan evaluasi dari guru pengampu atas tugas yang telah dikumpulkan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center gap-2 self-start">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-slate-900">Riwayat Penilaian Tugas</h2>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">Total Dikumpulkan: {{ $submissions->count() }} Tugas</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[11px] uppercase tracking-wider border-b border-slate-200">
                            <th class="py-3 px-6">Mata Pelajaran / Tugas</th>
                            <th class="py-3 px-6">Tanggal Pengumpulan</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Nilai Angka</th>
                            <th class="py-3 px-6">Catatan / Feedback Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-xs text-slate-700">
                        @forelse($submissions as $sub)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block mb-0.5">{{ $sub->tugas->judul ?? '-' }}</span>
                                    <span class="text-[11px] text-blue-600 font-semibold">{{ $sub->tugas->mata_pelajaran ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6 text-slate-500">
                                    {{ $sub->diselesaikan_pada ? $sub->diselesaikan_pada->format('d M Y, H:i') : $sub->updated_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $sub->nilai !== null ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $sub->nilai !== null ? 'Sudah Dinilai' : 'Menunggu Penilaian' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($sub->nilai !== null)
                                        <span class="text-base font-black text-blue-700">{{ $sub->nilai }}</span>
                                    @else
                                        <span class="text-slate-400 font-medium">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-slate-600 italic">
                                    {{ $sub->catatan ?? 'Belum ada catatan dari guru.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 text-xs">Belum ada tugas yang dikumpulkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
