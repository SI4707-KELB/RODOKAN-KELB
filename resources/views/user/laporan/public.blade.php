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

    @if($laporans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laporans as $laporan)
                <a href="{{ route('laporan.show', $laporan->id) }}" class="group bg-white border border-slate-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col h-full">
                    
                    <!-- Card Image -->
                    <div class="h-40 bg-gradient-to-br from-slate-100 to-slate-50 relative overflow-hidden shrink-0">
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kejadian" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300 bg-gradient-to-br from-slate-100 to-slate-50">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3 px-3 py-1 bg-green-500 text-white text-[10px] font-bold rounded-lg shadow-md flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Terverifikasi
                        </div>

                        <!-- Urgency Badge -->
                        @php
                            $urgencyColor = match($laporan->urgensi) {
                                'Rendah' => 'bg-blue-100 text-blue-700',
                                'Sedang' => 'bg-yellow-100 text-yellow-700',
                                'Tinggi' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        @endphp
                        <div class="absolute top-3 left-3 px-2.5 py-1 {{ $urgencyColor }} text-[10px] font-bold rounded-lg">
                            {{ $laporan->urgensi }}
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-5 flex flex-col flex-1">
                        <!-- Category & Time -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded-lg">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">
                                {{ $laporan->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-sm font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                            {{ $laporan->judul_laporan }}
                        </h3>

                        <!-- Description -->
                        <p class="text-xs text-slate-600 mb-4 line-clamp-2 flex-1">
                            {{ $laporan->deskripsi }}
                        </p>
                        
                        <!-- Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-[11px] text-slate-500 font-medium">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="truncate">{{ $laporan->kecamatan }}</span>
                            </div>
                            
                            <!-- Upvotes -->
                            <div class="flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.789 1.106H9m0 0a2 2 0 100-4m0 4a2 2 0 110-4m0 4V5a2 2 0 114 0"></path></svg>
                                <span>{{ $laporan->upvotes->count() }}</span>
                            </div>
                        </div>

                        <!-- Reporter Info (if not anonymous) -->
                        @if(!$laporan->is_anonim && $laporan->user)
                            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center text-[10px] font-bold uppercase">
                                    {{ substr($laporan->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="text-[10px]">
                                    <p class="font-medium text-slate-700">{{ $laporan->user->name ?? 'Pengguna' }}</p>
                                    <p class="text-slate-500">Pelapor</p>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 pt-3 border-t border-slate-100">
                                <p class="text-[10px] text-slate-500 italic">Dilaporkan secara anonim</p>
                            </div>
                        @endif
                    </div>
                </a>
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
