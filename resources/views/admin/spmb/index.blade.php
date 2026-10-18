@extends('layouts.app')

@section('title', 'Verifikasi Pendaftar SPMB')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-blue-50 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Administrator
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Verifikasi Pendaftar SPMB</h1>
                <p class="text-slate-600 text-sm mt-1">Kelola dan perbarui status seleksi pendaftaran siswa baru SMA Pemda Bahorok.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.spmb.export') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel (.xls)
                </a>
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

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Memperbarui Status</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Applicants Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900">Daftar Pendaftar SPMB</h2>
                <span class="text-xs text-slate-500">Total: {{ count($applicants) }} Pendaftar</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">No. Pendaftaran &amp; Nama</th>
                            <th class="py-3 px-6">NISN / Asal Sekolah</th>
                            <th class="py-3 px-6">Jalur / Program</th>
                            <th class="py-3 px-6">Status Saat Ini</th>
                            <th class="py-3 px-6 text-right">Ubah Status / Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($applicants as $applicant)
                            <tr class="hover:bg-slate-50/80 transition-colors align-top">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 block text-base mb-0.5">{{ $applicant->nama_lengkap }}</strong>
                                    <span class="text-xs text-blue-700 font-mono font-semibold">{{ $applicant->nomor_pendaftaran }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-mono text-xs block mb-0.5">NISN: {{ $applicant->nisn }}</span>
                                    <span class="text-xs text-slate-500">{{ $applicant->asal_sekolah }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-semibold block text-slate-900">{{ $applicant->jalur_pendaftaran }}</span>
                                    <span class="text-xs text-slate-500 uppercase">Program {{ $applicant->program }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $badgeColor = match($applicant->status) {
                                            'Diterima' => 'bg-emerald-50 text-emerald-800',
                                            'Terverifikasi' => 'bg-blue-50 text-blue-800',
                                            'Sedang Diverifikasi' => 'bg-amber-50 text-amber-800',
                                            'Ditolak' => 'bg-red-50 text-red-800',
                                            default => 'bg-slate-100 text-slate-700'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded {{ $badgeColor }} text-xs font-semibold inline-block mb-1">
                                        {{ $applicant->status }}
                                    </span>
                                    @if($applicant->note)
                                        <p class="text-[11px] text-slate-500 italic">Catatan: {{ $applicant->note }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route('admin.spmb.status', $applicant->id) }}" method="POST" class="space-y-2 inline-block text-left">
                                        @csrf
                                        <div class="flex items-center gap-2 justify-end">
                                            <select name="status" required class="px-3 py-1.5 border border-slate-300 rounded-lg text-xs font-semibold focus:ring-2 focus:ring-blue-600 bg-white">
                                                <option value="Menunggu Verifikasi" {{ $applicant->status == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                                <option value="Sedang Diverifikasi" {{ $applicant->status == 'Sedang Diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
                                                <option value="Terverifikasi" {{ $applicant->status == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                                <option value="Diterima" {{ $applicant->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                                <option value="Ditolak" {{ $applicant->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-semibold transition-colors">
                                                Simpan
                                            </button>
                                        </div>
                                        <input type="text" name="note" value="{{ old('note', $applicant->note) }}" placeholder="Catatan verifikasi..." class="w-full px-3 py-1.5 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-600">
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">Belum ada pendaftar SPMB.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
