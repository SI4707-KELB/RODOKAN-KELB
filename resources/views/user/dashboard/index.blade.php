@extends('layouts.dashboard')

@section('title', 'Dashboard Masyarakat - RODOKAN')

@section('content')
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

/* Colors */
.bg-blue-light { background: #eff6ff; color: #3b82f6; }
.bg-orange-light { background: #fff7ed; color: #f97316; }
.bg-green-light { background: #ecfdf5; color: #10b981; }

.card-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    margin-bottom: 24px;
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

/* Table */
.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; }
.data-table td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
.badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500; }
.badge-darurat { background: #fee2e2; color: #ef4444; }
.badge-menunggu { background: #fef3c7; color: #d97706; }
.badge-diproses { background: #dbeafe; color: #2563eb; }
.badge-selesai { background: #dcfce7; color: #16a34a; }
</style>

<div class="dashboard-container">
    <div class="header-title">Dashboard Anda</div>
    <div class="header-subtitle">Pantau status laporan yang telah Anda kirimkan.</div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <div class="stat-value">{{ $totalLaporanku ?? 0 }}</div>
                <div class="stat-label">Total Laporan Anda</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-orange-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="stat-value">{{ $laporanDiproses ?? 0 }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-light">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <div class="stat-value">{{ $laporanSelesai ?? 0 }}</div>
                <div class="stat-label">Laporan Selesai</div>
            </div>
        </div>
    </div>

    <!-- Laporanku Table -->
    <div class="card-box">
        <div class="card-header">
            <div>
                <div class="card-title">Riwayat Laporan Saya</div>
                <div style="font-size:13px; color:#64748b; margin-top:4px;">Daftar laporan yang pernah Anda buat</div>
            </div>
            <div>
                <a href="{{ route('laporan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Laporan Baru
                </a>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul Laporan</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanku ?? [] as $lap)
                    <tr>
                        <td style="font-weight:600; color:#475569;">RPT-{{ str_pad($lap->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="font-weight:500;">{{ Str::limit($lap->judul_laporan, 50) }}</td>
                        <td>
                            @if($lap->status == 'Darurat') <span class="badge badge-darurat">Darurat</span>
                            @elseif($lap->status == 'Menunggu') <span class="badge badge-menunggu">Menunggu</span>
                            @elseif($lap->status == 'Diproses' || $lap->status == 'Ditindaklanjuti') <span class="badge badge-diproses">Diproses</span>
                            @elseif($lap->status == 'Selesai') <span class="badge badge-selesai">Selesai</span>
                            @else <span class="badge" style="background:#f1f5f9; color:#475569;">{{ $lap->status }}</span>
                            @endif
                        </td>
                        <td style="color:#64748b; font-size:13px;">{{ $lap->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:30px; color:#64748b;">
                            <div style="margin-bottom: 12px;">Anda belum membuat laporan apapun.</div>
                            <a href="{{ route('laporan.create') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Buat Laporan Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
