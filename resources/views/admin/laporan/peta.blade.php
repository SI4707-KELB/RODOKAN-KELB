@extends('layouts.dashboard')

@section('title', 'Peta Sebaran Laporan - Admin RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-1 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Peta Sebaran Laporan
            </h1>
            <p class="text-slate-500 text-sm">Pantau persebaran laporan masyarakat di wilayah Kota Bandung secara real-time.</p>
        </div>
        <div class="flex items-center gap-2">
            <button id="btn-toggle-filter" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition-colors shadow-sm">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>
    </div>

    <!-- Filter Card (Toggleable) -->
    <div id="filter-panel" class="hidden mb-6 bg-white border border-slate-200 rounded-2xl p-5 shadow-sm transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800">Filter Laporan</h3>
            <a href="{{ route('admin.peta.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                Reset Filter
            </a>
        </div>
        <form method="GET" action="{{ route('admin.peta.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Cari</label>
                <input type="text" id="search" name="search" placeholder="Cari judul laporan atau pelapor..." value="{{ request('search') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Kategori</label>
                <select id="kategori" name="kategori" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" @selected(request('kategori') == $kat->id)>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kecamatan -->
            <div>
                <label for="kecamatan" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Kecamatan</label>
                <select id="kecamatan" name="kecamatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatanList as $kec)
                        <option value="{{ $kec }}" @selected(request('kecamatan') === $kec)>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Status</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Urgensi -->
            <div>
                <label for="urgensi" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Urgensi</label>
                <select id="urgensi" name="urgensi" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Urgensi</option>
                    @foreach($urgencies as $urg)
                        <option value="{{ $urg }}" @selected(request('urgensi') === $urg)>{{ $urg }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Dari -->
            <div>
                <label for="tanggal_dari" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Dari Tanggal</label>
                <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <!-- Tanggal Sampai -->
            <div>
                <label for="tanggal_sampai" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-500">Sampai Tanggal</label>
                <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <!-- Buttons -->
            <div class="md:col-span-3 lg:col-span-4 flex justify-end gap-2 mt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Peta Utama Card -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm mb-8 flex flex-col">
        <div class="relative rounded-2xl overflow-hidden border border-slate-200/80 bg-slate-50 min-h-[480px] h-[550px] w-full">
            <div id="admin-sebaran-map" class="w-full h-full z-10 absolute inset-0"></div>

            <!-- Overlay: Total Marker -->
            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-4 py-3 rounded-2xl shadow-xl z-[20] border border-slate-100 flex flex-col min-w-[120px]">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Total Marker</span>
                <span class="text-2xl font-black text-slate-800 mt-0.5" id="total-marker-count">{{ count($petaSebaran) }}</span>
            </div>

            <!-- Overlay: Legenda Kategori -->
            <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-md px-5 py-4 rounded-2xl shadow-xl z-[20] border border-slate-100 max-w-[240px]">
                <div class="text-xs font-bold text-slate-800 mb-3 border-b border-slate-100 pb-1.5 tracking-wide uppercase">Legenda Kategori</div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0 shadow-sm border border-white"></span>
                        Infrastruktur
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-yellow-500 shrink-0 shadow-sm border border-white"></span>
                        Kebersihan
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-purple-500 shrink-0 shadow-sm border border-white"></span>
                        Keamanan
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-cyan-500 shrink-0 shadow-sm border border-white"></span>
                        Energi & Air
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-red-500 shrink-0 shadow-sm border border-white"></span>
                        Kesehatan
                    </div>
                    <div class="flex items-center gap-2.5 text-[11px] font-semibold text-slate-600">
                        <span class="w-3 h-3 rounded-full bg-slate-500 shrink-0 shadow-sm border border-white"></span>
                        Lainnya
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Small Summary Cards (Mockup Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Laporan -->
        <div class="bg-blue-600 rounded-3xl p-6 shadow-lg shadow-blue-600/10 text-white flex flex-col justify-between min-h-[140px] relative overflow-hidden">
            <div class="absolute right-4 top-4 bg-white/10 w-12 h-12 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <span class="text-3xl font-black tracking-tight">{{ number_format($totalLaporan) }}</span>
                <p class="text-[11px] font-bold tracking-wider text-blue-100/90 uppercase mt-1">Total Laporan</p>
            </div>
        </div>

        <!-- Hari Ini -->
        <div class="bg-emerald-500 rounded-3xl p-6 shadow-lg shadow-emerald-500/10 text-white flex flex-col justify-between min-h-[140px] relative overflow-hidden">
            <div class="absolute right-4 top-4 bg-white/10 w-12 h-12 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-3xl font-black tracking-tight">{{ number_format($hariIniCount) }}</span>
                <p class="text-[11px] font-bold tracking-wider text-emerald-100/90 uppercase mt-1">Hari Ini</p>
            </div>
        </div>

        <!-- Kec. Terbanyak -->
        <div class="bg-purple-600 rounded-3xl p-6 shadow-lg shadow-purple-600/10 text-white flex flex-col justify-between min-h-[140px] relative overflow-hidden">
            <div class="absolute right-4 top-4 bg-white/10 w-12 h-12 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            </div>
            <div>
                <span class="text-2xl font-black tracking-tight truncate block max-w-[180px]">{{ $kecamatanTerbanyak }}</span>
                <p class="text-[11px] font-bold tracking-wider text-purple-100/90 uppercase mt-1">Kec. Terbanyak</p>
            </div>
        </div>

        <!-- Kategori Dominan -->
        <div class="bg-indigo-700 rounded-3xl p-6 shadow-lg shadow-indigo-700/10 text-white flex flex-col justify-between min-h-[140px] relative overflow-hidden">
            <div class="absolute right-4 top-4 bg-white/10 w-12 h-12 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
            </div>
            <div>
                <span class="text-2xl font-black tracking-tight truncate block max-w-[180px]">{{ $kategoriDominan }}</span>
                <p class="text-[11px] font-bold tracking-wider text-indigo-100/90 uppercase mt-1">Kategori Dominan</p>
            </div>
        </div>
    </div>

    <!-- Lower Section: Performance Metrics & Status Penanganan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 3 Performance Cards -->
        <div class="lg:col-span-2 space-y-4 flex flex-col justify-between">
            <!-- Wilayah Prioritas -->
            <div class="bg-purple-50/50 rounded-2xl border border-purple-200/70 p-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-purple-500">Wilayah Prioritas</span>
                        <h4 class="text-lg font-black text-slate-800 mt-0.5">{{ $wilayahPrioritas }}</h4>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-purple-700 bg-purple-100/60 px-3 py-1 rounded-xl">{{ $wilayahPrioritasLaporanAktif }} laporan aktif</span>
                </div>
            </div>

            <!-- Rata-rata Waktu Respon -->
            <div class="bg-amber-50/50 rounded-2xl border border-amber-200/70 p-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-500">Rata-rata Waktu Respon</span>
                        <h4 class="text-lg font-black text-slate-800 mt-0.5">{{ $rataRataWaktuRespon }}</h4>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-amber-600 bg-amber-100/60 px-3 py-1 rounded-xl flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path></svg>
                        15% dari minggu lalu
                    </span>
                </div>
            </div>

            <!-- Tingkat Penyelesaian -->
            <div class="bg-emerald-50/40 rounded-2xl border border-emerald-200/70 p-5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Tingkat Penyelesaian</span>
                        <h4 class="text-lg font-black text-slate-800 mt-0.5">{{ $tingkatPenyelesaian }}</h4>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-100/60 px-3 py-1 rounded-xl flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path></svg>
                        5% dari bulan lalu
                    </span>
                </div>
            </div>
        </div>

        <!-- Status Penanganan Progress Cards -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-extrabold text-slate-800 text-sm mb-5 uppercase tracking-wide">Status Penanganan</h3>
                
                @php
                    $totalStatus = max(1, $menungguCount + $diprosesCount + $ditindaklanjutiCount + $selesaiCount);
                    $menungguPct = ($menungguCount / $totalStatus) * 100;
                    $diprosesPct = ($diprosesCount / $totalStatus) * 100;
                    $ditindaklanjutiPct = ($ditindaklanjutiCount / $totalStatus) * 100;
                    $selesaiPct = ($selesaiCount / $totalStatus) * 100;
                @endphp

                <div class="space-y-4">
                    <!-- Menunggu Verifikasi -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Menunggu Verifikasi</span>
                            <span class="text-slate-900">{{ $menungguCount }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-amber-400" style="width: {{ $menungguPct }}%"></div>
                        </div>
                    </div>

                    <!-- Diproses -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Diproses</span>
                            <span class="text-slate-900">{{ $diprosesCount }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-blue-500" style="width: {{ $diprosesPct }}%"></div>
                        </div>
                    </div>

                    <!-- Ditindaklanjuti -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Ditindaklanjuti</span>
                            <span class="text-slate-900">{{ $ditindaklanjutiCount }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-orange-500" style="width: {{ $ditindaklanjutiPct }}%"></div>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1.5">
                            <span>Selesai</span>
                            <span class="text-slate-900">{{ $selesaiCount }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="h-2 rounded-full bg-green-500" style="width: {{ $selesaiPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Styling leaflet custom popups & overlays */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
        padding: 4px;
        border: 1px solid #f1f5f9;
    }
    .leaflet-popup-content {
        margin: 8px 12px;
        font-family: 'Inter', sans-serif;
    }
    .leaflet-popup-tip {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Filter Panel
    const btnToggleFilter = document.getElementById('btn-toggle-filter');
    const filterPanel = document.getElementById('filter-panel');
    if (btnToggleFilter && filterPanel) {
        btnToggleFilter.addEventListener('click', function() {
            filterPanel.classList.toggle('hidden');
        });
    }

    // Initialize Map
    if (document.getElementById('admin-sebaran-map')) {
        // Center of Bandung approximation
        const map = L.map('admin-sebaran-map', { zoomControl: false }).setView([-6.9175, 107.6191], 13);
        
        L.control.zoom({ position: 'topright' }).addTo(map);

        // Voyager Tile Layer
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Points data from Laravel backend
        const rawPoints = @json($petaSebaran);
        
        // Define color scheme for categories
        // ID 1: Infrastruktur, ID 2: Kebersihan, ID 3: Keamanan, ID 4: Energi & Air, ID 5: Kesehatan, default/other
        const categoryColors = {
            1: '#3b82f6', // Infrastruktur (Blue)
            2: '#eab308', // Kebersihan (Yellow)
            3: '#8b5cf6', // Keamanan (Purple)
            4: '#06b6d4', // Energi & Air (Cyan)
            5: '#ef4444', // Kesehatan (Red)
        };

        const defaultColor = '#64748b'; // Lainnya (Slate)

        if (rawPoints && rawPoints.length > 0) {
            rawPoints.forEach(function(pt) {
                if (!pt.latitude || !pt.longitude) return;

                const color = categoryColors[pt.kategori_id] || defaultColor;
                
                // Outer circle for halo effect
                L.circleMarker([pt.latitude, pt.longitude], {
                    radius: 12,
                    fillColor: color,
                    color: "transparent",
                    weight: 0,
                    fillOpacity: 0.15
                }).addTo(map);
                
                // Inner circle for marker point
                const marker = L.circleMarker([pt.latitude, pt.longitude], {
                    radius: 5,
                    fillColor: color,
                    color: "#ffffff",
                    weight: 1.5,
                    fillOpacity: 1
                });

                // Detail popup content matching design theme
                const popupContent = `
                    <div class="text-[11px] font-bold text-blue-600 mb-0.5">RK-${String(pt.id).padStart(4, '0')}</div>
                    <div class="text-xs font-black text-slate-800 leading-snug mb-1">${pt.judul_laporan}</div>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase border border-slate-200 bg-slate-50 text-slate-600">
                            ${pt.kategori ? pt.kategori.nama : 'Lainnya'}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-blue-50 text-blue-600">
                            ${pt.status}
                        </span>
                    </div>
                `;

                marker.bindPopup(popupContent).addTo(map);
            });

            // Adjust bounds automatically to fit all points
            const group = new L.featureGroup(rawPoints.map(function(pt) {
                return L.marker([pt.latitude, pt.longitude]);
            }));
            map.fitBounds(group.getBounds().pad(0.1));
        } else {
            // Dummy Data fallback if no points are registered in DB
            const dummyPoints = [
                { id: 1, c: [-6.9175, 107.6191], kat: 1, judul: 'Jalan Dago Berlubang Parah', status: 'Diproses' },
                { id: 2, c: [-6.8923, 107.6105], kat: 2, judul: 'Sampah Menumpuk di Babakan Siliwangi', status: 'Menunggu' },
                { id: 3, c: [-6.9234, 107.6012], kat: 3, judul: 'Kekacauan Parkir Liar di Alun-Alun', status: 'Ditindaklanjuti' },
                { id: 4, c: [-6.9381, 107.6321], kat: 4, judul: 'Pipa Air PDAM Bocor di Kiaracondong', status: 'Diproses' },
                { id: 5, c: [-6.9512, 107.5901], kat: 5, judul: 'Genangan Nyamuk DBD di Pasirkoja', status: 'Selesai' },
                { id: 6, c: [-6.9012, 107.6543], kat: 1, judul: 'Lampu Penerangan Jalan Padam', status: 'Menunggu' }
            ];

            dummyPoints.forEach(function(pt) {
                const color = categoryColors[pt.kat] || defaultColor;

                L.circleMarker(pt.c, { radius: 12, fillColor: color, color: "transparent", weight: 0, fillOpacity: 0.15 }).addTo(map);
                const marker = L.circleMarker(pt.c, { radius: 5, fillColor: color, color: "#ffffff", weight: 1.5, fillOpacity: 1 });

                const popupContent = `
                    <div class="text-[11px] font-bold text-blue-600 mb-0.5">RK-${String(pt.id).padStart(4, '0')}</div>
                    <div class="text-xs font-black text-slate-800 leading-snug mb-1">${pt.judul}</div>
                    <div class="flex items-center gap-1.5 mt-2">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase border border-slate-200 bg-slate-50 text-slate-600">
                            ${pt.kat === 1 ? 'Infrastruktur' : pt.kat === 2 ? 'Kebersihan' : pt.kat === 3 ? 'Keamanan' : pt.kat === 4 ? 'Energi & Air' : 'Kesehatan'}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-blue-50 text-blue-600">
                            ${pt.status}
                        </span>
                    </div>
                `;
                marker.bindPopup(popupContent).addTo(map);
            });
        }
    }
});
</script>
@endpush
@endsection
