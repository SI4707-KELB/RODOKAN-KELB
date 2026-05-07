@extends('layouts.dashboard')

@section('title', 'Tambah Kategori Laporan - RODOKAN')

@section('content')
<style>
.kategori-container {
    padding: 24px 32px;
    font-family: 'Inter', sans-serif;
    color: #1e293b;
    max-width: 800px;
    margin: 0 auto;
}
.card-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #475569; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; transition: border 0.2s; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
textarea.form-control { min-height: 100px; resize: vertical; }
.btn-primary { background: #3b82f6; color: white; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: background 0.2s; }
.btn-primary:hover { background: #2563eb; }
.btn-secondary { background: #f1f5f9; color: #475569; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s; }
.btn-secondary:hover { background: #e2e8f0; }
.form-actions { display: flex; gap: 12px; margin-top: 30px; }
.text-error { color: #ef4444; font-size: 12px; margin-top: 4px; display: block; }
</style>

<div class="kategori-container">
    <div style="margin-bottom: 24px;">
        <h2 style="font-size:24px; font-weight:700;">Tambah Kategori</h2>
        <p style="color:#64748b; font-size:14px; margin-top:4px;">Tambahkan kategori baru untuk pelaporan.</p>
    </div>

    <div class="card-box">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Infrastruktur">
                @error('nama') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Ikon (Opsional)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="Contoh: 🚧 (Emoji) atau nama kelas icon">
                @error('icon') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat mengenai kategori ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <span class="text-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.kategori.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
