@extends('layouts.dashboard')

@section('title', 'Analisis Keseluruhan Laporan - Admin RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Analisis Keseluruhan Laporan</h1>
        <p class="text-slate-500 text-sm">Pantau statistik, tren, dan sebaran laporan masyarakat secara terpusat.</p>
    </div>

    <!-- Stats Grid (6 items) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendTotalLaporan >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendTotalLaporan >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path></svg>
                    {{ $trendTotalLaporan > 0 ? '+' : '' }}{{ $trendTotalLaporan }}%
                </span>
            </div>
            <div class="text-[11px] font-medium text-slate-500 mb-0.5 uppercase tracking-wide">Total (Hari Ini)</div>
            <div class="text-2xl font-bold text-slate-900">{{ $totalLaporanHariIni ?? 0 }}</div>
        </div>

        <!-- Menunggu -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendMenunggu >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trendMenunggu > 0 ? '+' : '' }}{{ $trendMenunggu }}
                </span>
            </div>
            <div class="text-[11px] font-medium text-slate-500 mb-0.5 uppercase tracking-wide">Menunggu</div>
            <div class="text-2xl font-bold text-slate-900">{{ $menungguVerifikasi ?? 0 }}</div>
        </div>

        <!-- Diproses -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendDiproses >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trendDiproses > 0 ? '+' : '' }}{{ $trendDiproses }}
                </span>
            </div>
            <div class="text-[11px] font-medium text-slate-500 mb-0.5 uppercase tracking-wide">Diproses</div>
            <div class="text-2xl font-bold text-slate-900">{{ $sedangDiproses ?? 0 }}</div>
        </div>

        <!-- Ditindaklanjuti -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendDitindaklanjuti >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trendDitindaklanjuti > 0 ? '+' : '' }}{{ $trendDitindaklanjuti }}
                </span>
            </div>
            <div class="text-[11px] font-medium text-slate-500 mb-0.5 uppercase tracking-wide">Ditindaklanjuti</div>
            <div class="text-2xl font-bold text-slate-900">{{ $ditindaklanjuti ?? 0 }}</div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendSelesai >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $trendSelesai > 0 ? '+' : '' }}{{ $trendSelesai }}
                </span>
            </div>
            <div class="text-[11px] font-medium text-slate-500 mb-0.5 uppercase tracking-wide">Selesai</div>
            <div class="text-2xl font-bold text-slate-900">{{ $selesai ?? 0 }}</div>
        </div>

        <!-- Darurat -->
        <div class="bg-red-50 rounded-2xl border border-red-200 p-4 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex justify-between items-start mb-2">
                <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <span class="flex items-center text-[10px] font-bold {{ $trendDarurat > 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $trendDarurat > 0 ? '+' : '' }}{{ $trendDarurat }}
                </span>
            </div>
            <div class="text-[11px] font-bold text-red-800 mb-0.5 uppercase tracking-wide">Darurat</div>
            <div class="text-2xl font-extrabold text-red-600">{{ $laporanDarurat ?? 0 }}</div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Peta Sebaran (Spans 2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <h3 class="font-bold text-slate-800">Peta Sebaran Laporan</h3>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 uppercase tracking-wide border border-green-100 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Live
                </span>
            </div>
            <div class="relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex-1 min-h-[350px]">
                <div id="admin-map" class="w-full h-full z-10 absolute inset-0"></div>
                
                <!-- Legend overlay -->
                <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-3 rounded-xl shadow-lg z-[20] border border-slate-100">
                    <div class="text-xs font-bold text-slate-800 mb-2">Status Marker</div>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2 text-[10px] font-medium text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span> Darurat</div>
                        <div class="flex items-center gap-2 text-[10px] font-medium text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span> Menunggu</div>
                        <div class="flex items-center gap-2 text-[10px] font-medium text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Diproses</div>
                        <div class="flex items-center gap-2 text-[10px] font-medium text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span> Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Darurat List -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col">
            <div class="flex items-center gap-2 mb-4 text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="font-bold">Perlu Penanganan (Darurat)</h3>
            </div>
            
            <div class="space-y-3 overflow-y-auto flex-1 pr-1 custom-scrollbar">
                @forelse($daftarDarurat ?? [] as $darurat)
                <div class="bg-red-50/50 rounded-xl border border-red-100 p-3 hover:bg-red-50 transition-colors">
                    <div class="text-[10px] font-bold text-red-600 mb-1">RPT-2026-{{ str_pad($darurat->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="text-sm font-bold text-slate-800 mb-2 leading-snug">{{ $darurat->judul_laporan }}</div>
                    <div class="flex items-center justify-between mt-auto">
                        <div class="flex items-center text-[10px] text-slate-500 gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $darurat->kecamatan ?? 'Lokasi' }}
                        </div>
                        <div class="text-[10px] font-semibold text-red-500">{{ $darurat->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-slate-400 py-10">
                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-xs font-medium">Tidak ada laporan darurat</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Charts & Progress Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        
        <!-- Trend Chart -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="font-bold text-slate-800 mb-6">Tren Laporan Masuk (7 Hari Terakhir)</h3>
            <div class="h-[250px] w-full relative">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Distributions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Kategori -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-5 text-sm">Distribusi Kategori</h3>
                <div class="space-y-4">
                    @php $colors = ['#f97316', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899']; $i=0; @endphp
                    @forelse($kategoriTerbanyak ?? [] as $kat)
                    @php 
                        $pct = $kat->total / max($totalLaporanHariIni ?: 1, 1) * 100;
                        if($pct > 100) $pct = 100;
                        $color = $colors[$i % count($colors)];
                        $i++;
                    @endphp
                    <div>
                        <div class="flex justify-between text-[11px] mb-1.5 font-medium">
                            <span class="text-slate-600">{{ $kat->kategori }}</span>
                            <span class="text-slate-900 font-bold">{{ $kat->total }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full" style="width: {{ $pct }}%; background-color: {{ $color }};"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-xs text-slate-500">Belum ada data</div>
                    @endforelse
                </div>
            </div>

            <!-- Kecamatan -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-5 text-sm">Sebaran Wilayah (Kecamatan)</h3>
                <div class="space-y-4">
                    @forelse($kecamatanTerbanyak ?? [] as $kec)
                    @php 
                        $pct = $kec->total / max($totalLaporanHariIni ?: 1, 1) * 100;
                        if($pct > 100) $pct = 100;
                    @endphp
                    <div>
                        <div class="flex justify-between text-[11px] mb-1.5 font-medium">
                            <span class="text-slate-600">{{ $kec->kecamatan ?? 'Lainnya' }}</span>
                            <span class="text-slate-900 font-bold">{{ $kec->total }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full bg-blue-500" style="width: {{ $pct }}%;"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-xs text-slate-500">Belum ada data</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-lg">Log Laporan Terbaru</h3>
                <p class="text-xs text-slate-500 mt-1">Daftar keluhan yang baru saja masuk ke sistem</p>
            </div>
            <a href="{{ route('admin.laporan.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 px-4 py-2 rounded-xl transition-colors">
                Kelola Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="text-[10px] text-slate-500 uppercase tracking-wider bg-slate-50 border-y border-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold rounded-tl-xl rounded-bl-xl">ID Ref</th>
                        <th class="px-4 py-3 font-semibold">Judul Keluhan</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold">Lokasi</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right rounded-tr-xl rounded-br-xl">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporanTerbaru ?? [] as $lap)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-4 py-3.5 font-mono text-xs text-slate-500">RPT-{{ str_pad($lap->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3.5 font-semibold text-slate-800 max-w-[200px] truncate" title="{{ $lap->judul_laporan }}">{{ $lap->judul_laporan }}</td>
                        <td class="px-4 py-3.5">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-md text-[10px] font-bold uppercase tracking-wider">{{ $lap->kategori->nama ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3.5 text-xs text-slate-600">{{ $lap->kecamatan ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            @if($lap->status == 'Darurat') 
                                <span class="px-2 py-1 bg-red-50 text-red-600 border border-red-100 rounded-full text-[10px] font-bold uppercase">Darurat</span>
                            @elseif($lap->status == 'Menunggu') 
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-full text-[10px] font-bold uppercase">Menunggu</span>
                            @elseif($lap->status == 'Diproses' || $lap->status == 'Ditindaklanjuti') 
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 border border-blue-100 rounded-full text-[10px] font-bold uppercase">Diproses</span>
                            @elseif($lap->status == 'Selesai') 
                                <span class="px-2 py-1 bg-green-50 text-green-600 border border-green-100 rounded-full text-[10px] font-bold uppercase">Selesai</span>
                            @else 
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase">{{ $lap->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-right">
                            <a href="{{ route('admin.laporan.show', $lap->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-800 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Tinjau
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-sm text-slate-500">Belum ada laporan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
@if(config('app.env') !== 'testing')
<!-- Leaflet & ChartJS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Map
    if(document.getElementById('admin-map')) {
        var map = L.map('admin-map', { zoomControl: false }).setView([-6.9175, 107.6191], 12); // Center on Bandung approx
        
        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        var points = @json($petaSebaran ?? []);
        
        // Render real data if available, else dummy
        if (points && points.length > 0) {
            points.forEach(function(pt) {
                var color = "#3b82f6"; // Diproses (Blue) by default
                if(pt.status === 'Darurat') color = "#ef4444"; // Red
                else if(pt.status === 'Menunggu') color = "#eab308"; // Yellow
                else if(pt.status === 'Selesai') color = "#10b981"; // Green
                
                L.circleMarker([pt.latitude, pt.longitude], {
                    radius: 10, fillColor: color, color: "transparent", weight: 0, fillOpacity: 0.2
                }).addTo(map);
                
                L.circleMarker([pt.latitude, pt.longitude], {
                    radius: 4, fillColor: color, color: "#ffffff", weight: 1.5, fillOpacity: 1
                }).bindPopup("<b>" + pt.judul_laporan + "</b><br>" + pt.status).addTo(map);
            });
        } else {
            // Dummy data for design showcase
            var dummyPoints = [
                {c: [-6.9175, 107.6191], t: 'blue'}, {c: [-6.89, 107.61], t: 'blue'},
                {c: [-6.92, 107.60], t: 'red'}, {c: [-6.93, 107.63], t: 'yellow'},
                {c: [-6.95, 107.59], t: 'green'}, {c: [-6.90, 107.65], t: 'green'}
            ];
            dummyPoints.forEach(function(pt) {
                var hex = pt.t === 'red' ? '#ef4444' : pt.t === 'yellow' ? '#eab308' : pt.t === 'green' ? '#10b981' : '#3b82f6';
                var rOuter = pt.t === 'red' ? 14 : 10;
                var rInner = pt.t === 'red' ? 5 : 4;
                
                L.circleMarker(pt.c, { radius: rOuter, fillColor: hex, color: "transparent", weight: 0, fillOpacity: 0.2 }).addTo(map);
                L.circleMarker(pt.c, { radius: rInner, fillColor: hex, color: "#ffffff", weight: 1.5, fillOpacity: 1 }).addTo(map);
            });
        }
    }

    // 2. Initialize Trend Chart
    if(document.getElementById('trendChart')) {
        const ctx = document.getElementById('trendChart').getContext('2d');
        
        const labels = [
            @if(isset($tren7Hari))
                @foreach($tren7Hari as $trend)
                    "{{ \Carbon\Carbon::parse($trend->date)->format('d M') }}",
                @endforeach
            @endif
        ];
        
        const dataPoints = [
            @if(isset($tren7Hari))
                @foreach($tren7Hari as $trend)
                    {{ $trend->total }},
                @endforeach
            @endif
        ];

        // Gradient
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.length > 0 ? labels : ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming'],
                datasets: [{
                    label: 'Total Laporan',
                    data: dataPoints.length > 0 ? dataPoints : [5, 12, 8, 15, 20, 14, 25], // dummy fallback for layout viewing
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        border: { display: false },
                        ticks: { color: '#64748b', font: { size: 11, family: 'Inter' }, padding: 10 }
                    },
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: { color: '#64748b', font: { size: 11, family: 'Inter' }, padding: 10 }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }
});
</script>
@endif
@endpush
@endsection
