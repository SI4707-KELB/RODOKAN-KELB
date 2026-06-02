@extends('layouts.dashboard')

@section('title', 'Edit Laporan - Admin Dashboard')

@section('content')
@php
    $statusBadge = match($laporan->status) {
        'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
        'Terverifikasi' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
        'Diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
        'Ditindaklanjuti' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
    };

    $urgencyBadge = match(strtolower($laporan->urgensi ?? '')) {
        'tinggi', 'darurat' => 'bg-red-50 text-red-700 border-red-200',
        'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
        'rendah' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
    };
@endphp

<div class="p-6 md:p-8 max-w-[1200px] mx-auto w-full">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-semibold text-slate-500">
                <a href="{{ route('admin.laporan.index') }}" class="hover:text-blue-600">Manajemen Laporan</a>
                <span>/</span>
                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="hover:text-blue-600">Detail</a>
                <span>/</span>
                <span>Edit</span>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Edit Laporan</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui status, admin verifikasi, dan catatan penanganan laporan.</p>
        </div>

        <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm transition-colors hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
            <div class="font-extrabold">Terjadi kesalahan</div>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="text-xs font-bold uppercase tracking-wide text-slate-400">RK-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</div>
                <h2 class="mt-1 break-words text-xl font-extrabold text-slate-900">{{ $laporan->judul_laporan }}</h2>
            </div>

            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="status" class="mb-2 block text-sm font-bold text-slate-700">Status Laporan</label>
                        <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                            <option value="">Pilih Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" @selected(old('status', $laporan->status) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="admin_id" class="mb-2 block text-sm font-bold text-slate-700">Admin Verifikasi</label>
                        <select id="admin_id" name="admin_id" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                            <option value="">Pilih Admin</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" @selected((int) old('admin_id', $laporan->admin_id) === $admin->id)>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                        @error('admin_id')
                            <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="instansi_id" class="mb-2 block text-sm font-bold text-slate-700">Instansi Tujuan</label>
                        <select id="instansi_id" name="instansi_id" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                            <option value="">Pilih Instansi</option>
                            @foreach($instansis as $instansi)
                                <option value="{{ $instansi->id }}" @selected((int) old('instansi_id', $laporan->instansi_id) === $instansi->id)>{{ $instansi->nama }}</option>
                            @endforeach
                        </select>
                        @error('instansi_id')
                            <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="catatan_verifikasi" class="block text-sm font-bold text-slate-700">Catatan Verifikasi <span class="font-semibold text-slate-400">(Opsional)</span></label>
                        <span class="text-xs font-semibold text-slate-400">Maksimal 500 karakter</span>
                    </div>
                    <textarea id="catatan_verifikasi" name="catatan_verifikasi" rows="5" maxlength="500" placeholder="Masukkan catatan verifikasi..." class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">{{ old('catatan_verifikasi', $laporan->catatan_verifikasi) }}</textarea>
                    @error('catatan_verifikasi')
                        <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between gap-3">
                        <label for="alasan_penolakan" class="block text-sm font-bold text-slate-700">Alasan Penolakan <span class="font-semibold text-slate-400">(Opsional)</span></label>
                        <span class="text-xs font-semibold text-slate-400">Maksimal 500 karakter</span>
                    </div>
                    <textarea id="alasan_penolakan" name="alasan_penolakan" rows="5" maxlength="500" placeholder="Masukkan alasan penolakan jika laporan ditolak..." class="w-full resize-none rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition focus:border-rose-400 focus:ring-4 focus:ring-rose-100">{{ old('alasan_penolakan', $laporan->alasan_penolakan) }}</textarea>
                    @error('alasan_penolakan')
                        <p class="mt-1 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition-colors hover:bg-slate-50">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-blue-600/20 transition-colors hover:bg-blue-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-base font-extrabold text-slate-900">Informasi Laporan</h3>
                </div>
                <div class="space-y-5 p-6">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Status Saat Ini</div>
                        <span class="mt-2 inline-flex rounded-full border px-3 py-1 text-xs font-bold {{ $statusBadge }}">{{ $laporan->status }}</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Urgensi</div>
                        <span class="mt-2 inline-flex rounded-full border px-3 py-1 text-xs font-bold {{ $urgencyBadge }}">{{ $laporan->urgensi ?? '-' }}</span>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Kategori</div>
                        <div class="mt-1 font-semibold text-slate-800">{{ $laporan->kategori->nama ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Kecamatan</div>
                        <div class="mt-1 font-semibold text-slate-800">{{ $laporan->kecamatan ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Tanggal Dibuat</div>
                        <div class="mt-1 font-semibold text-slate-800">{{ $laporan->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wide text-slate-400">Pelapor</div>
                        <div class="mt-1 break-words font-semibold text-slate-800">{{ $laporan->user->name ?? 'Anonim' }}</div>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-base font-extrabold text-slate-900">Deskripsi Laporan</h3>
                </div>
                <div class="p-6">
                    <p class="break-words text-sm leading-7 text-slate-600">{{ $laporan->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection
