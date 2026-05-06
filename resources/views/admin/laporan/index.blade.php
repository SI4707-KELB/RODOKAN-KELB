@extends('layouts.dashboard')

@section('title', 'Manajemen Data Laporan - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">Manajemen Data Laporan</h1>
                <a href="{{ route('admin.laporan.export', request()->query()) }}" class="btn btn-info">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Total Laporan</small>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-file-text text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Menunggu</small>
                            <h4 class="mb-0 text-warning">{{ $stats['menunggu'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Diproses</small>
                            <h4 class="mb-0 text-info">{{ $stats['diproses'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-hourglass-split text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Ditindaklanjuti</small>
                            <h4 class="mb-0 text-primary">{{ $stats['ditindaklanjuti'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-play-circle text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Selesai</small>
                            <h4 class="mb-0 text-success">{{ $stats['selesai'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <small class="text-muted d-block">Ditolak</small>
                            <h4 class="mb-0 text-danger">{{ $stats['ditolak'] }}</h4>
                        </div>
                        <div class="ms-auto">
                            <i class="bi bi-x-circle text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-lg-2 col-md-6">
                    <label for="search" class="form-label">Cari</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Judul atau pelapor" value="{{ request('search') }}">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="semua">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select class="form-select" id="kecamatan" name="kecamatan">
                        <option value="">Semua Kecamatan</option>
                        @foreach($kecamatan as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') === $kec ? 'selected' : '' }}>
                                {{ $kec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="urgensi" class="form-label">Urgensi</label>
                    <select class="form-select" id="urgensi" name="urgensi">
                        <option value="">Semua Urgensi</option>
                        @foreach($urgencies as $urg)
                            <option value="{{ $urg }}" {{ request('urgensi') === $urg ? 'selected' : '' }}>
                                {{ $urg }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="d-flex gap-2 align-items-end h-100">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>
                            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['sort_by' => 'judul_laporan', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none">
                                Judul Laporan
                                @if(request('sort_by') === 'judul_laporan')
                                    <i class="bi bi-arrow-{{ request('sort_order') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>
                            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none">
                                Status
                                @if(request('sort_by') === 'status')
                                    <i class="bi bi-arrow-{{ request('sort_order') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Urgensi</th>
                        <th>
                            <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc'])) }}" class="text-decoration-none">
                                Tanggal
                                @if(request('sort_by') === 'created_at')
                                    <i class="bi bi-arrow-{{ request('sort_order') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $laporan)
                        <tr>
                            <td>{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="text-decoration-none">
                                    {{ Str::limit($laporan->judul_laporan, 50) }}
                                </a>
                            </td>
                            <td>{{ $laporan->user->name ?? 'Anonim' }}</td>
                            <td>{{ $laporan->kategori->nama ?? '-' }}</td>
                            <td>
                                <span class="badge badge-status-{{ strtolower(str_replace(' ', '-', $laporan->status)) }}">
                                    {{ $laporan->status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-urgensi-{{ strtolower($laporan->urgensi) }}">
                                    {{ $laporan->urgensi }}
                                </span>
                            </td>
                            <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $laporan->id }}" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $laporan->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus laporan "<strong>{{ $laporan->judul_laporan }}</strong>"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Tidak ada laporan yang sesuai dengan filter
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white">
            {{ $laporans->links() }}
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
