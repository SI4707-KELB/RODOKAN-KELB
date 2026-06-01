@extends('layouts.dashboard')

@section('title', 'Laporan Publik - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto pb-20">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Laporan Publik</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar laporan yang telah diverifikasi dan disahkan oleh admin.</p>
        </div>
    </div>

    <!-- Filter Component -->
    @include('layouts.filter')

    @if($laporans->count() > 0)
        <div class="flex flex-col gap-5">
            @foreach($laporans as $laporan)
                <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row items-stretch">
                    
                    <!-- Card Image -->
                    <div class="h-56 md:h-auto md:w-80 bg-gradient-to-br from-slate-100 to-slate-50 relative overflow-hidden shrink-0">
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kejadian" class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center text-slate-300 bg-gradient-to-br from-slate-100 to-slate-50">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 flex flex-col flex-1">
                        <!-- Tags -->
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-bold rounded-full">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>
                            @php
                                $statusColor = match($laporan->status) {
                                    'Menunggu' => 'bg-slate-100 text-slate-700',
                                    'Terverifikasi' => 'bg-green-100 text-green-700',
                                    'Ditolak' => 'bg-red-100 text-red-700',
                                    'Diproses' => 'bg-blue-100 text-blue-700',
                                    'Dalam Penanganan' => 'bg-blue-100 text-blue-700',
                                    'Selesai' => 'bg-slate-100 text-slate-700 border border-slate-200',
                                    default => 'bg-blue-100 text-blue-700',
                                };
                                $statusText = $laporan->status;
                                if ($statusText == 'Diproses') $statusText = 'Dalam Penanganan';
                            @endphp
                            <span class="px-3 py-1 {{ $statusColor }} text-[10px] font-bold rounded-full">
                                {{ $statusText }}
                            </span>
                            @if($laporan->urgensi == 'Tinggi')
                            <span class="px-3 py-1 bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                                Mendesak
                            </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-1 leading-snug">
                            {{ $laporan->judul_laporan }}
                        </h3>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-[11px] text-slate-500 font-medium mb-4">
                            <span class="text-blue-600 font-bold">#RODOKAN-{{ \Carbon\Carbon::parse($laporan->created_at)->format('Y') }}-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span>{{ $laporan->kecamatan }}, Bandung</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $laporan->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-sm text-slate-600 mb-6 line-clamp-2">
                            {{ $laporan->deskripsi }}
                        </p>
                        
                        <!-- Footer -->
                        <div class="mt-auto flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                            <!-- Stats & Reporter -->
                            <div class="flex items-center gap-3 text-[11px] text-slate-500 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    {{ number_format(($laporan->id * 17) % 3000 + 100) }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.789 1.106H9m0 0a2 2 0 100-4m0 4a2 2 0 110-4m0 4V5a2 2 0 114 0"></path></svg>
                                    {{ $laporan->upvotes->count() }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    {{ $laporan->komentars->count() }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-slate-300 mx-1">•</span>
                                    <span>oleh <span class="font-bold text-slate-700">{{ $laporan->is_anonim ? 'Anonim' : ($laporan->user->name ?? 'Pengguna') }}</span></span>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-3">
                                <a href="{{ route('laporan.show', $laporan->id) }}#komentar" class="px-4 py-2 border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Tanggapi
                                </a>
                                <a href="{{ route('laporan.show', $laporan->id) }}" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-500/30">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $laporans->links('pagination::tailwind') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-12 flex flex-col items-center justify-center text-center shadow-sm">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Laporan Publik</h3>
            <p class="text-sm text-slate-500 max-w-sm">Saat ini belum ada laporan yang terverifikasi. Laporan akan ditampilkan di sini setelah diverifikasi oleh admin.</p>
        </div>
    @endif
</div>
@endsection
