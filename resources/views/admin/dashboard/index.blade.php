@extends('layouts.dashboard')

@section('title', 'Dashboard Pemerintah Kota Bandung - RODOKAN')

@section('content')
<!-- Admin Dashboard View -->
<style>
.dashboard-container {
    padding: 24px 32px;
    font-family: 'Inter', sans-serif;
    color: #1e293b;
    max-width: 1400px;
    margin: 0 auto;
}
.header-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 4px;
}
.header-subtitle {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 24px;
}

/* Grid Layout */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px;
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 120px;
    position: relative;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.stat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.stat-icon svg { width: 18px; height: 18px; }
.stat-value {
    font-size: 28px;
    font-weight: 800;
    margin-top: 16px;
    line-height: 1;
}
.stat-label {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}
.stat-trend {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 2px;
}
.trend-up { color: #10b981; }
.trend-down { color: #ef4444; }

/* Colors */
.bg-blue-light { background: #eff6ff; color: #3b82f6; }
.bg-orange-light { background: #fff7ed; color: #f97316; }
.bg-purple-light { background: #f3e8ff; color: #a855f7; }
.bg-green-light { background: #ecfdf5; color: #10b981; }
.bg-red-light { background: #fef2f2; color: #ef4444; }

/* Main Content Grid */
.main-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}
@media (max-width: 1024px) {
    .main-grid { grid-template-columns: 1fr; }
}
.card-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.card-title {
    font-size: 16px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}
.map-container {
    background: #eff6ff;
    border-radius: 8px;
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    border: 1px solid #bfdbfe;
}
.map-graphic {
    position: absolute;
    width: 60%;
    height: 60%;
    border: 2px solid #3b82f6;
    border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
}
.map-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.map-legend {
    position: absolute;
    bottom: 16px;
    left: 16px;
    background: white;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    font-size: 12px;
}
.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 4px;
}
.legend-color { width: 8px; height: 8px; border-radius: 50%; }

/* Darurat List */
.darurat-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.darurat-item {
    border: 1px solid #fecaca;
    background: #fff5f5;
    padding: 12px;
    border-radius: 8px;
}
.darurat-id { font-size: 11px; color: #ef4444; font-weight: 600; margin-bottom: 2px; }
.darurat-title { font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px; }
.darurat-meta { display: flex; justify-content: space-between; font-size: 12px; color: #64748b; }

/* Progress Bars */
.progress-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.progress-item-label { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 4px; }
.progress-item-label span:first-child { color: #475569; }
.progress-item-label span:last-child { font-weight: 600; color: #1e293b; }
.progress-bar-bg { background: #f1f5f9; height: 6px; border-radius: 3px; overflow: hidden; }
.progress-bar-fill { height: 100%; border-radius: 3px; }

/* Table */
.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; }
.data-table td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
.badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; }
.badge-darurat { background: #fee2e2; color: #ef4444; }
.badge-menunggu { background: #fef3c7; color: #d97706; }
.badge-diproses { background: #dbeafe; color: #2563eb; }
</style>

<div class="dashboard-container">
    <div class="header-title">Dashboard Pemerintah Kota Bandung</div>
    <div class="header-subtitle">Pantau laporan masyarakat Kota Bandung secara real-time, transparan, dan terintegrasi.</div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="stat-trend {{ $trendTotalLaporan >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendTotalLaporan >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendTotalLaporan > 0 ? '+' : '' }}{{ $trendTotalLaporan }}%
            </div>
            <div>
                <div class="stat-value">{{ $totalLaporanHariIni ?? 0 }}</div>
                <div class="stat-label">Total Laporan Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-orange-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="stat-trend {{ $trendMenunggu >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendMenunggu >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendMenunggu > 0 ? '+' : '' }}{{ $trendMenunggu }}
            </div>
            <div>
                <div class="stat-value">{{ $menungguVerifikasi ?? 0 }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-purple-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div class="stat-trend {{ $trendDiproses >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendDiproses >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendDiproses > 0 ? '+' : '' }}{{ $trendDiproses }}
            </div>
            <div>
                <div class="stat-value">{{ $sedangDiproses ?? 0 }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="stat-trend {{ $trendDitindaklanjuti >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendDitindaklanjuti >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendDitindaklanjuti > 0 ? '+' : '' }}{{ $trendDitindaklanjuti }}
            </div>
            <div>
                <div class="stat-value">{{ $ditindaklanjuti ?? 0 }}</div>
                <div class="stat-label">Ditindaklanjuti</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="stat-trend {{ $trendSelesai >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendSelesai >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendSelesai > 0 ? '+' : '' }}{{ $trendSelesai }}
            </div>
            <div>
                <div class="stat-value">{{ $selesai ?? 0 }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
        <div class="stat-card" style="border-color: #fecaca; background: #fffcfc;">
            <div class="stat-icon bg-red-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="stat-trend {{ $trendDarurat >= 0 ? 'trend-up' : 'trend-down' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="12" height="12">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $trendDarurat >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"></path>
                </svg> 
                {{ $trendDarurat > 0 ? '+' : '' }}{{ $trendDarurat }}
            </div>
            <div>
                <div class="stat-value" style="color: #ef4444;">{{ $laporanDarurat ?? 0 }}</div>
                <div class="stat-label">Laporan Darurat</div>
            </div>
        </div>
    </div>

    <!-- Main Section -->
    <div class="main-grid">
        <div class="card-box">
            <div class="card-header">
                <div class="card-title">Peta Sebaran Laporan</div>
                <span class="badge" style="background:#dcfce7; color:#16a34a;">Live</span>
            </div>
            <div class="map-container">
                <!-- Decorative Map -->
                <div class="map-graphic"></div>
                <div class="map-dot" style="background:#ef4444; top:40%; left:30%;"></div>
                <div class="map-dot" style="background:#f97316; top:35%; left:50%;"></div>
                <div class="map-dot" style="background:#ef4444; top:45%; left:60%;"></div>
                <div class="map-dot" style="background:#3b82f6; top:60%; left:25%;"></div>
                <div class="map-dot" style="background:#a855f7; top:70%; left:40%;"></div>
                <div class="map-dot" style="background:#10b981; top:65%; left:50%;"></div>
                
                <div class="map-legend">
                    <div style="font-weight:600; margin-bottom:8px;">Status Laporan</div>
                    <div class="legend-item"><div class="legend-color" style="background:#ef4444;"></div> Darurat</div>
                    <div class="legend-item"><div class="legend-color" style="background:#f97316;"></div> Menunggu</div>
                    <div class="legend-item"><div class="legend-color" style="background:#3b82f6;"></div> Diproses</div>
                    <div class="legend-item"><div class="legend-color" style="background:#10b981;"></div> Selesai</div>
                </div>
            </div>
            <div style="font-size:12px; color:#64748b; margin-top:16px;">Menampilkan laporan aktif di Kota Bandung</div>
        </div>

        <div class="card-box">
            <div class="card-header">
                <div class="card-title" style="color: #ef4444;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Laporan Darurat
                </div>
            </div>
            <div class="darurat-list">
                @forelse($daftarDarurat ?? [] as $darurat)
                <div class="darurat-item">
                    <div class="darurat-id">RPT-2026-{{ str_pad($darurat->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="darurat-title">{{ $darurat->judul_laporan }}</div>
                    <div class="darurat-meta">
                        <span>{{ $darurat->kecamatan ?? 'Tidak diketahui' }}</span>
                        <span style="color:#ef4444;">{{ $darurat->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align:center; color:#94a3b8; font-size:13px; padding:20px 0;">Tidak ada laporan darurat.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="main-grid">
        <div class="card-box">
            <div class="card-header"><div class="card-title">Tren Laporan 7 Hari Terakhir</div></div>
            <div style="height: 250px;">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        
        <div class="flex flex-col gap-6">
            <div class="card-box">
                <div class="card-header"><div class="card-title">Kategori Terbanyak</div></div>
                <div class="progress-list">
                    @php $colors = ['#f97316', '#10b981', '#3b82f6', '#8b5cf6']; $i=0; @endphp
                    @forelse($kategoriTerbanyak ?? [] as $kat)
                    @php 
                        $pct = $kat->total / max($totalLaporanHariIni ?: 1, 1) * 100;
                        if($pct > 100) $pct = 100;
                        $color = $colors[$i % count($colors)];
                        $i++;
                    @endphp
                    <div>
                        <div class="progress-item-label">
                            <span>{{ $kat->kategori }}</span>
                            <span>{{ $kat->total }}</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ $pct }}%; background: {{ $color }};"></div>
                        </div>
                    </div>
                    @empty
                    <div style="font-size:12px; color:#64748b;">Belum ada data</div>
                    @endforelse
                </div>
            </div>

            <div class="card-box">
                <div class="card-header"><div class="card-title">Kecamatan Terbanyak</div></div>
                <div class="progress-list">
                    @forelse($kecamatanTerbanyak ?? [] as $kec)
                    @php 
                        $pct = $kec->total / max($totalLaporanHariIni ?: 1, 1) * 100;
                        if($pct > 100) $pct = 100;
                    @endphp
                    <div>
                        <div class="progress-item-label">
                            <span>{{ $kec->kecamatan ?? 'Lainnya' }}</span>
                            <span>{{ $kec->total }}</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ $pct }}%; background: #3b82f6;"></div>
                        </div>
                    </div>
                    @empty
                    <div style="font-size:12px; color:#64748b;">Belum ada data</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <div class="card-title">Laporan Terbaru</div>
                <div style="font-size:13px; color:#64748b; margin-top:4px;">Daftar laporan yang masuk hari ini</div>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Laporan</th>
                        <th>Kategori</th>
                        <th>Kecamatan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanTerbaru ?? [] as $lap)
                    <tr>
                        <td style="font-weight:600; color:#475569;">RPT-{{ str_pad($lap->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="font-weight:500;">{{ Str::limit($lap->judul_laporan, 30) }}</td>
                        <td>{{ $lap->kategori->nama ?? '-' }}</td>
                        <td>{{ $lap->kecamatan ?? '-' }}</td>
                        <td>
                            @if($lap->status == 'Darurat') <span class="badge badge-darurat">Darurat</span>
                            @elseif($lap->status == 'Menunggu') <span class="badge badge-menunggu">Menunggu</span>
                            @elseif($lap->status == 'Diproses') <span class="badge badge-diproses">Diproses</span>
                            @elseif($lap->status == 'Selesai') <span class="badge" style="background:#dcfce7; color:#16a34a;">Selesai</span>
                            @else <span class="badge" style="background:#f1f5f9; color:#475569;">{{ $lap->status }}</span>
                            @endif
                        </td>
                        <td style="color:#64748b; font-size:13px;">{{ $lap->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.laporan.show', $lap->id) }}" style="color:#3b82f6; display:flex; align-items:center; gap:4px; font-weight:500; font-size:13px; text-decoration:none;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Tinjau
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:30px; color:#64748b;">Belum ada laporan hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('trendChart').getContext('2d');
    
    // Prepare Data
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

    // No fallback dummy data as requested by user

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Laporan',
                data: dataPoints,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11 }
                    }
                }
            }
        }
    });
});
</script>
@endsection
