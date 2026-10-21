@extends('layouts.app')

@section('title', 'Kelola Tugas Guru')

@section('content')
<div class="min-h-screen bg-slate-100 dark:bg-slate-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Banner -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="inline-block px-3 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-semibold uppercase tracking-wider mb-2">
                    Panel Guru &amp; Pengajar
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Kelola Tugas &amp; Penugasan</h1>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Buat tugas baru, pantau pengumpulan siswa, atau hapus tugas yang telah berakhir.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('guru.tugas.create') }}" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm font-bold shadow-sm transition-all">
                    + Buat Tugas Baru
                </a>
                <a href="/dashboard" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-sm font-semibold transition-colors">
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 dark:bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 p-4 mb-6 rounded-r-lg text-sm shadow-sm">
                <p class="font-semibold">Berhasil</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Task List Table -->
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Tugas yang Anda Buat</h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Total: {{ count($tugasList) }} Tugas</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-6">Judul &amp; Mata Pelajaran</th>
                            <th class="py-3 px-6">Kelas</th>
                            <th class="py-3 px-6">Prioritas</th>
                            <th class="py-3 px-6">Tenggat Waktu</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($tugasList as $tugas)
                            @php
                                $isExpired = now()->greaterThan(\Carbon\Carbon::parse($tugas->tenggat));
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-6">
                                    <strong class="text-slate-900 dark:text-white block text-base mb-0.5">{{ $tugas->judul }}</strong>
                                    <span class="text-xs text-blue-700 dark:text-blue-400 font-medium block">{{ $tugas->mata_pelajaran }}</span>
                                </td>
                                <td class="py-4 px-6 font-semibold">{{ $tugas->kelas->nama ?? 'Semua Kelas' }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded text-xs font-semibold {{ $tugas->prioritas === 'tinggi' ? 'bg-red-50 dark:bg-red-950/60 text-red-700 dark:text-red-300' : ($tugas->prioritas === 'sedang' ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300') }}">
                                        {{ ucfirst($tugas->prioritas) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-mono text-xs {{ $isExpired ? 'text-red-600 dark:text-red-400 font-bold' : 'text-slate-700 dark:text-slate-300 font-semibold' }}">
                                    {{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y, H:i') }}
                                    @if($isExpired)
                                        <span class="block text-[10px] text-red-500 dark:text-red-400 font-sans font-bold">(Tenggat Terlewat)</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                    <button 
                                        type="button" 
                                        onclick="openTaskModal('{{ addslashes($tugas->judul) }}', '{{ addslashes($tugas->mata_pelajaran) }}', '{{ addslashes($tugas->kelas->nama ?? 'Semua Kelas') }}', '{{ ucfirst($tugas->prioritas) }}', '{{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y, H:i') }}', '{{ addslashes(str_replace(["\r\n", "\r", "\n"], '\n', $tugas->deskripsi ?? 'Tidak ada petunjuk tambahan.')) }}', '{{ route('guru.tugas.submissions', $tugas->id) }}')"
                                        class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-xs font-semibold transition-colors inline-block"
                                    >
                                        Pratinjau
                                    </button>
                                    <a href="{{ route('guru.tugas.submissions', $tugas->id) }}" class="px-3 py-1.5 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 dark:hover:bg-blue-900/60 text-blue-800 dark:text-blue-300 rounded-lg text-xs font-semibold transition-colors inline-block">
                                        Periksa
                                    </a>
                                    <form action="{{ route('guru.tugas.delete', $tugas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 dark:bg-red-950/50 hover:bg-red-100 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg text-xs font-semibold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400">Anda belum membuat tugas apapun.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal Pratinjau Detail Tugas -->
<div id="taskDetailModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="p-4 sm:p-6 bg-slate-900 dark:bg-slate-950 text-white flex justify-between items-center">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-400 block mb-0.5">Pratinjau &amp; Detail Tugas</span>
                <h3 id="modalTaskTitle" class="font-bold text-lg text-white">Judul Tugas</h3>
            </div>
            <button type="button" onclick="closeTaskModal()" class="w-9 h-9 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700 hover:text-white flex items-center justify-center transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6 space-y-4 overflow-y-auto">
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <span class="text-slate-500 dark:text-slate-400 block mb-0.5">Mata Pelajaran:</span>
                    <strong id="modalTaskSubject" class="text-slate-900 dark:text-white font-semibold text-sm"></strong>
                </div>
                <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <span class="text-slate-500 dark:text-slate-400 block mb-0.5">Target Kelas:</span>
                    <strong id="modalTaskClass" class="text-slate-900 dark:text-white font-semibold text-sm"></strong>
                </div>
                <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <span class="text-slate-500 dark:text-slate-400 block mb-0.5">Tingkat Prioritas:</span>
                    <strong id="modalTaskPriority" class="text-slate-900 dark:text-white font-semibold text-sm"></strong>
                </div>
                <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                    <span class="text-slate-500 dark:text-slate-400 block mb-0.5">Tenggat Waktu:</span>
                    <strong id="modalTaskDeadline" class="text-slate-900 dark:text-white font-semibold text-sm"></strong>
                </div>
            </div>
            <div class="p-4 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-700">
                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Petunjuk &amp; Instruksi Pengerjaan:</h4>
                <p id="modalTaskDesc" class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed"></p>
            </div>
        </div>
        <div class="p-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <a id="modalSubmissionsLink" href="#" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
                Periksa Pengumpulan Siswa &rarr;
            </a>
            <button type="button" onclick="closeTaskModal()" class="px-5 py-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-lg text-xs font-semibold transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openTaskModal(title, subject, className, priority, deadline, desc, subUrl) {
    document.getElementById('modalTaskTitle').textContent = title;
    document.getElementById('modalTaskSubject').textContent = subject;
    document.getElementById('modalTaskClass').textContent = className;
    document.getElementById('modalTaskPriority').textContent = priority;
    document.getElementById('modalTaskDeadline').textContent = deadline;
    document.getElementById('modalTaskDesc').textContent = desc;
    document.getElementById('modalSubmissionsLink').href = subUrl;
    document.getElementById('taskDetailModal').classList.remove('hidden');
}

function closeTaskModal() {
    document.getElementById('taskDetailModal').classList.add('hidden');
}
</script>
@endsection
