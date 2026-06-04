<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RODOKAN - Dashboard Publik</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo-favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .scrollbar-none::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-none {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-[1000]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center overflow-hidden border border-blue-100">
                        <img src="{{ asset('images/logo-mark.png') }}" alt="Logo RODOKAN" class="w-8 h-8 object-contain">
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">RODOKAN</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#dashboard" data-nav="dashboard" class="text-blue-600 font-medium">Dashboard</a>
                    <a href="#laporan" data-nav="laporan" class="text-gray-500 hover:text-gray-900 font-medium transition">Laporan</a>
                    <a href="#panduan" data-nav="panduan" class="text-gray-500 hover:text-gray-900 font-medium transition">Panduan</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition shadow-sm shadow-blue-500/30">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="dashboard" class="scroll-mt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        @php
            $isGempaSignifikan = $gempa && (float) ($gempa['Magnitude'] ?? 0) >= 4.5;
            $weatherCode = $cuaca['current']['weather_code'] ?? 0;
        @endphp

        @if($isGempaSignifikan)
        <div class="bg-red-100 border-l-4 border-l-red-600 p-4 mb-6 flex items-start gap-3">
            <div class="text-red-600 mt-0.5 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-red-800 mb-0.5">Peringatan Gempa Bumi — BMKG</p>
                <p class="text-sm text-red-700 leading-relaxed">
                    Gempa M {{ number_format((float) $gempa['Magnitude'], 1) }}, {{ $gempa['Wilayah'] ?? '-' }}.
                    Kedalaman {{ $gempa['Kedalaman'] ?? '-' }}.
                    @if(!empty($gempa['Potensi']) && $gempa['Potensi'] !== '-')
                        {{ $gempa['Potensi'] }}.
                    @endif
                </p>
                @if(!empty($gempa['Dirasakan']) && $gempa['Dirasakan'] !== '-')
                    <p class="text-xs text-red-600 mt-1">Dirasakan: {{ $gempa['Dirasakan'] }}</p>
                @endif
                <p class="text-xs text-red-500 mt-1">{{ $gempa['Tanggal'] ?? '-' }}, {{ $gempa['Jam'] ?? '-' }} &middot; Sumber BMKG</p>
            </div>
        </div>
        @endif

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">
            
            <!-- Left Column (Span 7) -->
            <div class="lg:col-span-7 space-y-4">
                
                <!-- Filter & Pencarian -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter & Pencarian
                    </h3>
                    <div class="mb-4 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" class="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Cari lokasi atau jenis laporan...">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Jenis</label>
                            <select class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 text-gray-700 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option>Pilih</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Kecamatan</label>
                            <select class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 text-gray-700 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option>Pilih</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Waktu</label>
                            <select class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 text-gray-700 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option>Pilih</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Filter Cepat</label>
                            <select class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2 text-gray-700 bg-gray-50 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option>⚡ Prese</option>
                            </select>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-3">
                        <span class="text-xs text-gray-400">Belum ada filter</span>
                    </div>
                </div>

                <!-- Peta Sebaran Laporan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    @php
                        $mapReports = $laporanMap->map(fn ($laporan) => [
                            'title' => $laporan->judul_laporan,
                            'category' => $laporan->kategori->nama ?? 'Lainnya',
                            'status' => $laporan->status,
                            'urgency' => $laporan->urgensi,
                            'district' => $laporan->kecamatan,
                            'lat' => (float) $laporan->latitude,
                            'lng' => (float) $laporan->longitude,
                        ])->values();
                    @endphp
                    <div class="flex justify-between items-center mb-4">
                        <div class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-2">
                            LIVE STATUS
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                        </div>
                    </div>
                    
                    <div
                        id="laporan-map"
                        class="rounded-xl h-64 w-full mb-6 border border-blue-100 overflow-hidden"
                        data-reports="{{ $mapReports->toJson(JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT) }}"
                        aria-label="Peta Sebaran Laporan Kota Bandung"
                    ></div>

                    <h4 class="font-semibold text-gray-800 text-sm mb-1">Peta Sebaran Laporan</h4>
                    <p class="text-xs text-gray-400 mb-4">Kota Bandung, Jawa Barat</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-y-3 gap-x-2 text-xs text-gray-600">
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Bencana Alam</div>
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Infrastruktur</div>
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Kebersihan</div>
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Keamanan</div>
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Energi & Air</div>
                        <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-500"></span> Lainnya</div>
                    </div>
                </div>

                <!-- Trending Incidents -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="text-orange-500">🔥</span> Trending Incidents
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach($trendingIncidents as $laporan)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100 bg-gray-50/50 border-l-4 {{ $laporan->kategori->nama == 'Bencana' ? 'border-l-red-500' : ($laporan->kategori->nama == 'Infrastruktur' ? 'border-l-blue-500' : 'border-l-orange-500') }}">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded {{ $laporan->kategori->nama == 'Bencana' ? 'bg-red-100 text-red-600' : ($laporan->kategori->nama == 'Infrastruktur' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600') }} flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $laporan->judul_laporan }}</h4>
                                    <p class="text-xs {{ $laporan->kategori->nama == 'Bencana' ? 'text-red-600' : ($laporan->kategori->nama == 'Infrastruktur' ? 'text-blue-600' : 'text-orange-600') }} font-medium">↑ {{ $laporan->komentars_count ?? 0 }} komentar</p>
                                </div>
                            </div>
                            @php
                                $hasUpvoted = auth()->check() && $laporan->upvotes->contains('user_id', auth()->id());
                            @endphp
                            <form action="{{ route('laporan.upvote', $laporan->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="flex flex-col items-center justify-center p-2 rounded-lg hover:bg-gray-100 transition-colors {{ $hasUpvoted ? 'text-blue-600' : 'text-gray-400' }}">
                                    <svg class="w-5 h-5" fill="{{ $hasUpvoted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <span class="text-gray-900 font-bold text-sm leading-none mt-1">{{ $laporan->upvotes_count ?? 0 }}</span>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="#" class="block text-center mt-4 text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua Trending &gt;</a>
                </div>

                <!-- Distribusi Kategori Laporan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            Distribusi Kategori
                        </h3>
                        <span class="text-[10px] font-bold bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full uppercase tracking-wide">{{ $totalLaporan }} total</span>
                    </div>
                    <div class="space-y-3">
                        @php
                            $katColors = ['bg-blue-500', 'bg-emerald-500', 'bg-amber-500', 'bg-red-500', 'bg-purple-500', 'bg-cyan-500', 'bg-pink-500'];
                            $katBgColors = ['bg-blue-50', 'bg-emerald-50', 'bg-amber-50', 'bg-red-50', 'bg-purple-50', 'bg-cyan-50', 'bg-pink-50'];
                            $katTextColors = ['text-blue-700', 'text-emerald-700', 'text-amber-700', 'text-red-700', 'text-purple-700', 'text-cyan-700', 'text-pink-700'];
                            $maxKat = $kategoriStats->max('total') ?: 1;
                        @endphp
                        @forelse($kategoriStats as $index => $kat)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $katColors[$index % count($katColors)] }} shrink-0"></span>
                                    <span class="text-xs font-semibold text-gray-700">{{ $kat['nama'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold {{ $katTextColors[$index % count($katTextColors)] }} {{ $katBgColors[$index % count($katBgColors)] }} px-1.5 py-0.5 rounded">{{ $kat['total'] }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium w-10 text-right">{{ $totalLaporan > 0 ? round(($kat['total'] / $totalLaporan) * 100, 1) : 0 }}%</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full {{ $katColors[$index % count($katColors)] }} transition-all duration-700" style="width: {{ ($kat['total'] / $maxKat) * 100 }}%"></div>
                            </div>
                        </div>
                        @empty
                        <div class="text-xs text-gray-400 text-center py-4">Belum ada data kategori</div>
                        @endforelse
                    </div>
                </div>

                <!-- Top 5 Kecamatan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Top 5 Kecamatan
                    </h3>
                    <div class="space-y-2.5">
                        @forelse($topKecamatan as $index => $kec)
                        <div class="flex items-center gap-3 p-2.5 rounded-lg {{ $index === 0 ? 'bg-blue-50 border border-blue-100' : 'bg-gray-50/50 border border-gray-100/80' }} transition-all hover:shadow-sm">
                            <div class="w-7 h-7 rounded-lg {{ $index === 0 ? 'bg-blue-600 text-white' : ($index === 1 ? 'bg-gray-700 text-white' : 'bg-gray-200 text-gray-600') }} flex items-center justify-center text-xs font-black shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ $kec->kecamatan }}</h4>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-sm font-extrabold {{ $index === 0 ? 'text-blue-600' : 'text-gray-800' }}">{{ $kec->total }}</span>
                                <span class="text-[10px] text-gray-400 font-medium ml-0.5">laporan</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-xs text-gray-400 text-center py-4">Belum ada data kecamatan</div>
                        @endforelse
                    </div>
                </div>

                <!-- Distribusi Minggu Ini -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Distribusi Minggu Ini
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $mingguIni }} laporan</span>
                            @if($trendMinggu >= 0)
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    +{{ $trendMinggu }}%
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded flex items-center gap-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    {{ $trendMinggu }}%
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-end gap-2 h-32">
                        @foreach($mingguData as $d)
                        <div class="flex-1 flex flex-col items-center gap-1.5 h-full justify-end">
                            <span class="text-[10px] font-bold {{ $d['total'] > 0 ? 'text-blue-600' : 'text-slate-300' }}">{{ $d['total'] }}</span>
                            <div class="w-full rounded-lg transition-all duration-500 hover:opacity-80" 
                                 style="height: {{ max(($d['total'] / $maxMinggu) * 100, 4) }}%; 
                                        background: {{ $d['total'] > 0 ? 'linear-gradient(180deg, #3b82f6, #2563eb)' : '#f1f5f9' }};">
                            </div>
                            <span class="text-[10px] font-semibold text-slate-500">{{ $d['hari'] }}</span>
                            <span class="text-[8px] text-slate-400 -mt-0.5">{{ $d['label'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Column (Span 5) -->
            <div class="lg:col-span-5 flex flex-col gap-4">
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Stat 1 -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 relative overflow-hidden">
                        <div class="flex justify-between items-start mb-2">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-xs font-semibold text-green-500 bg-green-50 px-1.5 py-0.5 rounded">+0%</span>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $totalLaporan }}</h2>
                        <p class="text-xs text-gray-500">Laporan Masuk</p>
                    </div>
                    
                    <!-- Stat 2 -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $responAlert }}</h2>
                        <p class="text-xs text-gray-500">Respon Alert</p>
                    </div>
                    
                    <!-- Stat 3 -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $terverifikasi }}</h2>
                        <p class="text-xs text-gray-500">Terverifikasi</p>
                    </div>
                    
                    <!-- Stat 4 -->
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-2">
                            <div class="w-8 h-8 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $dalamProses }}</h2>
                        <p class="text-xs text-gray-500">Dalam Proses</p>
                    </div>
                </div>

                @if($cuaca)
                @php
                    $wmoMain = [
                        0 => 'Cerah', 1 => 'Cerah Berawan', 2 => 'Berawan', 3 => 'Berawan Tebal',
                        45 => 'Berkabut', 51 => 'Gerimis', 61 => 'Hujan', 80 => 'Hujan Lokal',
                        95 => 'Badai Petir',
                    ];
                    $code = $cuaca['current']['weather_code'] ?? 0;
                    $temp = $cuaca['current']['temperature_2m'] ?? '-';

                    $tz = 'Asia/Jakarta';
                    $now = \Carbon\Carbon::now($tz);
                    $hourly = $cuaca['hourly'] ?? [];
                    $hourlyTimes = $hourly['time'] ?? [];

                    $daysMap = [
                        'Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab',
                        'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'
                    ];
                    $daysMapFull = [
                        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
                    ];
                    $monthsMap = [
                        'Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun',
                        'Jul' => 'Jul', 'Aug' => 'Agt', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'
                    ];

                    $daysData = [];
                    if (count($hourlyTimes) > 0) {
                        foreach ($hourlyTimes as $i => $t) {
                            $hTime = \Carbon\Carbon::parse($t, $tz);
                            $dateKey = $hTime->format('Y-m-d');
                            
                            // For today, start showing from current hour. For other days show full day.
                            if ($hTime->isToday() && $hTime->format('H') < $now->format('H')) {
                                continue;
                            }
                            
                            if (!isset($daysData[$dateKey])) {
                                $engDay = $hTime->format('D');
                                $engMonth = $hTime->format('M');
                                $indDay = $daysMap[$engDay] ?? $engDay;
                                $dayLabel = $indDay . ', ' . $hTime->format('d') . ' ' . ($monthsMap[$engMonth] ?? $engMonth);

                                $daysData[$dateKey] = [
                                    'date' => $hTime,
                                    'label' => $hTime->isToday() ? 'Hari Ini' : ($hTime->isTomorrow() ? 'Besok' : $dayLabel),
                                    'hours' => []
                                ];
                            }
                            
                            $daysData[$dateKey]['hours'][] = [
                                'time' => $hTime,
                                'temp' => $hourly['temperature_2m'][$i] ?? '-',
                                'code' => $hourly['weather_code'][$i] ?? 0,
                                'rain' => $hourly['precipitation_probability'][$i] ?? 0,
                                'wind' => $hourly['wind_speed_10m'][$i] ?? 0,
                            ];
                        }
                    }
                    // Limit to 5 days
                    $daysData = array_slice($daysData, 0, 5, true);
                @endphp
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <!-- Current Weather Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                Cuaca Bandung
                            </h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">Prakiraan 5 Hari Per Jam</p>
                        </div>
                        <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full font-semibold">Real-time</span>
                    </div>

                    <!-- Current Temp Info -->
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $temp }}°C</span>
                            <span class="text-sm font-semibold text-slate-500">{{ $wmoMain[$code] ?? 'Cerah' }}</span>
                        </div>
                        <div class="text-right text-xs text-slate-400 leading-tight">
                            <div>Kelembaban: {{ $cuaca['current']['relative_humidity_2m'] ?? '-' }}%</div>
                            <div class="mt-1">Angin: {{ $cuaca['current']['wind_speed_10m'] ?? '-' }} km/h</div>
                        </div>
                    </div>

                    <!-- Day Tabs -->
                    <div class="border-b border-slate-100 mb-4 pb-2">
                        <div class="flex gap-1.5 overflow-x-auto scrollbar-none" id="weather-tabs">
                            @foreach($daysData as $dateStr => $dayInfo)
                            <button type="button" 
                                    class="weather-tab-btn px-2.5 py-1.5 rounded-lg text-[11px] font-bold whitespace-nowrap transition-all duration-200 {{ $loop->first ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-slate-700' }}" 
                                    data-target="day-panel-{{ $loop->index }}">
                                {{ $dayInfo['label'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hour Panels -->
                    <div id="weather-panels" class="mb-5">
                        @foreach($daysData as $dateStr => $dayInfo)
                        <div id="day-panel-{{ $loop->index }}" 
                             class="weather-panel-content transition-all duration-300 {{ $loop->first ? 'block' : 'hidden' }}">
                            
                            <!-- Horizontal Scroll Hour List -->
                            <div class="flex gap-2.5 overflow-x-auto pb-2 scrollbar-none select-none">
                                @forelse($dayInfo['hours'] as $h)
                                @php
                                    $wmoIcon = match((int) $h['code']) {
                                        0 => '☀️', 1, 2 => '⛅', 3 => '☁️',
                                        45, 48 => '🌫️', 
                                        51, 53, 55 => '🌦️', 
                                        61, 63, 65, 80, 81, 82 => '🌧️',
                                        95, 96, 99 => '⛈️', 
                                        default => '☀️',
                                    };
                                @endphp
                                <div class="flex flex-col items-center justify-between p-2.5 bg-slate-50/70 rounded-xl min-w-[68px] border border-slate-100/80 hover:border-blue-200 hover:bg-blue-50/20 transition-all duration-300">
                                    <span class="text-[9px] font-bold text-slate-400">{{ $h['time']->format('H:i') }}</span>
                                    <span class="text-lg my-2 filter drop-shadow-sm select-none">{{ $wmoIcon }}</span>
                                    <span class="text-xs font-black text-slate-800">{{ $h['temp'] }}°</span>
                                    <span class="text-[9px] font-bold text-blue-500 flex items-center gap-0.5 mt-1.5 leading-none">
                                        💧{{ $h['rain'] }}%
                                    </span>
                                </div>
                                @empty
                                <div class="w-full text-center text-xs text-slate-400 py-4">Data tidak tersedia</div>
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- 5-Day Summary List at bottom -->
                    <div class="border-t border-slate-100 pt-4 space-y-3">
                        <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1.5">Ringkasan Harian</p>
                        @foreach($daysData as $dateStr => $dayInfo)
                        @php
                            $dayIdx = $loop->index;
                            $max = $cuaca['daily']['temperature_2m_max'][$dayIdx] ?? '-';
                            $min = $cuaca['daily']['temperature_2m_min'][$dayIdx] ?? '-';
                            $dayCode = $cuaca['daily']['weather_code'][$dayIdx] ?? 0;
                            $dayIcon = match((int) $dayCode) {
                                0 => '☀️', 1, 2 => '⛅', 3 => '☁️',
                                45, 48 => '🌫️', 
                                51, 53, 55 => '🌦️', 
                                61, 63, 65, 80, 81, 82 => '🌧️',
                                95, 96, 99 => '⛈️', 
                                default => '☀️',
                            };
                            $engDayFull = $dayInfo['date']->format('l');
                            $dayLabelName = $dayInfo['date']->isToday() ? 'Hari Ini' : ($dayInfo['date']->isTomorrow() ? 'Besok' : ($daysMapFull[$engDayFull] ?? $engDayFull));
                        @endphp
                        <div class="flex items-center justify-between text-xs py-0.5">
                            <span class="w-24 font-bold text-slate-600 capitalize">{{ $dayLabelName }}</span>
                            <span class="text-base w-8 text-center">{{ $dayIcon }}</span>
                            <span class="text-slate-400 font-semibold w-14 text-center text-[10px] truncate" title="{{ $wmoMain[$dayCode] ?? 'Cerah' }}">{{ $wmoMain[$dayCode] ?? 'Cerah' }}</span>
                            <span class="text-slate-800 font-black text-right w-16 text-[11px]">{{ $max }}° / <span class="text-slate-400 font-medium">{{ $min }}°</span></span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const tabButtons = document.querySelectorAll('.weather-tab-btn');
                        const panels = document.querySelectorAll('.weather-panel-content');

                        tabButtons.forEach(btn => {
                            btn.addEventListener('click', () => {
                                // Remove active styles from all buttons
                                tabButtons.forEach(b => {
                                    b.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                                    b.classList.add('bg-slate-50', 'text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
                                });

                                // Add active styles to current button
                                btn.classList.remove('bg-slate-50', 'text-slate-500', 'hover:bg-slate-100', 'hover:text-slate-700');
                                btn.classList.add('bg-blue-600', 'text-white', 'shadow-sm');

                                // Hide all panels
                                panels.forEach(p => p.classList.add('hidden'));

                                // Show the active panel
                                const targetId = btn.getAttribute('data-target');
                                const targetPanel = document.getElementById(targetId);
                                if (targetPanel) {
                                    targetPanel.classList.remove('hidden');
                                }
                            });
                        });
                    });
                </script>
                @endif

                <!-- Aksi Cepat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition shadow-sm shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Laporkan keluhan Sekarang
                        </a>
                        <a href="#panduan" class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-blue-600 border border-blue-600 py-3 rounded-lg font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Lihat Panduan
                        </a>
                    </div>
                </div>

                <!-- Laporan Publik Terbaru -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex-1">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-800">Laporan Publik Terbaru</h3>
                        <a href="#" class="text-xs text-blue-600 font-medium flex items-center gap-1 hover:text-blue-800">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($laporanTerbaru as $laporan)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <div class="flex gap-2 mb-2">
                                @if($laporan->urgensi == 'Tinggi')
                                    <span class="bg-red-50 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded">Tinggi</span>
                                @elseif($laporan->urgensi == 'Sedang')
                                    <span class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded">Sedang</span>
                                @else
                                    <span class="bg-green-50 text-green-600 text-[10px] font-bold px-2 py-0.5 rounded">Rendah</span>
                                @endif
                                
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded">{{ $laporan->kategori->nama }}</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $laporan->judul_laporan }}</h4>
                            <div class="flex flex-col gap-1 text-xs text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path></svg> {{ $laporan->kecamatan }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs text-gray-400 font-medium">
                                @php
                                    $hasUpvoted = auth()->check() && $laporan->upvotes->contains('user_id', auth()->id());
                                @endphp
                                <form action="{{ route('laporan.upvote', $laporan->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-1 hover:text-blue-600 {{ $hasUpvoted ? 'text-blue-600 font-bold' : '' }}">
                                        <svg class="w-3.5 h-3.5" fill="{{ $hasUpvoted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.514"></path></svg>
                                        {{ $laporan->upvotes_count ?? 0 }}
                                    </button>
                                </form>
                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03-8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $laporan->komentars_count ?? 0 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <a href="#laporan" class="block text-center mt-4 text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua Laporan &gt;</a>
                </div>

            </div>
        </div>

        <!-- Laporan -->
        <section id="laporan" class="scroll-mt-24 mt-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between mb-6">
                <div>
                    <p class="text-sm font-semibold text-blue-600 mb-2">Laporan Publik</p>
                    <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Pantau laporan masyarakat terbaru</h2>
                    <p class="text-gray-500 mt-2 max-w-2xl">Lihat keluhan yang masuk, status penanganan, kategori masalah, dan lokasi kejadian di wilayah Jawa Barat.</p>
                </div>
                <a href="{{ auth()->check() ? route('laporan.publik') : route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-500/20 hover:bg-blue-700 transition">
                    Buka Laporan Publik
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Daftar Laporan Terkini</h3>
                        <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ $totalLaporan }} laporan</span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($laporanTerbaru->take(4) as $laporan)
                            <article class="p-5 hover:bg-gray-50 transition">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2 mb-2">
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">{{ $laporan->kategori->nama ?? 'Umum' }}</span>
                                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $laporan->urgensi == 'Tinggi' ? 'bg-red-50 text-red-700' : ($laporan->urgensi == 'Sedang' ? 'bg-orange-50 text-orange-700' : 'bg-green-50 text-green-700') }}">{{ $laporan->urgensi }}</span>
                                        </div>
                                        <h4 class="font-bold text-gray-900">{{ $laporan->judul_laporan }}</h4>
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $laporan->deskripsi }}</p>
                                    </div>
                                    <span class="shrink-0 text-xs font-semibold rounded-full px-3 py-1 {{ in_array($laporan->status, ['Selesai', 'Terverifikasi']) ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $laporan->status }}</span>
                                </div>
                                <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $laporan->kecamatan }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.9 9.9 0 01-4.255-.949L3 20l1.395-3.72A7.6 7.6 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        {{ $laporan->komentars_count ?? 0 }} komentar
                                    </span>
                                </div>
                            </article>
                        @empty
                            <div class="p-8 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="font-semibold text-gray-900">Belum ada laporan publik</p>
                                <p class="text-sm text-gray-500 mt-1">Laporan terbaru akan muncul di sini setelah masyarakat mengirimkan keluhan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-blue-600 rounded-xl p-6 text-white shadow-sm shadow-blue-500/20">
                    <h3 class="text-lg font-bold">Ringkasan Penanganan</h3>
                    <p class="text-sm text-blue-100 mt-2">Data ringkas untuk membantu masyarakat melihat perkembangan laporan secara cepat.</p>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-white/15 pb-3">
                            <span class="text-sm text-blue-100">Total laporan</span>
                            <strong class="text-2xl">{{ $totalLaporan }}</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-white/15 pb-3">
                            <span class="text-sm text-blue-100">Terverifikasi</span>
                            <strong class="text-2xl">{{ $terverifikasi }}</strong>
                        </div>
                        <div class="flex items-center justify-between border-b border-white/15 pb-3">
                            <span class="text-sm text-blue-100">Dalam proses</span>
                            <strong class="text-2xl">{{ $dalamProses }}</strong>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-blue-100">Respon alert</span>
                            <strong class="text-2xl">{{ $responAlert }}</strong>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-white px-4 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition">Buat Laporan Baru</a>
                </div>
            </div>
        </section>

        <!-- Panduan -->
        <section id="panduan" class="scroll-mt-24 mt-8 mb-8">
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 md:p-8">
                <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between mb-8">
                    <div>
                        <p class="text-sm font-semibold text-blue-600 mb-2">Panduan Pelaporan</p>
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Cara membuat laporan yang cepat diproses</h2>
                        <p class="text-gray-500 mt-2 max-w-2xl">Lengkapi laporan dengan informasi yang jelas agar petugas mudah melakukan verifikasi dan tindak lanjut.</p>
                    </div>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-blue-600 px-5 py-3 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition">
                        Mulai Melapor
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-5">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Tulis kronologi</h3>
                        <p class="text-sm text-gray-500 mt-2">Jelaskan masalah, dampak, dan kapan kejadian berlangsung secara singkat.</p>
                    </div>

                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-5">
                        <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l6-4 6 4 6-4v14l-6 4-6-4-6 4V7z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Tentukan lokasi</h3>
                        <p class="text-sm text-gray-500 mt-2">Pilih kecamatan dan alamat sedetail mungkin agar titik laporan akurat.</p>
                    </div>

                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-5">
                        <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Unggah bukti</h3>
                        <p class="text-sm text-gray-500 mt-2">Tambahkan foto kejadian yang relevan untuk mempercepat verifikasi.</p>
                    </div>

                    <div class="rounded-lg border border-gray-100 bg-gray-50 p-5">
                        <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">Pilih urgensi</h3>
                        <p class="text-sm text-gray-500 mt-2">Gunakan urgensi tinggi hanya untuk kondisi yang butuh respon cepat.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center overflow-hidden border border-blue-100">
                            <img src="{{ asset('images/logo-mark.png') }}" alt="Logo RODOKAN" class="w-8 h-8 object-contain">
                        </div>
                        <span class="font-bold text-xl tracking-tight text-gray-900">RODOKAN</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-md">
                        RODOKAN (Report & Observasi Darurat Kota) adalah platform pelaporan keluhan dan kejadian publik yang membantu masyarakat menyampaikan laporan secara cepat, transparan, dan terkoordinasi.
                    </p>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#dashboard" class="hover:text-blue-600 transition">Dashboard</a></li>
                        <li><a href="#laporan" class="hover:text-blue-600 transition">Laporan</a></li>
                        <li><a href="#panduan" class="hover:text-blue-600 transition">Panduan</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-600 transition">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-blue-600 transition">Register</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>cs@rodokan.id</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.49 4.49a1 1 0 01-.5 1.21l-2.26 1.13a11 11 0 005.52 5.52l1.13-2.26a1 1 0 011.21-.5l4.49 1.49a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"></path></svg>
                            <span>(022) 1234-5678</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Kota Bandung, Jawa Barat</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} RODOKAN. Seluruh hak cipta dilindungi.</p>
                <p>Dibuat untuk pelayanan publik yang lebih baik.</p>
            </div>
        </div>
    </footer>

</body>
</html>
