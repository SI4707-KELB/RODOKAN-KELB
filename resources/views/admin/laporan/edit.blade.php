@extends('layouts.dashboard')

@section('title', 'Edit Laporan - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Edit Laporan</h1>
                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">{{ $laporan->judul_laporan }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <strong>Status Laporan</strong>
                            </label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $laporan->status === $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Admin Verifikasi -->
                        <div class="mb-4">
                            <label for="admin_id" class="form-label">
                                <strong>Admin Verifikasi</strong>
                            </label>
                            <select class="form-select" id="admin_id" name="admin_id">
                                <option value="">-- Pilih Admin --</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $laporan->admin_id === $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('admin_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Catatan Verifikasi -->
                        <div class="mb-4">
                            <label for="catatan_verifikasi" class="form-label">
                                <strong>Catatan Verifikasi</strong>
                                <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea class="form-control" id="catatan_verifikasi" name="catatan_verifikasi" rows="4" placeholder="Masukkan catatan verifikasi...">{{ $laporan->catatan_verifikasi }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                            @error('catatan_verifikasi')
                                <span class="text-danger small d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Alasan Penolakan -->
                        <div class="mb-4">
                            <label for="alasan_penolakan" class="form-label">
                                <strong>Alasan Penolakan</strong>
                                <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="4" placeholder="Masukkan alasan penolakan jika laporan ditolak...">{{ $laporan->alasan_penolakan }}</textarea>
                            <small class="text-muted">Maksimal 500 karakter</small>
                            @error('alasan_penolakan')
                                <span class="text-danger small d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-secondary">
                                <i class="bi bi-x"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Informasi Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Status Saat Ini</small>
                        <p class="mb-0">
                            <span class="badge badge-status-{{ strtolower(str_replace(' ', '-', $laporan->status)) }} p-2">
                                {{ $laporan->status }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Urgensi</small>
                        <p class="mb-0">
                            <span class="badge badge-urgensi-{{ strtolower($laporan->urgensi) }} p-2">
                                {{ $laporan->urgensi }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Kategori</small>
                        <p class="mb-0">{{ $laporan->kategori->nama ?? '-' }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Kecamatan</small>
                        <p class="mb-0">{{ $laporan->kecamatan }}</p>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Tanggal Dibuat</small>
                        <p class="mb-0">{{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-0">
                        <small class="text-muted">Pelapor</small>
                        <p class="mb-0">{{ $laporan->user->name ?? 'Anonim' }}</p>
                    </div>
                </div>
            </div>

            <!-- Preview Deskripsi -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Deskripsi Laporan</h5>
                </div>
                <div class="card-body">
                    <p>{{ $laporan->deskripsi }}</p>
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
</style>
@endsection
