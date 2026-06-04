@extends('layouts.dashboard')

@section('title', 'Dashboard - RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Ahmad Rizki' }}</h1>
        <p class="text-slate-500 text-sm">Anda telah membuat {{ $totalLaporanku ?? 3 }} laporan bulan ini. Terima kasih atas partisipasi aktif Anda dalam menjaga keselamatan masyarakat.</p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column (Spans 2 columns) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="text-xs font-medium text-slate-500 mb-1">Total Laporan Saya</div>
                    <div class="text-2xl font-bold text-slate-900">{{ $totalLaporanku ?? 8 }}</div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-xs font-medium text-slate-500 mb-1">Dalam Proses</div>
                    <div class="text-2xl font-bold text-slate-900">{{ $laporanDiproses ?? 2 }}</div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-xs font-medium text-slate-500 mb-1">Selesai</div>
                    <div class="text-2xl font-bold text-slate-900">{{ $laporanSelesai ?? 6 }}</div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <div class="text-xs font-medium text-slate-500 mb-1">Komentar Diterima</div>
                    <div class="text-2xl font-bold text-slate-900">24</div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <h3 class="font-bold text-slate-800">Filter Peta</h3>
                </div>
                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Cari jenis Keluhan">
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <input type="text" class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" placeholder="Cari lokasi">
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="date" class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-500">
                    </div>
                </div>

                <!-- Map Container -->
                <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50 h-[380px]">
                    <div id="map" class="w-full h-full z-10"></div>
                    
                    <!-- Stats overlay on map -->
                    <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-2 rounded-xl shadow-lg z-[20]">
                        <div class="text-[10px] font-bold tracking-wide uppercase opacity-90 mb-0.5">Aktif Sekarang</div>
                        <div class="text-xl font-extrabold leading-none">{{ $totalAktif }}</div>
                    </div>
                    
                    <!-- Legend overlay -->
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-3 rounded-xl shadow-lg z-[20] border border-slate-100">
                        <div class="text-xs font-bold text-slate-800 mb-0.5">Peta Sebaran Keluhan</div>
                        <div class="text-[10px] text-slate-500">Jawa Barat, Indonesia</div>
                    </div>
                </div>
            </div>

            <!-- Laporan Saya List -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Laporan Saya</h3>
                    <a href="{{ route('laporan.saya') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1 transition-colors">
                        Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($laporanku ?? [] as $lap)
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all group">
                        <div class="w-full sm:w-40 h-28 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 relative">
                            @if($lap->foto)
                                <img src="{{ asset('storage/' . $lap->foto) }}" alt="Foto Laporan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col py-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 uppercase tracking-wide border border-red-100">{{ $lap->kategori->nama ?? 'Bencana Alam' }}</span>
                                @if($lap->status == 'Selesai')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 uppercase tracking-wide border border-green-100">Selesai</span>
                                @elseif(in_array($lap->status, ['Diproses', 'Ditindaklanjuti']))
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase tracking-wide border border-blue-100">Diproses</span>
                                @elseif($lap->status == 'Menunggu')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-600 uppercase tracking-wide border border-yellow-100">Menunggu</span>
                                @elseif($lap->status == 'Darurat')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 uppercase tracking-wide border border-red-100">Darurat</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wide border border-slate-200">{{ $lap->status }}</span>
                                @endif
                            </div>
                            <h4 class="font-bold text-slate-800 text-base truncate mb-1">{{ $lap->judul_laporan }}</h4>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center text-xs text-slate-500 gap-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $lap->kecamatan ?? 'Kecamatan' }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $lap->created_at->format('d M Y') }}
                                    </div>
                                </div>
                                <a href="{{ route('laporan.show', $lap->id) }}" class="text-blue-600 hover:text-blue-700 text-xs font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <!-- Dummy Items if Empty to show design -->
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all group">
                        <div class="w-full sm:w-40 h-28 rounded-xl overflow-hidden flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1542082873-c1d0176861eb?auto=format&fit=crop&w=500&q=80" alt="Banjir" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col py-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 uppercase tracking-wide border border-red-100">Bencana Alam</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 uppercase tracking-wide border border-green-100">Terverifikasi</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-base truncate mb-1">Banjir di Jalan Soekarno-Hatta</h4>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center text-xs text-slate-500 gap-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Kec. Dayeuhkolot, Bandung
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        18 Apr 2026
                                    </div>
                                </div>
                                <a href="#" class="text-blue-600 hover:text-blue-700 text-xs font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-2xl border border-slate-100 hover:border-slate-200 hover:shadow-sm transition-all group">
                        <div class="w-full sm:w-40 h-28 rounded-xl overflow-hidden flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1596701062351-8c2c14d1fdd0?auto=format&fit=crop&w=500&q=80" alt="Pohon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col py-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-600 uppercase tracking-wide border border-red-100">Bencana Alam</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wide border border-slate-200">Selesai</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-base truncate mb-1">Pohon tumbang menghalangi jalan</h4>
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center text-xs text-slate-500 gap-4">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Jl. Cihampelas, Bandung
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        17 Apr 2026
                                    </div>
                                </div>
                                <a href="#" class="text-blue-600 hover:text-blue-700 text-xs font-bold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            
            <!-- Call to Action Banner -->
            <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold mb-2 leading-tight">Ada Keluhan di sekitar Anda?</h3>
                    <p class="text-blue-100 text-xs mb-5 leading-relaxed">Laporkan sekarang untuk membantu masyarakat dan petugas tanggap Keluhan</p>
                    <a href="{{ route('laporan.create') }}" class="w-full inline-flex justify-center items-center gap-2 bg-white text-blue-600 font-bold py-2.5 px-4 rounded-xl hover:bg-slate-50 transition-colors text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Laporan Baru
                    </a>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-blue-500 rounded-full opacity-30 z-0"></div>
                <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-blue-700 rounded-full opacity-40 z-0"></div>
            </div>

            <!-- Skor Partisipasi -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col items-center">
                <div class="w-full flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <h3 class="font-bold text-slate-800">Skor Partisipasi</h3>
                </div>
                
                <div class="text-center mb-5">
                    <div class="text-[3.5rem] font-extrabold text-blue-600 leading-none mb-1">{{ $partisipasiSkor }}</div>
                    <div class="text-xs font-medium text-slate-500">dari 100 poin</div>
                </div>

                <div class="w-full bg-slate-100 rounded-full h-1.5 mb-5 overflow-hidden">
                    <div class="bg-blue-600 h-1.5 rounded-full relative" style="width: {{ $partisipasiSkor }}%">
                        <div class="absolute inset-0 bg-white/20"></div>
                    </div>
                </div>
                
                <p class="text-[11px] text-center text-slate-500 px-2 leading-relaxed">
                    @if($totalLaporanku === 0)
                        Belum ada laporan. Ayo buat laporan pertama Anda!
                    @elseif($totalLaporanku < 5)
                        Anda telah membuat {{ $totalLaporanku }} laporan. Teruslah berkontribusi!
                    @elseif($totalLaporanku < 10)
                        Anda telah membuat {{ $totalLaporanku }} laporan. Kontribusi Anda cukup aktif!
                    @else
                        Anda telah membuat {{ $totalLaporanku }} laporan. Kontributor yang sangat aktif!
                    @endif
                </p>
            </div>

            <!-- Peringatan Darurat -->
            <div class="bg-red-50/50 rounded-2xl border border-red-100 p-5 relative shadow-sm overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>
                <div class="flex items-start gap-3 relative z-10 pl-2">
                    <div class="text-red-500 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-800 text-sm mb-1">Peringatan Darurat</h4>
                        <p class="text-red-600 text-xs mb-3 leading-relaxed">Banjir tinggi di Dayeuhkolot. Warga diminta waspada.</p>
                        <div class="flex items-center gap-1.5 text-red-500 text-[10px] font-bold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Bandung • 30 menit lalu
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan Publik Terbaru -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-5">Laporan Publik Terbaru</h3>
                
                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <h4 class="font-bold text-sm text-slate-800 mb-1 leading-snug">Tanah longsor menutup akses jalan</h4>
                        <div class="text-[11px] text-slate-500 mb-2">Tanah Longsor • Bogor</div>
                        <div class="flex items-center gap-3 text-[11px] font-medium text-slate-400">
                            <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg> 8</div>
                            <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg> 18</div>
                            <div>2 jam lalu</div>
                        </div>
                    </div>
                    
                    <!-- Item 2 -->
                    <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                        <h4 class="font-bold text-sm text-slate-800 mb-1 leading-snug">Kebakaran hutan di Gunung Tangkuban Perahu</h4>
                        <div class="text-[11px] text-slate-500 mb-2">Kebakaran Hutan • Bandung Barat</div>
                        <div class="flex items-center gap-3 text-[11px] font-medium text-slate-400">
                            <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg> 15</div>
                            <div class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg> 32</div>
                            <div>4 jam lalu</div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 text-center">
                    <a href="{{ route('laporan.publik') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center justify-center gap-1 transition-colors">
                        Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

