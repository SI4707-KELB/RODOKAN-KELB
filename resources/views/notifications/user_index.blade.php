@extends('layouts.dashboard')

@section('title', 'Notifikasi - RODOKAN')

@php
$unread = $notifications->filter(fn($n) => $n->read_at === null);
$read = $notifications->filter(fn($n) => $n->read_at !== null);

$iconByStatus = [
    'Selesai' => ['bg' => 'bg-green-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'],
    'Terverifikasi' => ['bg' => 'bg-green-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>'],
    'Diproses' => ['bg' => 'bg-blue-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
    'Ditindaklanjuti' => ['bg' => 'bg-orange-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
    'Darurat' => ['bg' => 'bg-red-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'],
];
$defaultIcon = ['bg' => 'bg-blue-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'];
@endphp

@section('content')
<div class="p-3 sm:p-4 md:p-6 max-w-4xl mx-auto w-full">
    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-4 sm:mb-6">Notifikasi</h1>

    <div class="bg-white rounded-xl border border-slate-200 p-3 sm:p-4 md:p-5 mb-4 sm:mb-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h2 class="text-sm sm:text-base font-bold text-slate-800">Semua Notifikasi</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Anda memiliki <strong>{{ $unread->count() }}</strong> notifikasi yang belum dibaca
            </p>
        </div>
        @if($notifications->isNotEmpty())
        <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm font-medium">
            @if($unread->isNotEmpty())
            <button type="button" id="mark-all-read" class="text-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">Tandai Semua Dibaca</button>
            @endif
            <button type="button" id="delete-all" class="text-slate-500 hover:text-slate-700 transition-colors whitespace-nowrap">Hapus Semua</button>
        </div>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="text-center py-12 sm:py-16 text-slate-400">
            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <p class="text-xs sm:text-sm font-medium mt-2">Belum ada notifikasi</p>
        </div>
    @else
        @if($unread->isNotEmpty())
        <div class="bg-[#f8fbff] rounded-xl border border-blue-100 border-l-4 border-l-blue-600 shadow-sm mb-4 sm:mb-6 overflow-hidden">
            <div class="px-3 sm:px-4 md:px-5 py-2.5 sm:py-3 border-b border-blue-100/50 bg-[#f0f6ff]/50">
                <h3 class="text-[10px] sm:text-xs font-bold text-blue-800 uppercase tracking-wider">Belum Dibaca</h3>
            </div>
            <div class="divide-y divide-blue-100/50" id="unread-list">
                @foreach($unread as $notification)
                    @php $data = $notification->data ?? []; @endphp
                    <div class="p-3 sm:p-4 md:p-5 flex justify-between items-start group hover:bg-blue-50/50 transition-colors" data-id="{{ $notification->id }}">
                        <a href="{{ route('notifications.show', $notification->id) }}" class="flex gap-2 sm:gap-3 md:gap-4 flex-1 min-w-0">
                            @php $notifIcon = $iconByStatus[$data['status_baru'] ?? ''] ?? $defaultIcon; @endphp
                            <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full {{ $notifIcon['bg'] }} text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px] md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $notifIcon['svg'] !!}</svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $data['message'] ?? 'Notifikasi' }}</h4>
                                <p class="text-xs sm:text-sm text-slate-600 mt-0.5 sm:mt-1 mb-1 sm:mb-2 line-clamp-2">{{ $data['catatan'] ?? 'Status laporan diperbarui.' }}</p>
                                <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs font-medium text-slate-500">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                        <button type="button" class="delete-notif text-slate-400 hover:text-slate-600 p-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity shrink-0 ml-1.5 sm:ml-2 self-start" data-id="{{ $notification->id }}">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($read->isNotEmpty())
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-3 sm:px-4 md:px-5 py-2.5 sm:py-3 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider">Sudah Dibaca</h3>
            </div>
            <div class="divide-y divide-slate-100" id="read-list">
                @foreach($read as $notification)
                    @php $data = $notification->data ?? []; @endphp
                    <div class="p-3 sm:p-4 md:p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors" data-id="{{ $notification->id }}">
                        <a href="{{ route('notifications.show', $notification->id) }}" class="flex gap-2 sm:gap-3 md:gap-4 flex-1 min-w-0">
                            @php $notifIcon = $iconByStatus[$data['status_baru'] ?? ''] ?? $defaultIcon; @endphp
                            <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full {{ $notifIcon['bg'] }}/80 text-white flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-[18px] sm:h-[18px] md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $notifIcon['svg'] !!}</svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-600 truncate">{{ $data['message'] ?? 'Notifikasi' }}</h4>
                                <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1 mb-1 sm:mb-2 line-clamp-2">{{ $data['catatan'] ?? 'Status laporan diperbarui.' }}</p>
                                <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs font-medium text-slate-400">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>
                        <button type="button" class="delete-notif text-slate-300 hover:text-slate-500 p-1 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity shrink-0 ml-1.5 sm:ml-2 self-start" data-id="{{ $notification->id }}">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif
</div>

<form id="mark-all-read-form" method="POST" action="{{ route('notifications.read-all') }}" class="hidden">@csrf</form>
<form id="delete-all-form" method="POST" action="{{ route('notifications.delete-all') }}" class="hidden">@csrf</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.getElementById('mark-all-read')?.addEventListener('click', () => {
        fetch('{{ route('notifications.read-all') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        }).then(r => r.json()).then(() => location.reload());
    });

    document.getElementById('delete-all')?.addEventListener('click', () => {
        if (!confirm('Hapus semua notifikasi?')) return;
        fetch('{{ route('notifications.delete-all') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        }).then(r => r.json()).then(() => location.reload());
    });

    document.querySelectorAll('.delete-notif').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const id = btn.dataset.id;
            if (!confirm('Hapus notifikasi ini?')) return;
            fetch(`/notifications/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            }).then(r => r.json()).then(() => {
                const item = btn.closest('[data-id]');
                item.style.transition = 'opacity 0.2s';
                item.style.opacity = '0';
                setTimeout(() => item.remove(), 200);
            });
        });
    });
});
</script>
@endpush
@endsection
