@extends('layouts.dashboard')

@section('title', 'Verifikasi Laporan Warga - RODOKAN')

@section('content')
<style>
.dashboard-container {
    padding: 24px 32px;
    font-family: 'Inter', sans-serif;
    color: #1e293b;
    max-width: 1200px;
}
.header-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 4px;
    color: #1e293b;
}
.header-subtitle {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 24px;
}

/* Stat Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}
.stat-card {
    border-radius: 12px;
    padding: 20px;
    color: white;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}
.stat-card.yellow { background: #eab308; }
.stat-card.green { background: #10b981; }
.stat-card.red { background: #ef4444; }
.stat-card.blue { background: #3b82f6; }

.stat-icon {
    width: 24px;
    height: 24px;
    margin-bottom: 12px;
    opacity: 0.9;
}
.stat-value {
    font-size: 32px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}
.stat-label {
    font-size: 12px;
    font-weight: 500;
    opacity: 0.9;
}

/* Tabs */
.tabs-container {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 24px;
}
.tabs-header {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
    padding: 0 16px;
}
.tab-link {
    padding: 16px 20px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}
.tab-link:hover {
    color: #3b82f6;
}
.tab-link.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
}
.tabs-content {
    padding: 24px;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
}

/* Report Cards */
.report-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    display: flex;
    gap: 20px;
    border: 1px solid #e2e8f0;
}
.report-card.border-menunggu { border-left: 6px solid #eab308; }
.report-card.border-terverifikasi { border-left: 6px solid #22c55e; }
.report-card.border-ditolak { border-left: 6px solid #ef4444; }

.report-image {
    width: 140px;
    height: 140px;
    border-radius: 8px;
    object-fit: cover;
    background: #e2e8f0;
    flex-shrink: 0;
}
.report-content {
    flex: 1;
}
.report-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
}
.report-badges {
    display: flex;
    align-items: center;
    gap: 8px;
}
.badge-id { font-size: 13px; font-weight: 700; color: #3b82f6; }
.badge {
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 600;
}
.badge-category { background: #dcfce7; color: #16a34a; } /* Default green */
.badge-category.infrastruktur { background: #ffedd5; color: #c2410c; }
.badge-category.bencana { background: #fee2e2; color: #b91c1c; }
.badge-category.pelayanan { background: #e0f2fe; color: #0369a1; }

.badge-urgency.medium { background: #fef3c7; color: #d97706; }
.badge-urgency.high { background: #fee2e2; color: #b91c1c; }
.badge-urgency.low { background: #f1f5f9; color: #64748b; }

.badge-status.terverifikasi { background: #22c55e; color: white; }
.badge-status.ditolak { background: #ef4444; color: white; }

.report-time { font-size: 12px; color: #94a3b8; }
.report-title { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
.report-desc { font-size: 14px; color: #475569; line-height: 1.5; margin-bottom: 16px; }

.report-meta {
    display: flex;
    align-items: center;
    gap: 24px;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
}
.meta-item { display: flex; align-items: center; gap: 6px; }

.report-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}
.btn-primary {
    background: #2563eb;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    border: none;
    cursor: pointer;
}
.btn-primary:hover { background: #1d4ed8; }
.btn-outline {
    background: white;
    color: #475569;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #cbd5e1;
    cursor: pointer;
}
.btn-outline:hover { background: #f8fafc; }

/* Review Note Boxes */
.note-box {
    margin-top: 16px;
    padding: 16px;
    border-radius: 8px;
    font-size: 13px;
}
.note-box.terverifikasi {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}
.note-box.ditolak {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}
.note-box-title { font-weight: 600; margin-bottom: 4px; opacity: 0.8; font-size: 12px; }
.note-box-content { line-height: 1.5; margin-bottom: 8px; font-weight: 500; }
.note-box-date { font-size: 11px; opacity: 0.7; }

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="dashboard-container">
    <div class="header-title">Verifikasi Laporan Warga</div>
    <div class="header-subtitle">Tinjau dan verifikasi laporan yang masuk dari masyarakat Kota Bandung</div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card yellow">
            <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="stat-value">{{ $menungguVerifikasi ?? 0 }}</div>
            <div class="stat-label">Menunggu Verifikasi</div>
        </div>
        <div class="stat-card green">
            <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="stat-value">{{ $terverifikasiHariIni ?? 0 }}</div>
            <div class="stat-label">Terverifikasi Hari Ini</div>
        </div>
        <div class="stat-card red">
            <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="stat-value">{{ $ditolakHariIni ?? 0 }}</div>
            <div class="stat-label">Ditolak Hari Ini</div>
        </div>
        <div class="stat-card blue">
            <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <div class="stat-value">{{ $rataRataWaktu ?? '0' }} jam</div>
            <div class="stat-label">Rata-rata Waktu Verifikasi</div>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="tabs-container">
        <div class="tabs-header">
            <a href="{{ route('verifikasi.index', ['tab' => 'menunggu']) }}" class="tab-link {{ $tab == 'menunggu' ? 'active' : '' }}">
                Menunggu Verifikasi ({{ $totalMenunggu ?? 0 }})
            </a>
            <a href="{{ route('verifikasi.index', ['tab' => 'terverifikasi']) }}" class="tab-link {{ $tab == 'terverifikasi' ? 'active' : '' }}">
                Terverifikasi ({{ $totalTerverifikasi ?? 0 }})
            </a>
            <a href="{{ route('verifikasi.index', ['tab' => 'ditolak']) }}" class="tab-link {{ $tab == 'ditolak' ? 'active' : '' }}">
                Ditolak ({{ $totalDitolak ?? 0 }})
            </a>
        </div>

        <div class="tabs-content">
            @forelse($laporans as $laporan)
                <div class="report-card {{ $laporan->borderClass }}">
                    
                    <!-- Only show image if it's Menunggu Verifikasi (as per screenshot) -->
                    @if($tab === 'menunggu')
                    <img src="{{ $laporan->foto ? asset('storage/'.$laporan->foto) : 'https://images.unsplash.com/photo-1596484552834-6a58f84fa5ba?q=80&w=300&auto=format&fit=crop' }}" alt="Laporan Foto" class="report-image">
                    @endif

                    <div class="report-content">
                        <div class="report-header">
                            <div class="report-badges">
                                <span class="badge-id">RK-{{ 9900 + $laporan->id }}</span>
                                <span class="badge {{ $laporan->catClass }}">{{ $laporan->catName }}</span>
                                
                                @if($tab === 'menunggu')
                                    <span class="badge {{ $laporan->urgencyClass }}">{{ ucfirst($laporan->urgensi ?? 'Medium') }}</span>
                                @elseif($laporan->borderClass === 'border-terverifikasi')
                                    <span class="badge badge-status terverifikasi">Terverifikasi</span>
                                @elseif($laporan->borderClass === 'border-ditolak')
                                    <span class="badge badge-status ditolak">Ditolak</span>
                                @endif
                            </div>
                            <div class="report-time">{{ $laporan->created_at->diffForHumans() }}</div>
                        </div>

                        <h3 class="report-title">{{ $laporan->judul_laporan }}</h3>
                        
                        @if($tab === 'menunggu')
                        <p class="report-desc">{{ Str::limit($laporan->deskripsi, 150) }}</p>
                        @endif

                        <div class="report-meta">
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $laporan->kecamatan ?? 'Lokasi tidak diketahui' }}
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ $laporan->user->name ?? 'Anonim' }}
                            </div>

                            @if($tab === 'menunggu')
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $laporan->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                {{ $laporan->upvotes }}
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                {{ $laporan->comments }}
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ $laporan->views }}
                            </div>
                            @else
                                <!-- Additional meta for verified/rejected -->
                                <div class="meta-item {{ $laporan->borderClass == 'border-terverifikasi' ? 'text-green-600' : 'text-red-600' }}">
                                    @if($laporan->borderClass == 'border-terverifikasi')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Diverifikasi oleh {{ $laporan->admin->name ?? 'Admin Kota' }}
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Ditolak oleh {{ $laporan->admin->name ?? 'Admin Kota' }}
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if($tab === 'menunggu')
                        <div class="report-actions">
                            <a href="{{ route('verifikasi.show', $laporan->id) }}" class="btn-primary" style="text-decoration:none;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Tinjau & Verifikasi
                            </a>
                            <button class="btn-outline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Bukti
                            </button>
                        </div>
                        @elseif($laporan->borderClass === 'border-terverifikasi')
                        <div class="note-box terverifikasi">
                            <div class="note-box-title">Catatan Verifikasi:</div>
                            <div class="note-box-content">{{ $laporan->catatan_verifikasi ?? 'Laporan valid. Menunggu tindak lanjut dinas terkait.' }}</div>
                            <div class="note-box-date">{{ $laporan->waktu_verifikasi ? $laporan->waktu_verifikasi->format('d M Y, H:i') : $laporan->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                        @elseif($laporan->borderClass === 'border-ditolak')
                        <div class="note-box ditolak">
                            <div class="note-box-title">Alasan Penolakan:</div>
                            <div class="note-box-content">{{ $laporan->alasan_penolakan ?? 'Laporan tidak sesuai dengan kriteria pelaporan.' }}</div>
                            <div class="note-box-date">{{ $laporan->waktu_verifikasi ? $laporan->waktu_verifikasi->format('d M Y, H:i') : $laporan->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                        @endif

                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: #94a3b8;">
                    <svg style="margin: 0 auto 16px; width: 48px; height: 48px; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p>Tidak ada laporan di tab ini.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($laporans->hasPages())
                <div style="margin-top: 24px;">
                    {{ $laporans->appends(['tab' => $tab])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
