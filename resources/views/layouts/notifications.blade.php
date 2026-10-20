@extends('layouts.app')

@section('title', 'Pusat Notifikasi')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pusat Notifikasi &amp; Pengumuman</h1>
                <p class="text-sm text-slate-500">Riwayat pemberitahuan sistem dan pengingat tenggat tugas.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm inline-flex items-center gap-2">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-slate-900">Daftar Pemberitahuan</h2>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">Total: {{ $notifications->total() ?? $notifications->count() }}</span>
            </div>
            <div class="divide-y divide-slate-200">
                @forelse($notifications as $notif)
                    <div class="p-5 hover:bg-slate-50 transition-colors flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center flex-shrink-0 font-bold text-sm">
                            🔔
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-900 mb-1">{{ json_decode($notif->data)->title ?? 'Pemberitahuan Sistem' }}</p>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ json_decode($notif->data)->message ?? 'Anda memiliki pemberitahuan baru.' }}</p>
                            <span class="text-[10px] text-slate-400 mt-2 block">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="py-16 text-center text-slate-400 text-xs">
                        Belum ada pemberitahuan atau pesan baru saat ini.
                    </div>
                @endforelse
            </div>
            @if(method_exists($notifications, 'links'))
                <div class="p-6 border-t border-slate-100">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
