@php
    $data = $notification->data ?? [];
    $category = $data['category'] ?? 'biasa';
    $isUnread = $notification->read_at === null;

    $styles = [
        'darurat' => ['panel' => 'bg-red-50/50 border-red-100', 'bar' => 'bg-red-500', 'icon' => 'bg-red-500'],
        'verifikasi' => ['panel' => 'bg-amber-50/50 border-amber-100', 'bar' => 'bg-amber-500', 'icon' => 'bg-amber-500'],
        'biasa' => ['panel' => 'bg-blue-50/50 border-blue-100', 'bar' => 'bg-blue-500', 'icon' => 'bg-blue-500'],
        'komentar' => ['panel' => 'bg-purple-50/50 border-purple-100', 'bar' => 'bg-purple-500', 'icon' => 'bg-purple-500'],
        'instansi' => ['panel' => 'bg-orange-50/50 border-orange-100', 'bar' => 'bg-orange-500', 'icon' => 'bg-orange-500'],
        'status_update' => ['panel' => 'bg-green-50/50 border-green-100', 'bar' => 'bg-green-500', 'icon' => 'bg-green-500'],
    ];
    $readStyles = ['panel' => 'bg-white border-slate-200', 'bar' => '', 'icon' => 'bg-slate-500'];
    $style = $isUnread ? ($styles[$category] ?? $styles['biasa']) : $readStyles;

    $icons = [
        'darurat' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        'verifikasi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'biasa' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
        'komentar' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>',
        'instansi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        'status_update' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
    ];
    $iconPath = $icons[$category] ?? $icons['biasa'];
@endphp

<div class="notif-item relative {{ $style['panel'] }} rounded-xl border p-4 {{ $isUnread ? 'pl-5' : '' }} overflow-hidden group" data-type="{{ $category }}" data-read="{{ $isUnread ? 'unread' : 'read' }}">
    @if($isUnread && $style['bar'])
        <div class="absolute left-0 top-0 bottom-0 w-1 {{ $style['bar'] }} rounded-l-xl"></div>
    @endif
    <div class="flex justify-between items-start">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full {{ $style['icon'] }} text-white flex items-center justify-center shrink-0 {{ $isUnread ? 'shadow-sm' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconPath !!}</svg>
            </div>
            <div>
                <h3 class="text-sm font-bold {{ $isUnread ? 'text-slate-800' : 'text-slate-800' }}">{{ $data['title'] ?? 'Notifikasi' }}</h3>
                <p class="text-xs {{ $isUnread ? 'text-slate-600' : 'text-slate-500' }} mt-1 mb-2">{{ $data['message'] ?? '' }}</p>
                <div class="flex items-center gap-2 text-[11px] font-medium {{ $isUnread ? 'text-slate-500' : 'text-slate-400' }}">
                    @if(!empty($data['kode_laporan']))
                        <span class="text-blue-600 font-bold">{{ $data['kode_laporan'] }}</span> &bull;
                    @endif
                    @if(!empty($data['kecamatan']))
                        <span>{{ $data['kecamatan'] }}</span> &bull;
                    @endif
                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                    @if($isUnread)
                        &bull;
                        <a href="{{ route('notifications.show', $notification->id) }}" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">
                            Lihat
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <button type="button" class="delete-notif text-slate-400 hover:text-slate-600 p-1 {{ $isUnread ? 'bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100' : 'opacity-0 group-hover:opacity-100 transition-opacity' }}" data-id="{{ $notification->id }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</div>
