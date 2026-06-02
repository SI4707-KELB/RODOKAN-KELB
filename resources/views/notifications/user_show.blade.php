@extends('layouts.dashboard')

@section('title', 'Detail Notifikasi - RODOKAN')

@php
$data = $notification->data ?? [];
$statusBaru = $data['status_baru'] ?? '';
$iconByStatus = [
    'Selesai' => ['bg' => 'bg-green-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'],
    'Terverifikasi' => ['bg' => 'bg-green-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>'],
    'Diproses' => ['bg' => 'bg-blue-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
    'Ditindaklanjuti' => ['bg' => 'bg-orange-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
    'Darurat' => ['bg' => 'bg-red-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'],
];
$icon = $iconByStatus[$statusBaru] ?? ['bg' => 'bg-blue-500', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'];
$badgeLabel = $statusBaru ? "Status: {$statusBaru}" : 'Status Update';
@endphp

@section('content')
<div class="p-3 sm:p-4 md:p-8 max-w-4xl mx-auto w-full space-y-4 sm:space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 sm:p-6">
        <div class="flex gap-3 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $icon['bg'] }} text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon['svg'] !!}</svg>
            </div>
            <div class="min-w-0">
                <h1 class="text-base sm:text-lg md:text-xl font-extrabold text-slate-900">{{ $data['message'] ?? 'Notifikasi' }}</h1>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-1.5 text-xs sm:text-sm text-slate-500 font-medium">
                    <div class="flex items-center gap-1 sm:gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="px-1.5 sm:px-2 py-0.5 rounded text-[10px] sm:text-[11px] font-bold {{ $statusBaru === 'Selesai' || $statusBaru === 'Terverifikasi' ? 'bg-green-50 text-green-600 border-green-100' : ($statusBaru === 'Darurat' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-blue-50 text-blue-600 border-blue-100') }} border whitespace-nowrap">{{ $badgeLabel }}</span>
                </div>
            </div>
        </div>
        <div class="mt-4 sm:mt-6 text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3 sm:space-y-4">
            <p>{{ $data['message'] ?? 'Tidak ada detail pesan.' }}</p>
            @if($data['catatan'] ?? null)
                <p class="text-slate-500 italic">Catatan: {{ $data['catatan'] }}</p>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-sm sm:text-base font-bold text-slate-800">Laporan Terkait</h2>
        </div>
        <div class="p-4 sm:p-6">
            <div class="flex items-center gap-2 mb-2 sm:mb-3">
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md text-[10px] sm:text-xs font-bold {{ $statusBaru === 'Selesai' || $statusBaru === 'Terverifikasi' ? 'bg-green-50 text-green-600' : ($statusBaru === 'Darurat' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600') }}">{{ $statusBaru ?: 'Update' }}</span>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-2 sm:mb-3">{{ $data['judul_laporan'] ?? 'Laporan Terkait' }}</h3>
            <p class="text-xs sm:text-sm text-slate-600 mb-4 sm:mb-6 leading-relaxed">Status laporan <strong>diperbarui</strong> dari <strong>{{ $data['status_sebelumnya'] ?? '-' }}</strong> menjadi <strong>{{ $data['status_baru'] ?? '-' }}</strong>.</p>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 pt-4 sm:pt-5 border-t border-slate-100">
                <a href="{{ $data['url'] ?? '#' }}" class="px-4 sm:px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition-colors w-full sm:w-auto text-center inline-block">Lihat Detail Laporan</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-sm sm:text-base font-bold text-slate-800">Riwayat Status</h2>
        </div>
        <div class="p-4 sm:p-6">
            <div class="relative pl-6 sm:pl-8 space-y-6 sm:space-y-8">
                <div class="absolute left-[23px] sm:left-[31px] top-2 bottom-6 w-0.5 bg-slate-200"></div>

                @if($statusBaru)
                <div class="relative flex items-start gap-3 sm:gap-4">
                    <div class="absolute -left-[18px] sm:-left-6 w-[36px] h-[36px] sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-[18px] h-[18px] sm:w-7 sm:h-7 rounded-full {{ $icon['bg'] }} text-white flex items-center justify-center shadow-sm">
                            <svg class="w-2.5 h-2.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon['svg'] !!}</svg>
                        </div>
                    </div>
                    <div class="ml-5 sm:ml-6 min-w-0">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $statusBaru }}</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1">Status laporan diperbarui menjadi {{ $statusBaru }}</p>
                        <span class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-0.5 sm:mt-1 block">{{ $notification->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
                @endif

                @if($data['status_sebelumnya'] ?? null)
                <div class="relative flex items-start gap-3 sm:gap-4">
                    <div class="absolute -left-[18px] sm:-left-6 w-[36px] h-[36px] sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-[18px] h-[18px] sm:w-7 sm:h-7 rounded-full bg-slate-400 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-2.5 h-2.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="ml-5 sm:ml-6 min-w-0">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-600">{{ $data['status_sebelumnya'] }}</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1">Status sebelumnya</p>
                        <span class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-0.5 sm:mt-1 block">Waktu sebelumnya</span>
                    </div>
                </div>
                @endif

                <div class="relative flex items-start gap-3 sm:gap-4">
                    <div class="absolute -left-[18px] sm:-left-6 w-[36px] h-[36px] sm:w-12 sm:h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-[18px] h-[18px] sm:w-7 sm:h-7 rounded-full bg-slate-300 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-2.5 h-2.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                    </div>
                    <div class="ml-5 sm:ml-6 min-w-0">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-600">Laporan Dibuat</h4>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5 sm:mt-1">{{ $data['judul_laporan'] ?? 'Laporan dibuat' }}</p>
                        <span class="text-[10px] sm:text-[11px] font-medium text-slate-400 mt-0.5 sm:mt-1 block">{{ $notification->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-sm sm:text-base font-bold text-slate-800">Tindakan</h2>
        </div>
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ $data['url'] ?? route('notifications.index') }}" class="px-4 sm:px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl transition-colors flex items-center justify-center sm:justify-start gap-2 text-center">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Lihat Detail Laporan
            </a>
            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" onsubmit="return confirm('Hapus notifikasi ini?')" class="w-full sm:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 sm:px-5 py-2.5 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 text-red-600 text-xs sm:text-sm font-semibold rounded-xl transition-colors flex items-center justify-center sm:justify-start gap-2 w-full sm:w-auto">
                    Hapus Notifikasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
