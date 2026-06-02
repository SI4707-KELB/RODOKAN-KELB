@extends('layouts.dashboard')

@section('title', 'Detail Laporan - Admin Dashboard')

@section('content')
@php
    $statusClass = match($laporan->status) {
        'Menunggu' => 'bg-amber-100 text-amber-700',
        'Terverifikasi' => 'bg-blue-100 text-blue-700',
        'Diproses' => 'bg-sky-100 text-sky-700',
        'Ditindaklanjuti' => 'bg-indigo-100 text-indigo-700',
        'Selesai' => 'bg-emerald-100 text-emerald-700',
        'Ditolak' => 'bg-rose-100 text-rose-700',
        'Darurat' => 'bg-red-100 text-red-700',
        default => 'bg-slate-100 text-slate-700',
    };

    $urgensiClass = match(strtolower($laporan->urgensi ?? '')) {
        'tinggi', 'darurat' => 'bg-red-100 text-red-700',
        'sedang' => 'bg-amber-100 text-amber-700',
        default => 'bg-emerald-100 text-emerald-700',
    };

    $kategoriClass = 'bg-orange-100 text-orange-700';

    $evidenceItems = collect();
    if (isset($laporan->evidenceLayers) && $laporan->evidenceLayers->count()) {
        $evidenceItems = $laporan->evidenceLayers->map(fn ($evidence) => $evidence->path ?? $evidence->file ?? null)->filter()->values();
    } elseif (isset($laporan->evidences) && $laporan->evidences->count()) {
        $evidenceItems = $laporan->evidences->map(fn ($evidence) => $evidence->path ?? $evidence->file ?? null)->filter()->values();
    } elseif (!empty($laporan->foto)) {
        $evidenceItems = collect([$laporan->foto]);
    }

    $komentars = $laporan->komentars ?? collect();
    $upvotesCount = method_exists($laporan, 'upvotes') ? $laporan->upvotes()->count() : 0;
    $commentsCount = $komentars->count();
    $viewsCount = $laporan->views ?? 0;
    $sharesCount = $laporan->shares ?? 0;
    $hasEvidence = $evidenceItems->isNotEmpty();
    $hasLocation = $laporan->latitude && $laporan->longitude;

    $mapReports = $hasLocation ? collect([[
        'lat' => (float) $laporan->latitude,
        'lng' => (float) $laporan->longitude,
        'title' => $laporan->judul_laporan,
        'category' => $laporan->kategori->nama ?? 'Laporan',
        'status' => $laporan->status,
        'urgency' => $laporan->urgensi,
        'district' => $laporan->kecamatan ?? $laporan->alamat ?? '-',
    ]]) : collect();

    $checkItems = [
        ['label' => 'Deskripsi laporan jelas dan lengkap', 'done' => !empty($laporan->deskripsi)],
        ['label' => 'Foto bukti tersedia', 'done' => $hasEvidence],
        ['label' => 'Lokasi GPS tersedia', 'done' => $hasLocation],
        ['label' => 'Lokasi berada di Kota Bandung', 'done' => !empty($laporan->kecamatan)],
        ['label' => 'Kategori sesuai', 'done' => !empty($laporan->kategori)],
        ['label' => 'Tidak ada duplikasi laporan', 'done' => true],
        ['label' => 'Bukti foto relevan dengan laporan', 'done' => $hasEvidence],
        ['label' => 'Tingkat urgensi sesuai kondisi', 'done' => !empty($laporan->urgensi)],
    ];
    $verifiedCount = collect($checkItems)->where('done', true)->count();
@endphp

