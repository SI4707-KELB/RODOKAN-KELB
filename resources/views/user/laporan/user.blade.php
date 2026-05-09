@extends('layouts.dashboard')

@section('title', 'Laporan Saya - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto pb-20">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Laporan Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar semua laporan yang telah Anda kirimkan.</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Laporan
        </a>
    </div>

    @if($laporans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laporans as $laporan)
                <a href="{{ route('laporan.show', $laporan->id) }}" class="group bg-white border border-slate-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col h-full">
                    
                    <!-- Card Image -->
                    <div class="h-40 bg-slate-100 relative overflow-hidden shrink-0">
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kejadian" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-50">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <!-- Status Badge Overlay -->
                        @php
                            $statusColor = match($laporan->status) {
                                'Menunggu' => 'bg-slate-800 text-white',
                                'Terverifikasi' => 'bg-green-500 text-white',
                                'Ditolak' => 'bg-red-500 text-white',
                                'Diproses' => 'bg-blue-500 text-white',
                                'Ditindaklanjuti' => 'bg-purple-500 text-white',
                                'Darurat' => 'bg-orange-500 text-white',
                                'Selesai' => 'bg-emerald-500 text-white',
                                default => 'bg-slate-800 text-white',
                            };
                        @endphp
                        <div class="absolute top-3 right-3 px-2.5 py-1 {{ $statusColor }} text-[10px] font-bold rounded-md shadow-sm">
                            {{ $laporan->status }}
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">
                                {{ $laporan->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <h3 class="text-sm font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                            {{ $laporan->judul_laporan }}
                        </h3>
                        
                        <div class="mt-auto pt-4 flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="truncate">{{ $laporan->kecamatan }}, Bandung</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-12 flex flex-col items-center justify-center text-center shadow-sm">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Laporan</h3>
            <p class="text-sm text-slate-500 max-w-sm mb-6">Anda belum mengirimkan laporan apapun. Silakan buat laporan pertama Anda jika melihat kejadian di sekitar.</p>
            <a href="{{ route('laporan.create') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                Buat Laporan Baru
            </a>
        </div>
    @endif
</div>
@endsection
