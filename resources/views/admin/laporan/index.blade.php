@extends('layouts.dashboard')

@section('title', 'Manajemen Data Laporan - Admin Dashboard')

@section('content')
@php
    $statCards = [
        ['label' => 'Total Laporan', 'value' => $stats['total'] ?? 0, 'color' => 'blue', 'icon' => 'document'],
        ['label' => 'Menunggu', 'value' => $stats['menunggu'] ?? 0, 'color' => 'amber', 'icon' => 'clock'],
        ['label' => 'Diproses', 'value' => $stats['diproses'] ?? 0, 'color' => 'sky', 'icon' => 'bolt'],
        ['label' => 'Ditindaklanjuti', 'value' => $stats['ditindaklanjuti'] ?? 0, 'color' => 'indigo', 'icon' => 'briefcase'],
        ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'color' => 'emerald', 'icon' => 'check'],
        ['label' => 'Ditolak', 'value' => $stats['ditolak'] ?? 0, 'color' => 'rose', 'icon' => 'x'],
    ];

    $statusBadge = fn ($status) => match($status) {
        'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
        'Terverifikasi' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
        'Diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
        'Ditindaklanjuti' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'Ditolak' => 'bg-rose-50 text-rose-700 border-rose-200',
        'Darurat' => 'bg-red-50 text-red-700 border-red-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
    };

    $urgencyBadge = fn ($urgensi) => match(strtolower($urgensi ?? '')) {
        'tinggi', 'darurat' => 'bg-red-50 text-red-700 border-red-200',
        'sedang' => 'bg-amber-50 text-amber-700 border-amber-200',
        'rendah' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        default => 'bg-slate-50 text-slate-700 border-slate-200',
    };

    $sortLink = fn ($column) => route('admin.laporan.index', array_merge(request()->query(), [
        'sort_by' => $column,
        'sort_order' => request('sort_by') === $column && request('sort_order') === 'asc' ? 'desc' : 'asc',
    ]));
@endphp

