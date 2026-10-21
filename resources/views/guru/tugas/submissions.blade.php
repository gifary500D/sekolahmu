@extends('layouts.app')

@section('title', 'Pengumpulan & Penilaian Tugas Siswa')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Evaluasi &amp; Penilaian
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">{{ $tugas->judul }}</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Kelas: <strong class="text-slate-900 dark:text-white">{{ $tugas->kelas->nama ?? 'Semua Kelas' }}</strong> · Mata Pelajaran: {{ $tugas->mata_pelajaran }} · Tenggat: <span class="font-mono text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $tugas->tenggat ? \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y, H:i') : '-' }}</span></p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.tugas.export', $tugas->id) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Nilai (.xls)
                </a>
                <a href="{{ route('guru.tugas.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Kembali
                </a>
            </div>
        </div>

        @if($tugas->deskripsi)
            <div class="bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900/60 rounded-xl p-5 mb-8 text-xs text-slate-700 dark:text-slate-300 shadow-sm">
                <span class="inline-block px-2.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-200 font-bold uppercase tracking-wider text-[10px] mb-2">Petunjuk &amp; Instruksi Tugas</span>
                <p class="whitespace-pre-line leading-relaxed text-sm text-slate-800 dark:text-slate-200">{{ $tugas->deskripsi }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 dark:bg-red-950/40 border-l-4 border-red-500 text-red-800 dark:text-red-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold mb-1">Gagal Menyimpan Penilaian</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Submissions Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Pengumpulan &amp; Nilai Siswa</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Total Siswa: {{ count($siswaList) }}</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Nama Siswa / NISN</th>
                            <th class="py-3 px-6">Status Pengerjaan</th>
                            <th class="py-3 px-6">Berkas Lampiran</th>
                            <th class="py-3 px-6">Input Nilai &amp; Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($siswaList as $siswa)
                            @php
                                $sub = $submissions[$siswa->id] ?? null;
                                $status = $sub ? $sub->status : 'belum';
                                $fileExt = $sub && $sub->file_path ? pathinfo($sub->file_path, PATHINFO_EXTENSION) : '';
                                $isImage = in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png']);
                                $isPdf = strtolower($fileExt) === 'pdf';
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors align-top">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 dark:text-white block text-base mb-0.5">{{ $siswa->name }}</strong>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">NISN: {{ $siswa->nisn ?? '-' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($status === 'selesai')
                                        <span class="px-2.5 py-1 rounded bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold inline-block mb-1">Sudah Dikumpulkan</span>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 block">Waktu: {{ $sub && $sub->diselesaikan_pada ? $sub->diselesaikan_pada->format('d M Y, H:i') : '-' }}</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-semibold">Belum Mengumpulkan</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($sub && $sub->file_path)
                                        <div class="flex items-center gap-2">
                                            <button 
                                                type="button" 
                                                onclick="openPreview('{{ route('guru.tugas.preview', $sub->id) }}', '{{ $isImage ? 'image' : ($isPdf ? 'pdf' : 'other') }}', '{{ addslashes($siswa->name) }}', '{{ route('guru.tugas.download', $sub->id) }}')"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 rounded text-xs font-semibold transition-colors"
                                            >
                                                Pratinjau
                                            </button>
                                            <a href="{{ route('guru.tugas.download', $sub->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/60 rounded text-xs font-semibold transition-colors">
                                                Unduh
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Tidak ada berkas</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($sub)
                                        <form action="{{ route('guru.tugas.grade', $sub->id) }}" method="POST" class="space-y-2">
                                            @csrf
                                            <div class="flex items-center gap-2">
                                                <input 
                                                    type="number" 
                                                    name="nilai" 
                                                    step="0.01" 
                                                    min="0" 
                                                    max="100" 
                                                    required 
                                                    value="{{ old('nilai', $sub->nilai) }}" 
                                                    placeholder="Nilai (0-100)" 
                                                    class="w-28 px-3 py-1.5 border border-slate-300 dark:border-slate-700 rounded-lg text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-600 font-mono font-bold"
                                                >
                                                <button type="submit" class="px-3 py-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-xs font-semibold transition-colors">
                                                    Simpan
                                                </button>
                                            </div>
                                            <input 
                                                type="text" 
                                                name="catatan" 
                                                value="{{ old('catatan', $sub->catatan) }}" 
                                                placeholder="Catatan / masukan untuk siswa..." 
                                                class="w-full px-3 py-1.5 border border-slate-300 dark:border-slate-700 rounded-lg text-xs bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:ring-2 focus:ring-blue-600"
                                            >
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Siswa belum mengumpulkan tugas</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">Tidak ada siswa terdaftar di kelas ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal Pratinjau Berkas -->
<div id="previewModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-4xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="p-4 sm:p-6 bg-slate-900 dark:bg-slate-950 text-white flex justify-between items-center">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-400 block mb-0.5">Pratinjau Tugas Siswa</span>
                <h3 id="modalStudentName" class="font-bold text-lg text-white">Nama Siswa</h3>
            </div>
            <div class="flex items-center gap-2">
                <a id="modalDownloadBtn" href="#" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg text-xs font-semibold transition-colors flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh
                </a>
                <button type="button" onclick="closePreview()" class="w-9 h-9 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div class="p-6 flex-1 overflow-auto bg-slate-900/5 dark:bg-slate-950/40 flex items-center justify-center min-h-[400px]">
            <div id="previewContainer" class="w-full h-full flex items-center justify-center">
                <!-- Dynamically injected preview -->
            </div>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-200 dark:border-slate-800 flex justify-end">
            <button type="button" onclick="closePreview()" class="px-5 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
function openPreview(url, type, studentName, downloadUrl) {
    const modal = document.getElementById('previewModal');
    const container = document.getElementById('previewContainer');
    const downloadBtn = document.getElementById('modalDownloadBtn');

    document.getElementById('modalStudentName').innerText = 'Berkas Lampiran - ' + studentName;
    if (downloadBtn) {
        downloadBtn.href = downloadUrl || url;
    }

    container.innerHTML = '';
    if (type === 'image') {
        container.innerHTML = `<img src="${url}" alt="Pratinjau Tugas" class="max-w-full max-h-[70vh] rounded-lg shadow-md object-contain">`;
    } else if (type === 'pdf') {
        container.innerHTML = `<iframe src="${url}" class="w-full h-[70vh] rounded-lg border border-slate-200 dark:border-slate-700"></iframe>`;
    } else {
        container.innerHTML = `
            <div class="text-center p-8 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 max-w-md mx-auto">
                <svg class="w-14 h-14 text-slate-400 dark:text-slate-500 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Format Dokumen Biner</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Berkas ini (DOC/DOCX/Arsip) tidak dapat ditampilkan langsung di peramban web. Silakan unduh berkas untuk memeriksanya di aplikasi pembaca dokumen Anda.</p>
                <a href="${downloadUrl || url}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                    Unduh Berkas Sekarang
                </a>
            </div>
        `;
    }

    modal.classList.remove('hidden');
}

function closePreview() {
    const modal = document.getElementById('previewModal');
    modal.classList.add('hidden');
    document.getElementById('previewContainer').innerHTML = '';
}
</script>
@endsection
