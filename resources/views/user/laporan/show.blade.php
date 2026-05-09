@extends('layouts.dashboard')

@section('title', 'Detail Laporan - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto pb-20">

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Left Column -->
        <div class="flex-1 w-full space-y-6">
            
            <!-- Card Utama -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 md:p-8 shadow-sm">
                <!-- Tags -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                        {{ $laporan->kategori->nama ?? 'Lainnya' }}
                    </span>
                    
                    @php
                        $statusColor = match($laporan->status) {
                            'Menunggu' => 'bg-slate-100 text-slate-700',
                            'Terverifikasi' => 'bg-green-100 text-green-700',
                            'Ditolak' => 'bg-red-100 text-red-700',
                            'Diproses' => 'bg-blue-100 text-blue-700',
                            'Ditindaklanjuti' => 'bg-purple-100 text-purple-700',
                            'Darurat' => 'bg-orange-100 text-orange-700',
                            'Selesai' => 'bg-emerald-100 text-emerald-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <span class="px-3 py-1 {{ $statusColor }} text-xs font-bold rounded-full">
                        {{ $laporan->status }}
                    </span>
                </div>

                <!-- Judul & Info Singkat -->
                <h1 class="text-2xl font-bold text-slate-800 mb-2 leading-tight">
                    {{ $laporan->judul_laporan }}
                </h1>
                
                <div class="space-y-1 mb-6">
                    <div class="text-xs font-semibold text-blue-600">ID Laporan: #RODOKAN-{{ \Carbon\Carbon::parse($laporan->created_at)->format('Y') }}-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</div>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-[11px] text-slate-500 font-medium pt-1">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="truncate">{{ $laporan->alamat ?? ($laporan->kecamatan . ', Bandung, Jawa Barat') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $laporan->waktu_kejadian ? $laporan->waktu_kejadian->format('d F Y') : $laporan->created_at->format('d F Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $laporan->waktu_kejadian ? $laporan->waktu_kejadian->format('H:i') : $laporan->created_at->format('H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="border-t border-slate-100 pt-6 mb-8">
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Deskripsi Kejadian</h2>
                    <div class="text-sm text-slate-600 leading-relaxed space-y-4">
                        {!! nl2br(e($laporan->deskripsi)) !!}
                    </div>
                </div>

                <!-- Bukti Foto -->
                <div>
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Bukti Foto</h2>
                    @if($laporan->foto)
                        <div class="w-full h-80 sm:h-[400px] rounded-xl overflow-hidden bg-slate-100 relative group border border-slate-200">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Bukti Kejadian" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-40 rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-medium">Tidak ada foto bukti</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lokasi Kejadian (Map) -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 md:p-8 shadow-sm">
                <h2 class="text-sm font-bold text-slate-800 mb-4">Lokasi Kejadian</h2>
                
                <div class="w-full h-64 bg-slate-900 rounded-xl relative overflow-hidden mb-4 shadow-inner border border-slate-200">
                    <!-- Map Graphic Placeholder -->
                    <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                    <svg class="absolute inset-0 w-full h-full text-yellow-600/20" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="street-grid" width="30" height="30" patternUnits="userSpaceOnUse">
                                <path d="M 30 0 L 0 0 0 30" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#street-grid)" />
                        <!-- Diagonal lines mimicking roads -->
                        <path d="M0,50 Q100,100 200,50 T400,100 T600,0" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M0,150 Q150,50 300,150 T600,100" fill="none" stroke="currentColor" stroke-width="1"/>
                        <circle cx="200" cy="100" r="150" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="100" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="50" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                    </svg>

                    <!-- Ping Point -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 flex flex-col items-center">
                        <div class="w-6 h-6 bg-blue-600 border-4 border-white rounded-full shadow-lg"></div>
                        <div class="w-16 h-16 bg-blue-500/30 rounded-full absolute -top-5 -left-5 animate-ping"></div>
                    </div>
                </div>

                <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-4">
                    <p class="text-xs leading-relaxed text-blue-900">
                        <span class="font-bold">Alamat Lengkap:</span> {{ $laporan->alamat ?? ($laporan->kecamatan . ', Kota Bandung, Jawa Barat 40239') }}
                    </p>
                </div>
            </div>


        </div>

        <!-- Right Column (Sidebar) -->
        <div class="w-full lg:w-80 shrink-0 space-y-6">
            
            <!-- Status Penanganan Timeline -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-6">Status Penanganan</h3>
                
                <div class="relative space-y-6 before:absolute before:inset-0 before:ml-4 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    
                    <!-- Laporan Diterima -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-green-500/30 z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold text-slate-800 mb-0.5">Laporan Diterima</h4>
                            <p class="text-[10px] text-slate-500 leading-snug mb-1">Laporan telah masuk ke sistem RODOKAN</p>
                            <span class="text-[9px] font-medium text-slate-400">{{ $laporan->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Terverifikasi -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Terverifikasi</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Laporan diverifikasi oleh BPBD Kota Bandung</p>
                            @if($laporan->waktu_verifikasi)
                                <span class="text-[9px] font-medium text-slate-400">{{ $laporan->waktu_verifikasi->format('d M Y, H:i') }} WIB</span>
                            @endif
                        </div>
                    </div>

                    <!-- Diteruskan -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Diteruskan ke Instansi</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Laporan diteruskan ke instansi terkait</p>
                        </div>
                    </div>

                    <!-- Dalam Penanganan -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti']) ? 'bg-blue-500 shadow-blue-500/30 text-white' : (in_array($laporan->status, ['Selesai']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400') }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti', 'Selesai']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Dalam Penanganan</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti', 'Selesai']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Tim lapangan sedang menangani lokasi kejadian</p>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ $laporan->status === 'Selesai' ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-50 text-slate-300' }} flex items-center justify-center shrink-0 shadow-sm z-10 border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ $laporan->status === 'Selesai' ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Selesai</h4>
                            <p class="text-[10px] text-slate-400 leading-snug mb-1">Penanganan selesai dan lokasi aman</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Informasi Laporan -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-5">Informasi Laporan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Pelapor</span>
                        <span class="text-xs font-bold text-slate-800">{{ $laporan->is_anonim ? 'Anonim' : ($laporan->user->name ?? 'Anonim') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Instansi</span>
                        <span class="text-xs font-bold text-slate-800">BPBD Bandung</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Tingkat Urgensi</span>
                        <span class="px-2 py-0.5 {{ $laporan->urgensi == 'Tinggi' ? 'bg-red-100 text-red-700' : ($laporan->urgensi == 'Sedang' ? 'bg-orange-100 text-orange-700' : 'bg-slate-100 text-slate-700') }} text-[10px] font-bold rounded">
                            {{ $laporan->urgensi }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Dukungan</span>
                        <span class="text-xs font-bold text-slate-800">{{ $upvotesCount }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Dilihat</span>
                        <span class="text-xs font-bold text-slate-800">142 kali</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 mt-6 pt-5 space-y-3">
                    <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        Dukung Laporan
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        Bagikan
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        Simpan
                    </button>
                </div>
            </div>

            <!-- Laporan Terkait -->
            @if($relatedLaporans->count() > 0)
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <h3 class="text-sm font-bold text-slate-800">Laporan Terkait</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($relatedLaporans as $related)
                        <a href="{{ route('laporan.show', $related->id) }}" class="block p-4 bg-white border border-slate-100 rounded-xl hover:border-blue-200 hover:shadow-md transition-all group">
                            <span class="inline-block px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-bold rounded mb-2">
                                {{ $related->kategori->nama ?? 'Bencana Alam' }}
                            </span>
                            <h4 class="text-xs font-bold text-slate-800 mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $related->judul_laporan }}</h4>
                            <div class="flex items-center gap-3 text-[10px] text-slate-400 font-medium">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> Bandung</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $related->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <a href="#" class="block text-center mt-4 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