<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Manajemen Data Laporan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola, filter, tinjau, dan ekspor data laporan masyarakat.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.laporan.export.excel', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-sm transition-colors hover:bg-emerald-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0118 8.414V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
            <a href="{{ route('admin.laporan.export.pdf', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-xs font-bold text-white shadow-sm transition-colors hover:bg-red-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0010.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.laporan.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-700 shadow-sm transition-colors hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
            </a>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        @foreach($statCards as $card)
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wide text-slate-500">{{ $card['label'] }}</div>
                        <div class="mt-2 text-2xl font-extrabold text-slate-900">{{ $card['value'] }}</div>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl
                        {{ $card['color'] === 'blue' ? 'bg-blue-50 text-blue-600' : '' }}
                        {{ $card['color'] === 'amber' ? 'bg-amber-50 text-amber-600' : '' }}
                        {{ $card['color'] === 'sky' ? 'bg-sky-50 text-sky-600' : '' }}
                        {{ $card['color'] === 'indigo' ? 'bg-indigo-50 text-indigo-600' : '' }}
                        {{ $card['color'] === 'emerald' ? 'bg-emerald-50 text-emerald-600' : '' }}
                        {{ $card['color'] === 'rose' ? 'bg-rose-50 text-rose-600' : '' }}">
                        @if($card['icon'] === 'document')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0118 8.414V19a2 2 0 01-2 2z"/></svg>
                        @elseif($card['icon'] === 'clock')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($card['icon'] === 'bolt')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        @elseif($card['icon'] === 'briefcase')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif($card['icon'] === 'check')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">
            <div class="xl:col-span-2">
                <label for="search" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Cari</label>
                <input type="text" id="search" name="search" placeholder="Judul atau pelapor" value="{{ request('search') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label for="status" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Status</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="semua">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kategori" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Kategori</label>
                <select id="kategori" name="kategori" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" @selected(request('kategori') == $kat->id)>{{ $kat->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="kecamatan" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Kecamatan</label>
                <select id="kecamatan" name="kecamatan" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatan as $kec)
                        <option value="{{ $kec }}" @selected(request('kecamatan') === $kec)>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="urgensi" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Urgensi</label>
                <select id="urgensi" name="urgensi" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                    <option value="">Semua Urgensi</option>
                    @foreach($urgencies as $urg)
                        <option value="{{ $urg }}" @selected(request('urgensi') === $urg)>{{ $urg }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tanggal_dari" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Dari Tanggal</label>
                <input type="date" id="tanggal_dari" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <div>
                <label for="tanggal_sampai" class="mb-2 block text-xs font-bold uppercase tracking-wide text-slate-500">Sampai Tanggal</label>
                <input type="date" id="tanggal_sampai" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            </div>

            <div class="flex items-end gap-2 xl:col-span-2">
                <button type="submit" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition-colors hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition-colors hover:bg-slate-50" title="Reset filter">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6M20 8A8 8 0 006.343 5.657L4 8m16 8a8 8 0 01-13.657 2.343L4 16"/></svg>
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Daftar Laporan</h2>
                <p class="text-xs text-slate-500">Menampilkan data laporan sesuai filter aktif.</p>
            </div>
            <div class="text-xs font-semibold text-slate-500">
                Total data: {{ $laporans->total() }}
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[980px] text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50 text-[11px] uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-bold">No</th>
                        <th class="px-5 py-3 font-bold">
                            <a href="{{ $sortLink('judul_laporan') }}" class="inline-flex items-center gap-1 hover:text-blue-600">
                                Judul Laporan
                                @if(request('sort_by') === 'judul_laporan')
                                    <span>{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-5 py-3 font-bold">Pelapor</th>
                        <th class="px-5 py-3 font-bold">Kategori</th>
                        <th class="px-5 py-3 font-bold">
                            <a href="{{ $sortLink('status') }}" class="inline-flex items-center gap-1 hover:text-blue-600">
                                Status
                                @if(request('sort_by') === 'status')
                                    <span>{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-5 py-3 font-bold">Urgensi</th>
                        <th class="px-5 py-3 font-bold">
                            <a href="{{ $sortLink('created_at') }}" class="inline-flex items-center gap-1 hover:text-blue-600">
                                Tanggal
                                @if(request('sort_by') === 'created_at')
                                    <span>{{ request('sort_order') === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </a>
                        </th>
                        <th class="px-5 py-3 text-right font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporans as $laporan)
                        <tr class="transition-colors hover:bg-slate-50/70">
                            <td class="px-5 py-4 text-xs font-semibold text-slate-500">{{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="block max-w-xs truncate font-bold text-slate-900 hover:text-blue-600" title="{{ $laporan->judul_laporan }}">
                                    {{ \Illuminate\Support\Str::limit($laporan->judul_laporan, 58) }}
                                </a>
                                <div class="mt-1 text-xs font-semibold text-slate-400">RK-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-700">{{ $laporan->user->name ?? 'Anonim' }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] font-bold text-slate-700">{{ $laporan->kategori->nama ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[11px] font-bold {{ $statusBadge($laporan->status) }}">{{ $laporan->status }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-[11px] font-bold {{ $urgencyBadge($laporan->urgensi) }}">{{ $laporan->urgensi ?? '-' }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs font-semibold text-slate-600">{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition-colors hover:bg-blue-100" title="Lihat Detail">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition-colors hover:bg-amber-100" title="Edit">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ' + @js($laporan->judul_laporan) + '?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-rose-50 text-rose-600 transition-colors hover:bg-rose-100" title="Hapus">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M5 7h14M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                                </div>
                                <p class="mt-3 text-sm font-semibold text-slate-500">Tidak ada laporan yang sesuai dengan filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 bg-white px-5 py-4">
            {{ $laporans->links() }}
        </div>
    </div>
</div>
@endsection