@if(config('app.env') !== 'testing')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('map')) {
            var map = L.map('map', { zoomControl: false }).setView([-6.9175, 107.6191], 11); // Center on Bandung approx
            
            // Add zoom control to top right
            L.control.zoom({
                position: 'topright'
            }).addTo(map);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            // Render actual report markers on the map
            var reports = @json($petaLaporan);

            function getStatusColor(status) {
                switch(status) {
                    case 'Selesai': return '#22c55e';
                    case 'Diproses':
                    case 'Ditindaklanjuti': return '#3b82f6';
                    case 'Menunggu': return '#eab308';
                    case 'Darurat': return '#ef4444';
                    default: return '#94a3b8';
                }
            }

            function createMarker(coord, color, title) {
                L.circleMarker(coord, {
                    radius: 12,
                    fillColor: color,
                    color: "transparent",
                    weight: 0,
                    opacity: 1,
                    fillOpacity: 0.2
                }).addTo(map).bindTooltip(title, { direction: 'top', offset: [0, -10] });
                
                L.circleMarker(coord, {
                    radius: 4,
                    fillColor: color,
                    color: "#ffffff",
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 1
                }).addTo(map);
            }

            reports.forEach(function(r) {
                if (r.latitude && r.longitude) {
                    createMarker([r.latitude, r.longitude], getStatusColor(r.status), r.judul_laporan);
                }
            });

            if (reports.length > 0) {
                var group = L.featureGroup(reports.filter(function(r) {
                    return r.latitude && r.longitude;
                }).map(function(r) {
                    return L.circleMarker([r.latitude, r.longitude]);
                }));
                if (group.getLayers().length > 0) {
                    map.fitBounds(group.getBounds().pad(0.2));
                }
            }
        }
    });
</script>
@endif
@endsection
