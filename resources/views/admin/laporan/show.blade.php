@extends('layouts.dashboard')

@section('title', 'Detail Laporan - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3">Detail Laporan</h1>
                    <p class="text-muted">ID: #{{ $laporan->id }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Laporan Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ $laporan->judul_laporan }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge badge-status-{{ strtolower(str_replace(' ', '-', $laporan->status)) }} p-2">
                                    {{ $laporan->status }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Urgensi:</strong><br>
                                <span class="badge badge-urgensi-{{ strtolower($laporan->urgensi) }} p-2">
                                    {{ $laporan->urgensi }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Kategori:</strong><br>
                                {{ $laporan->kategori->nama ?? '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Kecamatan:</strong><br>
                                {{ $laporan->kecamatan }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <strong>Deskripsi:</strong>
                        <p class="mt-2">{{ $laporan->deskripsi }}</p>
                    </div>

                    @if($laporan->foto)
                        <div class="mb-4">
                            <strong>Foto Laporan:</strong>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan" class="img-fluid rounded" style="max-width: 100%; max-height: 400px;">
                            </div>
                        </div>
                    @endif

                    @if($laporan->latitude && $laporan->longitude)
                        <div class="mb-4">
                            <strong>Lokasi:</strong>
                            <p class="mt-2">
                                Latitude: {{ $laporan->latitude }}<br>
                                Longitude: {{ $laporan->longitude }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Catatan & Verifikasi Card -->
            @if($laporan->catatan_verifikasi || $laporan->alasan_penolakan)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Catatan Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        @if($laporan->catatan_verifikasi)
                            <div class="mb-3">
                                <strong>Catatan:</strong>
                                <p class="mt-2">{{ $laporan->catatan_verifikasi }}</p>
                            </div>
                        @endif

                        @if($laporan->alasan_penolakan)
                            <div>
                                <strong>Alasan Penolakan:</strong>
                                <p class="mt-2 text-danger">{{ $laporan->alasan_penolakan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Pelapor Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Informasi Pelapor</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">
                        <strong>Nama:</strong><br>
                        {{ $laporan->user->name ?? 'Anonim' }}
                    </p>
                    <p class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $laporan->user->email ?? '-' }}
                    </p>
                    <p class="mb-3">
                        <strong>No. Telepon:</strong><br>
                        {{ $laporan->user->phone_number ?? '-' }}
                    </p>
                    <p class="mb-0">
                        <strong>Kota:</strong><br>
                        {{ $laporan->user->city ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Admin Card -->
            @if($laporan->admin)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Admin Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            <strong>Nama:</strong><br>
                            {{ $laporan->admin->name }}
                        </p>
                        <p class="mb-0">
                            <strong>Waktu Verifikasi:</strong><br>
                            {{ $laporan->waktu_verifikasi ? $laporan->waktu_verifikasi->format('d/m/Y H:i') : '-' }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Timeline Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker">
                                <i class="bi bi-plus-circle text-primary"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="mb-1"><strong>Laporan Dibuat</strong></p>
                                <small class="text-muted">{{ $laporan->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        @if($laporan->waktu_verifikasi)
                            <div class="timeline-item">
                                <div class="timeline-marker">
                                    <i class="bi bi-check-circle" style="color: {{ $laporan->status === 'Ditolak' ? 'red' : 'green' }};"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-1"><strong>{{ $laporan->status === 'Ditolak' ? 'Laporan Ditolak' : 'Laporan Diverifikasi' }}</strong></p>
                                    <small class="text-muted">{{ $laporan->waktu_verifikasi->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif

                        @if($laporan->updated_at && $laporan->updated_at != $laporan->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker">
                                    <i class="bi bi-pencil-square text-warning"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-1"><strong>Status Diubah</strong></p>
                                    <small class="text-muted">{{ $laporan->updated_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge-status-menunggu { background-color: #ffc107; color: #000; }
    .badge-status-terverifikasi { background-color: #17a2b8; color: #fff; }
    .badge-status-diproses { background-color: #007bff; color: #fff; }
    .badge-status-ditindaklanjuti { background-color: #28a745; color: #fff; }
    .badge-status-selesai { background-color: #6c757d; color: #fff; }
    .badge-status-ditolak { background-color: #dc3545; color: #fff; }

    .badge-urgensi-rendah { background-color: #28a745; }
    .badge-urgensi-sedang { background-color: #ffc107; color: #000; }
    .badge-urgensi-tinggi { background-color: #fd7e14; }
    .badge-urgensi-darurat { background-color: #dc3545; }

    .timeline {
        position: relative;
        padding-left: 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 40px;
        width: 2px;
        height: 20px;
        background-color: #dee2e6;
    }

    .timeline-marker {
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .timeline-content {
        flex: 1;
        margin-left: 15px;
        margin-top: 5px;
    }
</style>
@endsection
