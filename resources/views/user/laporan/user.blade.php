@extends('layouts.dashboard')

@section('title', 'Laporan Saya - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto pb-20">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Laporan Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau semua laporan yang pernah Anda kirim beserta status penanganannya</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Laporan
        </a>
    </div>

    <!-- Statistics Grid Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Total Laporan -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm flex flex-col justify-between min-h-[120px]">
            <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shadow-sm shadow-blue-500/20 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Total Laporan</div>
                <div class="text-3xl font-extrabold text-slate-800 mt-1 leading-none">{{ $totalLaporanku ?? 0 }}</div>
            </div>
        </div>

        <!-- Card 2: Diproses -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm flex flex-col justify-between min-h-[120px]">
            <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center shadow-sm shadow-orange-500/20 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Diproses</div>
                <div class="text-3xl font-extrabold text-slate-800 mt-1 leading-none">{{ $laporanDiproses ?? 0 }}</div>
            </div>
        </div>

        <!-- Card 3: Ditindaklanjuti -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm flex flex-col justify-between min-h-[120px]">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-sm shadow-blue-600/20 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Ditindaklanjuti</div>
                <div class="text-3xl font-extrabold text-slate-800 mt-1 leading-none">{{ $laporanDitindaklanjuti ?? 0 }}</div>
            </div>
        </div>

        <!-- Card 4: Selesai -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-5 shadow-sm flex flex-col justify-between min-h-[120px]">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-sm shadow-emerald-500/20 mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <div class="text-xs font-semibold text-slate-400">Selesai</div>
                <div class="text-3xl font-extrabold text-slate-800 mt-1 leading-none">{{ $laporanSelesai ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Filter Component -->
    @include('layouts.filter')

    <!-- Reports List Section -->
    @if($laporans->count() > 0)
        <div class="flex flex-col gap-5">
            @foreach($laporans as $laporan)
                @php
                    $statusBgColor = match($laporan->status) {
                        'Menunggu' => 'bg-slate-100 text-slate-700',
                        'Terverifikasi' => 'bg-green-50 text-green-700',
                        'Ditolak' => 'bg-red-50 text-red-700',
                        'Diproses' => 'bg-blue-50 text-blue-700',
                        'Ditindaklanjuti' => 'bg-purple-50 text-purple-700',
                        'Darurat' => 'bg-orange-50 text-orange-700',
                        'Selesai' => 'bg-emerald-50 text-emerald-700',
                        default => 'bg-slate-50 text-slate-700',
                    };
                @endphp
                <div class="group bg-white border border-slate-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300 flex flex-col md:flex-row items-stretch">
                    
                    <!-- Card Image -->
                    <div class="h-56 md:h-auto md:w-64 bg-gradient-to-br from-slate-100 to-slate-50 relative overflow-hidden shrink-0">
                        @if($laporan->foto)
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kejadian" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center text-slate-300 bg-gradient-to-br from-slate-100 to-slate-50">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="p-6 flex flex-col flex-1 justify-center">
                        <!-- Badges (Kategori & Status) -->
                        <div class="flex items-center gap-2 mb-2.5">
                            <span class="px-2.5 py-0.5 bg-red-50 text-red-600 text-[10px] font-bold rounded-md">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>
                            <span class="px-2.5 py-0.5 {{ $statusBgColor }} text-[10px] font-bold rounded-md">
                                {{ $laporan->status }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-slate-800 mb-1.5 group-hover:text-blue-600 transition-colors leading-snug">
                            <a href="{{ route('laporan.show', $laporan->id) }}">
                                {{ $laporan->judul_laporan }}
                            </a>
                        </h3>

                        <!-- Description -->
                        <p class="text-xs text-slate-500 mb-4 line-clamp-2 leading-relaxed">
                            {{ $laporan->deskripsi }}
                        </p>

                        <!-- Meta Info Row -->
                        <div class="flex flex-wrap gap-x-5 gap-y-2.5 pt-3.5 border-t border-slate-100 text-[11px] text-slate-400 font-medium">
                            <div class="flex items-center gap-1 text-blue-500 font-semibold">
                                <span>#RODOKAN-{{ \Carbon\Carbon::parse($laporan->created_at)->format('Y') }}-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="truncate">{{ $laporan->kecamatan }}, Bandung</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ \Carbon\Carbon::parse($laporan->waktu_kejadian ?? $laporan->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ \Carbon\Carbon::parse($laporan->waktu_kejadian ?? $laporan->created_at)->format('H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>{{ $laporan->komentars_count ?? 0 }} komentar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.789 1.106H9m0 0a2 2 0 100-4m0 4a2 2 0 110-4m0 4V5a2 2 0 114 0"></path></svg>
                                <span>{{ $laporan->upvotes_count ?? 0 }} dukungan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Buttons -->
                    <div class="p-6 border-t md:border-t-0 md:border-l border-slate-100 flex flex-row md:flex-col items-center justify-center gap-3 shrink-0 md:w-48">
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-1.5 shadow-md shadow-blue-600/10">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat Detail
                        </a>
                        <a href="{{ route('laporan.show', $laporan->id) }}" class="w-full px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-bold rounded-lg transition-colors flex items-center justify-center gap-1.5">
                            Lacak Status
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Section -->
        <div class="mt-12">
            {{ $laporans->links('pagination::tailwind') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white border border-slate-200/60 rounded-2xl p-12 flex flex-col items-center justify-center text-center shadow-sm">
            <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Laporan</h3>
            <p class="text-sm text-slate-500 max-w-sm mb-6">
                @if(request()->anyFilled(['search', 'status', 'kategori', 'lokasi']))
                    Tidak ada laporan yang sesuai dengan pencarian atau filter Anda.
                @else
                    Anda belum mengirimkan laporan apapun. Silakan buat laporan pertama Anda jika melihat kejadian di sekitar.
                @endif
            </p>
            @if(!request()->anyFilled(['search', 'status', 'kategori', 'lokasi']))
                <a href="{{ route('laporan.create') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                    Buat Laporan Baru
                </a>
            @else
                <a href="{{ url()->current() }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-colors">
                    Reset Filter
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
