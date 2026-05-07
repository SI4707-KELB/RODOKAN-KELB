@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori Laporan - RODOKAN')

@section('content')
<style>
/* Kategori Styles */
.kategori-container {
    padding: 24px 32px;
    font-family: 'Inter', sans-serif;
    color: #1e293b;
    max-width: 1400px;
    margin: 0 auto;
}
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.header-title {
    font-size: 24px;
    font-weight: 700;
}
.header-subtitle {
    font-size: 14px;
    color: #64748b;
    margin-top: 4px;
}
.btn-primary {
    background: #3b82f6;
    color: white;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s;
}
.btn-primary:hover {
    background: #2563eb;
}
.card-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.data-table { width: 100%; border-collapse: collapse; }
.data-table th { text-align: left; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; }
.data-table td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
.action-buttons { display: flex; gap: 8px; }
.btn-icon {
    width: 32px; height: 32px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center;
    transition: background 0.2s; border: none; cursor: pointer;
}
.btn-edit { background: #eff6ff; color: #3b82f6; }
.btn-edit:hover { background: #dbeafe; }
.btn-delete { background: #fef2f2; color: #ef4444; }
.btn-delete:hover { background: #fee2e2; }
.alert-success {
    background: #dcfce7; color: #16a34a; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; border: 1px solid #bbf7d0;
}
.alert-error {
    background: #fee2e2; color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px; border: 1px solid #fecaca;
}
</style>

<div class="kategori-container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div>
            <div class="header-title">Kategori Laporan</div>
            <div class="header-subtitle">Kelola kategori untuk klasifikasi laporan masyarakat.</div>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="card-box">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                <tr>
                    <td style="color: #64748b; font-weight:500;">#{{ $kategori->id }}</td>
                    <td style="font-weight:600; color:#1e293b;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            @if($kategori->icon)
                                <span style="font-size:18px;">{{ $kategori->icon }}</span>
                            @endif
                            {{ $kategori->nama }}
                        </div>
                    </td>
                    <td style="color:#475569;">{{ Str::limit($kategori->deskripsi, 80) ?? '-' }}</td>
                    <td style="text-align:right;">
                        <div class="action-buttons" style="justify-content: flex-end;">
                            <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn-icon btn-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Hapus">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding: 40px; color:#64748b;">Belum ada kategori laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $kategoris->links() ?? '' }}
        </div>
    </div>
</div>
@endsection