<div class="min-h-full bg-gradient-to-br from-slate-50 via-blue-50/50 to-blue-100/50">
    <div class="mx-auto w-full max-w-[1120px] px-5 py-8 md:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Detail Verifikasi Laporan</h1>
            <p class="mt-2 text-base font-medium text-slate-500">Tinjau dan verifikasi laporan dari masyarakat</p>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,660px)_320px]">
            <main class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <h2 class="max-w-md break-words text-2xl font-extrabold leading-tight text-slate-800">{{ $laporan->judul_laporan }}</h2>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $kategoriClass }}">{{ $laporan->kategori->nama ?? '-' }}</span>
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $urgensiClass }}">Urgensi: {{ $laporan->urgensi ?? '-' }}</span>
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">{{ $laporan->status }}</span>
                            </div>
                        </div>
                        <div class="shrink-0 text-3xl font-extrabold text-blue-600">RK-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>

                    <div class="mt-5 border-t border-slate-100 pt-5">
                        <div class="grid gap-4 text-sm text-slate-500 sm:grid-cols-2">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Pelapor: <b class="font-bold text-slate-700">{{ $laporan->user->name ?? 'Anonim' }}</b></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/></svg>
                                <span>Waktu: <b class="font-bold text-slate-700">{{ $laporan->created_at->format('d M Y, H:i') }}</b></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Kecamatan: <b class="font-bold text-slate-700">{{ $laporan->kecamatan ?? '-' }}</b></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4-.8L3 20l.8-3.2A7.5 7.5 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <span>Interaksi: <b class="font-bold text-slate-700">{{ $upvotesCount }} upvotes, {{ $commentsCount }} komentar</b></span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Deskripsi Laporan</h3>
                    <p class="mt-4 break-words text-base leading-8 text-slate-600">{{ $laporan->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h3 class="text-lg font-extrabold text-slate-800">Bukti Foto Kejadian</h3>
                        <span class="text-sm font-semibold text-slate-400">({{ $evidenceItems->count() }} foto)</span>
                    </div>

                    @if($hasEvidence)
                        <div class="grid gap-4 {{ $evidenceItems->count() > 1 ? 'sm:grid-cols-2' : '' }}">
                            @foreach($evidenceItems as $path)
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="group block overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                    <img src="{{ asset('storage/' . $path) }}" alt="Bukti laporan {{ $loop->iteration }}" class="h-80 w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="flex h-48 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-sm font-semibold text-slate-400">Belum ada bukti foto</div>
                    @endif
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Lokasi Kejadian</h3>
                    <div class="mt-5">
                        @if($hasLocation)
                            <div
                                id="laporan-map"
                                class="h-80 w-full overflow-hidden rounded-xl border border-slate-200 bg-slate-100"
                                data-reports="{{ $mapReports->toJson(JSON_HEX_APOS | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT) }}"
                            ></div>
                            <div class="mt-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm leading-6 text-blue-700">
                                <b>Alamat Lengkap:</b> {{ $laporan->alamat ?? ($laporan->kecamatan ?? '-') }}
                            </div>
                        @else
                            <div class="flex h-56 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 text-sm font-semibold text-slate-400">Koordinat lokasi belum tersedia</div>
                        @endif
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4-.8L3 20l.8-3.2A7.5 7.5 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <h3 class="text-lg font-extrabold text-slate-800">Tanggapan & Diskusi</h3>
                        <span class="text-sm font-semibold text-slate-400">({{ $commentsCount }} komentar)</span>
                    </div>

                    <form action="{{ route('komentar.store', $laporan->id) }}" method="POST" class="mb-6 flex gap-4">
                        @csrf
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-600 text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="flex-1">
                            <textarea name="komentar" required rows="4" class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100" placeholder="Tulis tanggapan Anda..."></textarea>
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-blue-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Kirim Tanggapan
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="space-y-4">
                        @forelse($komentars as $komentar)
                            @php $isAdminComment = ($komentar->user->role ?? null) === 'admin'; @endphp
                            <div class="flex gap-4 rounded-xl {{ $isAdminComment ? 'border border-blue-200 bg-blue-50' : 'bg-slate-50' }} p-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $isAdminComment ? 'bg-blue-600' : 'bg-slate-400' }} text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-extrabold text-slate-800">{{ $komentar->user->name ?? 'Pengguna' }}</span>
                                        @if($isAdminComment)
                                            <span class="rounded bg-blue-600 px-2 py-0.5 text-[10px] font-bold uppercase text-white">Admin</span>
                                        @endif
                                        <span class="text-xs font-semibold text-slate-400">{{ $komentar->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-1 break-words text-sm leading-6 text-slate-600">{{ $komentar->isi_komentar }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-xl bg-slate-50 px-4 py-8 text-center text-sm font-semibold text-slate-400">Belum ada komentar atau tanggapan.</div>
                        @endforelse
                    </div>
                </section>
            </main>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Checklist Verifikasi</h3>
                    <div class="mt-6 space-y-5">
                        @foreach($checkItems as $item)
                            <label class="flex items-start gap-3 text-sm font-semibold leading-5 text-slate-600">
                                <input type="checkbox" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600" @checked($item['done']) disabled>
                                <span>{{ $item['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-6 border-t border-slate-100 pt-4 text-sm text-slate-500">
                        <b class="text-slate-800">{{ $verifiedCount }}/{{ count($checkItems) }}</b> item terverifikasi
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Tindak Lanjut</h3>

                    @php
                        $currentStep = match($laporan->status) {
                            'Menunggu' => 1,
                            'Terverifikasi' => 2,
                            'Ditindaklanjuti' => 3,
                            'Diproses' => 4,
                            'Selesai' => 5,
                            'Ditolak' => -1,
                            default => 0,
                        };
                    @endphp

                    @if($currentStep === -1)
                        <div class="mt-5 rounded-xl bg-rose-50 border border-rose-200 px-5 py-4 text-sm">
                            <span class="font-bold text-rose-700">Laporan ditolak.</span>
                            @if($laporan->alasan_penolakan)
                                <p class="text-rose-600 mt-1">{{ $laporan->alasan_penolakan }}</p>
                            @endif
                        </div>
                    @elseif($currentStep === 5)
                        <div class="mt-5 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-sm">
                            <span class="font-bold text-emerald-700">Laporan selesai diproses.</span>
                        </div>
                    @else
                        @if($currentStep === 1)
                            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-600">Catatan Verifikasi</label>
                                    <textarea name="catatan_verifikasi" rows="3" class="w-full resize-none rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100" placeholder="Tulis catatan verifikasi...">{{ old('catatan_verifikasi') }}</textarea>
                                </div>

                                <div class="grid gap-3">
                                    <button type="submit" name="status" value="Terverifikasi" class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-extrabold text-white shadow-sm hover:bg-green-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Setujui & Lanjutkan
                                    </button>
                                    <button type="submit" name="status" value="Ditolak" class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-extrabold text-white shadow-sm hover:bg-red-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Tolak Laporan
                                    </button>
                                </div>
                            </form>
                        @elseif($currentStep === 2)
                            <form action="{{ route('admin.laporan.forward', $laporan->id) }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-600">Pilih Instansi Tujuan</label>
                                    <select name="instansi_id" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100">
                                        <option value="">-- Pilih Instansi --</option>
                                        @foreach($instansis as $instansi)
                                            <option value="{{ $instansi->id }}" @selected(($laporan->instansi_id ?? 0) === $instansi->id)>{{ $instansi->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-600">Catatan untuk Instansi</label>
                                    <textarea name="catatan" rows="3" class="w-full resize-none rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100" placeholder="Tulis catatan untuk instansi terkait...">{{ old('catatan') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-extrabold text-white shadow-sm hover:bg-indigo-700 w-full">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    Teruskan ke Instansi
                                </button>
                            </form>
                        @elseif($currentStep === 3)
                            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Diproses">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-600">Catatan Proses</label>
                                    <textarea name="catatan_verifikasi" rows="3" class="w-full resize-none rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-sky-400 focus:ring-4 focus:ring-sky-100" placeholder="Tulis catatan penanganan...">{{ old('catatan_verifikasi') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-4 py-3 text-sm font-extrabold text-white shadow-sm hover:bg-sky-700 w-full">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Proses Laporan
                                </button>
                            </form>
                        @elseif($currentStep === 4)
                            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" class="mt-5 space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Selesai">
                                <div>
                                    <label class="mb-2 block text-sm font-bold text-slate-600">Catatan Penyelesaian</label>
                                    <textarea name="catatan_verifikasi" rows="3" class="w-full resize-none rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100" placeholder="Tulis catatan penyelesaian...">{{ old('catatan_verifikasi') }}</textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-extrabold text-white shadow-sm hover:bg-emerald-700 w-full">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Selesaikan Laporan
                                </button>
                            </form>
                        @endif

                        @if($laporan->instansi)
                            <div class="mt-5 rounded-xl bg-indigo-50 border border-indigo-100 px-4 py-3 text-sm">
                                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Instansi Terkait</span>
                                <p class="font-bold text-slate-800 mt-1">{{ $laporan->instansi->nama }}</p>
                            </div>
                        @endif
                    @endif
                </section>

                <section class="rounded-2xl border border-blue-200 bg-blue-100/70 p-6 shadow-sm">
                    <h3 class="text-base font-extrabold text-slate-800">Informasi Cepat</h3>
                    <dl class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between gap-4"><dt class="text-slate-600">Upvotes:</dt><dd class="font-extrabold text-slate-800">{{ $upvotesCount }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-600">Komentar:</dt><dd class="font-extrabold text-slate-800">{{ $commentsCount }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-600">Views:</dt><dd class="font-extrabold text-slate-800">{{ $viewsCount }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-slate-600">Shares:</dt><dd class="font-extrabold text-slate-800">{{ $sharesCount }}</dd></div>
                    </dl>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-800">Status Penanganan</h3>
                    <div class="mt-6 space-y-0">
                        @foreach([
                            ['label' => 'Laporan Diterima', 'desc' => 'Laporan telah masuk ke sistem RODOKAN', 'date' => $laporan->created_at?->format('d M Y, H:i') . ' WIB', 'done' => true, 'color' => 'green'],
                            ['label' => 'Menunggu Verifikasi', 'desc' => 'Laporan diverifikasi oleh admin', 'date' => $laporan->waktu_verifikasi?->format('d M Y, H:i') . ' WIB', 'done' => in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai']), 'color' => 'amber'],
                            ['label' => 'Diteruskan ke Instansi', 'desc' => ($laporan->status === 'Ditindaklanjuti' || $laporan->status === 'Selesai') ? ($laporan->instansi ? $laporan->instansi->nama : 'Instansi terkait menerima laporan') : '-', 'date' => '-', 'done' => in_array($laporan->status, ['Ditindaklanjuti', 'Selesai']), 'color' => 'slate'],
                            ['label' => 'Dalam Penanganan', 'desc' => $laporan->status === 'Diproses' || $laporan->status === 'Selesai' ? 'Laporan sedang diproses' : '-', 'date' => '-', 'done' => in_array($laporan->status, ['Diproses', 'Selesai']), 'color' => 'slate'],
                            ['label' => 'Selesai', 'desc' => $laporan->status === 'Selesai' ? 'Laporan selesai ditangani' : '-', 'date' => '-', 'done' => $laporan->status === 'Selesai', 'color' => 'slate'],
                        ] as $step)
                            <div class="relative flex gap-4 pb-7 last:pb-0">
                                @if(!$loop->last)
                                    <div class="absolute left-[15px] top-8 h-[calc(100%-2rem)] w-px bg-slate-200"></div>
                                @endif
                                <div class="relative z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $step['done'] ? ($step['color'] === 'green' ? 'bg-green-500 text-white' : ($step['color'] === 'amber' ? 'bg-amber-500 text-white' : 'bg-slate-400 text-white')) : 'bg-slate-200 text-white' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="{{ $step['done'] ? '' : 'opacity-55' }}">
                                    <div class="text-sm font-extrabold text-slate-800">{{ $step['label'] }}</div>
                                    <div class="mt-1 text-sm leading-5 text-slate-500">{{ $step['desc'] }}</div>
                                    <div class="mt-2 text-xs font-semibold text-slate-400">{{ $step['date'] ?: '-' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>
@endsection
