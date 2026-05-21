@extends('layouts.dashboard')

@section('title', 'Notifikasi - RODOKAN')

@section('content')
<div class="p-8 max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Notifikasi</h1>
            <p class="text-sm text-slate-500">Update status laporan Anda</p>
        </div>
        @if($notifications->whereNull('read_at')->count() > 0)
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Tandai semua dibaca</button>
        </form>
        @endif
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm divide-y divide-slate-100">
        @forelse($notifications as $notification)
            @php $data = $notification->data; @endphp
            <a href="{{ $data['url'] ?? '#' }}" class="block p-4 hover:bg-slate-50 transition-colors {{ $notification->read_at ? 'opacity-70' : 'bg-blue-50/30' }}">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">{{ $data['message'] ?? 'Status laporan diperbarui' }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    @unless($notification->read_at)
                        <span class="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-2"></span>
                    @endunless
                </div>
            </a>
        @empty
            <div class="p-10 text-center text-slate-400 text-sm">Belum ada notifikasi</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $notifications->links() }}</div>
</div>
@endsection
