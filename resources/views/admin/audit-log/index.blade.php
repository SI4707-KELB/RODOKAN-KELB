@extends('layouts.dashboard')

@section('title', 'Audit Log Aktivitas - Admin Dashboard')

@section('content')
<div class="p-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Audit Log Aktivitas</h1>
            <p class="text-sm text-slate-500 mt-1">Mencatat aktivitas penting di dalam sistem</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Aksi</th>
                        <th class="px-6 py-4">ID Terkait</th>
                        <th class="px-6 py-4">Detail</th>
                        <th class="px-6 py-4">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs">
                                <div class="font-medium text-slate-800">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-slate-500">{{ $log->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($log->user->name ?? 'S', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $log->user->name ?? 'Sistem' }}</div>
                                        <div class="text-[10px] text-slate-500">{{ $log->user->role ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->aksi == 'Verifikasi Laporan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        {{ $log->aksi }}
                                    </span>
                                @elseif($log->aksi == 'Tolak Laporan')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        {{ $log->aksi }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $log->aksi }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($log->model_type)
                                    <div>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
                                    @if(class_basename($log->model_type) == 'Laporan')
                                        <a href="{{ route('admin.laporan.show', $log->model_id) }}" class="text-blue-600 hover:underline">Lihat Laporan</a>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $details = json_decode($log->new_values, true);
                                @endphp
                                @if($details)
                                    <div class="text-xs space-y-0.5">
                                        @foreach($details as $key => $value)
                                            <div class="flex max-w-[200px] truncate" title="{{ $value }}">
                                                <span class="font-medium text-slate-500 w-16">{{ ucfirst($key) }}:</span>
                                                <span class="text-slate-800 truncate">{{ $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Aktivitas</h3>
                                    <p class="text-slate-500 text-sm">Tidak ada log aktivitas yang tercatat saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($logs->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
