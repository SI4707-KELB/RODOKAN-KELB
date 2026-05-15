<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RODOKAN - Dashboard Publik</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-500 selection:text-white">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">RODOKAN</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-blue-600 font-medium">Dashboard</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium transition">Laporan</a>
                    <a href="#" class="text-gray-500 hover:text-gray-900 font-medium transition">Panduan</a>
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Emergency Alert -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-start gap-4 shadow-sm">
            <div class="text-red-500 mt-0.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-red-700 font-bold mb-1">Peringatan Darurat</h3>
                <p class="text-red-600 text-sm mb-2">Banjir hingga ketinggian 2 meter di Kecamatan Gedebage, Kota Bandung. Hujan diproyeksi turunlah dalam beberapa waktu.</p>
                <div class="flex items-center gap-4 text-xs text-red-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Kec. Gedebage, Kota Bandung
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        10 menit lalu
                    </span>
                </div>
            </div>
            <button class="text-red-400 hover:text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Left Column (Span 7) -->
            <div class="lg:col-span-7 space-y-6">

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
                            <span class="text-gray-900 font-bold">{{ $laporan->upvotes_count ?? 0 }}</span>
                        </div>
                        @endforeach
                    </div>

                    <a href="#" class="block text-center mt-4 text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua Trending &gt;</a>
                </div>

            </div>

            <!-- Right Column (Span 5) -->
            <div class="lg:col-span-5 space-y-6">

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

                <!-- Aksi Cepat -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition shadow-sm shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Laporkan keluhan Sekarang
                        </a>
                        <a href="#" class="w-full flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-blue-600 border border-blue-600 py-3 rounded-lg font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            Lihat Panduan
                        </a>
                    </div>
                </div>

                <!-- Laporan Publik Terbaru -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
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
                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.514"></path></svg> {{ $laporan->upvotes_count ?? 0 }}</span>
                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03-8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg> {{ $laporan->komentars_count ?? 0 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <a href="#" class="block text-center mt-4 text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua Laporan &gt;</a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
