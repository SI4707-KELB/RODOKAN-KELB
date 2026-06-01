@extends('layouts.dashboard')

@section('title', 'Detail Laporan - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto pb-20">

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Left Column -->
        <div class="flex-1 w-full space-y-6">
            
            <!-- Card Utama -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 md:p-8 shadow-sm">
                <!-- Tags & ID -->
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    <span class="text-sm font-bold text-blue-600">
                        #RODOKAN-{{ \Carbon\Carbon::parse($laporan->created_at)->format('Y') }}-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-[11px] font-bold rounded-md">
                        {{ $laporan->kategori->nama ?? 'Lainnya' }}
                    </span>
                    
                    @php
                        $statusColor = match($laporan->status) {
                            'Menunggu' => 'bg-slate-100 text-slate-700',
                            'Terverifikasi' => 'bg-green-100 text-green-700',
                            'Ditolak' => 'bg-red-100 text-red-700',
                            'Diproses' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'Dalam Penanganan' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'Selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            default => 'bg-slate-50 text-slate-600',
                        };
                        $statusText = $laporan->status;
                        if ($statusText == 'Diproses') $statusText = 'Dalam Penanganan';
                    @endphp
                    <span class="px-2.5 py-1 {{ $statusColor }} border text-[11px] font-bold rounded-md">
                        {{ $statusText }}
                    </span>

                    <span class="ml-auto flex items-center gap-1.5 text-green-600 text-[11px] font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Terverifikasi
                    </span>
                </div>

                @if($laporan->urgensi == 'Tinggi')
                <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 border border-red-200 text-xs font-bold rounded-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                        Mendesak
                    </span>
                </div>
                @endif

                <!-- Judul & Info Singkat -->
                <h1 class="text-2xl font-bold text-slate-800 mb-3 leading-tight">
                    {{ $laporan->judul_laporan }}
                </h1>
                
                <div class="flex items-center gap-4 text-xs text-slate-500 font-medium mb-8">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $laporan->created_at->format('d F Y, H:i') }} WIB</span>
                    </div>
                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>{{ number_format(($laporan->id * 17) % 3000 + 100) }} views</span>
                    </div>
                </div>

                <!-- Grey Info Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 bg-slate-50 border border-slate-100 rounded-xl p-5">
                    <div>
                        <p class="text-[10px] text-slate-500 mb-1">Dilaporkan oleh</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-xs font-bold text-slate-800 truncate">{{ $laporan->is_anonim ? 'Anonim' : ($laporan->user->name ?? 'Pengguna') }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 mb-1">Lokasi Kejadian</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="text-xs font-bold text-slate-800 truncate">{{ $laporan->kecamatan }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 mb-1">Waktu Kejadian</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold text-slate-800 truncate">{{ $laporan->waktu_kejadian ? $laporan->waktu_kejadian->format('d M Y, H:i') : $laporan->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 mb-1">Instansi Terkait</p>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span class="text-xs font-bold text-slate-800 truncate">BPBD Kota Bandung</span>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-6 mb-8">
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 mb-2">Ringkasan Kejadian</h2>
                        <div class="text-sm text-slate-600 leading-relaxed">
                            {{ Str::limit($laporan->deskripsi, 250) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 mb-2">Kronologi Lengkap</h2>
                        <div class="text-sm text-slate-600 leading-relaxed space-y-4">
                            {!! nl2br(e($laporan->deskripsi)) !!}
                        </div>
                    </div>
                </div>

                <!-- Bukti Foto -->
                <div>
                    <h2 class="text-sm font-bold text-slate-800 mb-3">Bukti Foto</h2>
                    @if($laporan->foto)
                        <div class="w-full h-80 sm:h-100 rounded-xl overflow-hidden bg-slate-100 relative group border border-slate-200">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Bukti Kejadian" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-40 rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-medium">Tidak ada foto bukti</span>
                        </div>
                    @endif
                </div>

                <!-- Evidence Layering -->
                <div class="mt-6 rounded-2xl border border-slate-200/70 bg-linear-to-br from-slate-50 to-white p-5 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900 text-white text-[11px] font-semibold mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                                Evidence Layering
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">Bukti Tambahan</h2>
                            <p class="text-xs text-slate-500 mt-1">Semua bukti masuk ke laporan yang sama dan ditampilkan dari terbaru ke terlama.</p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-[11px] font-semibold">
                            <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-600">{{ $totalEvidences }} bukti</span>
                            <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-600">{{ $uniqueContributors }} kontributor</span>
                        </div>
                    </div>

                    @if($evidenceLayers->isEmpty())
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">Belum ada bukti tambahan</h3>
                            <p class="mt-1 text-sm text-slate-500">Upload foto, video, atau dokumen untuk memperkuat laporan ini.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($evidenceLayers->sortByDesc('created_at') as $evidence)
                                @php
                                    $ext = strtolower(pathinfo($evidence->file_path, PATHINFO_EXTENSION));
                                    $typeLabel = match($evidence->evidence_type) {
                                        'photo' => 'Foto',
                                        'video' => 'Video',
                                        'document' => 'Dokumen',
                                        default => ucfirst($evidence->evidence_type),
                                    };
                                @endphp
                                <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="grid gap-0 md:grid-cols-[180px_1fr]">
                                        <div class="relative min-h-40 bg-slate-100">
                                            @if(in_array($ext, ['jpg','jpeg','png','webp']))
                                                <img src="{{ asset('storage/' . $evidence->file_path) }}" alt="{{ $typeLabel }} bukti" class="h-full w-full object-cover">
                                            @elseif($ext === 'mp4')
                                                <video src="{{ asset('storage/' . $evidence->file_path) }}" class="h-full w-full object-cover" controls></video>
                                            @elseif($ext === 'pdf')
                                                <div class="flex h-full min-h-40 items-center justify-center bg-linear-to-br from-rose-50 to-white text-rose-500">
                                                    <div class="text-center">
                                                        <svg class="mx-auto mb-2 h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7V3m10 4V3M6 11h12M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        <div class="text-xs font-bold tracking-wide">PDF</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex h-full min-h-40 items-center justify-center bg-slate-50 text-slate-400">
                                                    <div class="text-center">
                                                        <svg class="mx-auto mb-2 h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        <div class="text-xs font-bold tracking-wide">FILE</div>
                                                    </div>
                                                </div>
                                            @endif
                                            <span class="absolute left-3 top-3 rounded-full bg-slate-900/80 px-2.5 py-1 text-[10px] font-bold text-white backdrop-blur">
                                                {{ $typeLabel }}
                                            </span>
                                        </div>

                                        <div class="flex flex-col gap-4 p-4 sm:p-5">
                                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                <div>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-[11px] font-bold uppercase ring-4 ring-blue-50">
                                                            {{ substr($evidence->user?->name ?? 'A', 0, 2) }}
                                                        </div>
                                                        <div>
                                                            <h3 class="text-sm font-bold text-slate-900">{{ $evidence->user?->name ?? 'Anonim' }}</h3>
                                                            <p class="text-xs text-slate-500">Ditambahkan {{ $evidence->created_at->diffForHumans() }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 flex flex-wrap items-center gap-2 text-[11px] font-semibold">
                                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ $typeLabel }}</span>
                                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">{{ $evidence->created_at->format('d M Y, H:i') }} WIB</span>
                                                    </div>
                                                </div>

                                                @if(auth()->check() && (auth()->id() === $evidence->user_id || auth()->user()->role === 'admin'))
                                                    <form action="{{ route('laporan.evidence.destroy', ['laporan' => $laporan->id, 'evidence' => $evidence->id]) }}" method="POST" onsubmit="return confirm('Hapus bukti ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center gap-1 rounded-full border border-rose-200 bg-rose-50 px-3 py-1.5 text-[11px] font-bold text-rose-600 transition-colors hover:bg-rose-100">
                                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"></path></svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                            @if($evidence->description)
                                                <p class="text-sm leading-relaxed text-slate-600">{{ $evidence->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-4">
                            <h3 class="text-sm font-bold text-slate-900">Tambah Bukti</h3>
                            <p class="mt-1 text-xs text-slate-500">Pilih jenis bukti, unggah file, lalu beri keterangan singkat bila perlu.</p>
                        </div>
                        @auth
                            <form action="{{ route('laporan.evidence.store', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis Bukti</label>
                                    <select name="evidence_type" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" required>
                                        <option value="photo">Foto</option>
                                        <option value="video">Video</option>
                                        <option value="document">Dokumen (PDF)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">File Bukti</label>
                                    <input type="file" name="file" class="block w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:border-blue-400 hover:bg-white" required>
                                    <p class="mt-2 text-[11px] text-slate-400">Maksimal 10 MB. Foto: JPG/PNG, video: MP4, dokumen: PDF.</p>
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Keterangan</label>
                                    <textarea name="description" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" placeholder="Contoh: kondisi jalan pada pukul 08.30, lokasi sudah difoto dari sisi utara."></textarea>
                                </div>
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="text-[11px] text-slate-400">Bukti akan tampil di timeline terbaru dan bisa dilihat semua pengguna.</div>
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Unggah Bukti
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                Silakan <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">masuk</a> untuk menambahkan bukti.
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Lokasi Kejadian (Map) -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 md:p-8 shadow-sm">
                <h2 class="text-sm font-bold text-slate-800 mb-4">Lokasi Kejadian</h2>
                
                <div class="w-full h-64 bg-slate-900 rounded-xl relative overflow-hidden mb-4 shadow-inner border border-slate-200">
                    <!-- Map Graphic Placeholder -->
                    <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                    <svg class="absolute inset-0 w-full h-full text-yellow-600/20" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="street-grid" width="30" height="30" patternUnits="userSpaceOnUse">
                                <path d="M 30 0 L 0 0 0 30" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#street-grid)" />
                        <!-- Diagonal lines mimicking roads -->
                        <path d="M0,50 Q100,100 200,50 T400,100 T600,0" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M0,150 Q150,50 300,150 T600,100" fill="none" stroke="currentColor" stroke-width="1"/>
                        <circle cx="200" cy="100" r="150" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="100" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                        <circle cx="200" cy="100" r="50" fill="none" stroke="currentColor" stroke-width="0.5" stroke-dasharray="4 4" />
                    </svg>

                    <!-- Ping Point -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 flex flex-col items-center">
                        <div class="w-6 h-6 bg-blue-600 border-4 border-white rounded-full shadow-lg"></div>
                        <div class="w-16 h-16 bg-blue-500/30 rounded-full absolute -top-5 -left-5 animate-ping"></div>
                    </div>
                </div>

                <div class="bg-blue-50/50 border border-blue-100 rounded-lg p-4">
                    <p class="text-xs leading-relaxed text-blue-900">
                        <span class="font-bold">Alamat Lengkap:</span> {{ $laporan->alamat ?? ($laporan->kecamatan . ', Kota Bandung, Jawa Barat 40239') }}
                    </p>
                </div>
            </div>

            <!-- Komentar & Tanggapan -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 md:p-8 shadow-sm">
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <h2 class="text-base font-bold text-slate-800">Komentar & Tanggapan ({{ $laporan->komentars->count() }})</h2>
                </div>

                <div class="space-y-4 mb-8">
                    @forelse($laporan->komentars as $komentar)
                        @if($komentar->user->role === 'admin')
                            <!-- Admin/Official Comment -->
                            <div class="flex gap-4 p-4 bg-blue-50/50 rounded-xl border-l-4 border-l-blue-500 border-t border-b border-r border-blue-100">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm uppercase">
                                    {{ substr($komentar->user->name, 0, 2) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1 gap-1">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm font-bold text-slate-800">{{ $komentar->user->name }}</h4>
                                            <span class="px-2 py-0.5 bg-blue-600 text-white text-[9px] font-bold rounded-full flex items-center gap-1">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Official
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-700 leading-relaxed mb-2">
                                        {{ $komentar->isi_komentar }}
                                    </p>
                                    <span class="text-[10px] font-medium text-slate-500">{{ $komentar->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                            </div>
                        @else
                            <!-- User Comment -->
                            <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="w-10 h-10 rounded-full bg-slate-300 flex items-center justify-center text-slate-600 font-bold text-sm shrink-0 uppercase">
                                    {{ substr($komentar->user->name, 0, 2) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-1 gap-1">
                                        <h4 class="text-sm font-bold text-slate-800">{{ $komentar->user->name }}</h4>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed mb-2">
                                        {{ $komentar->isi_komentar }}
                                    </p>
                                    <span class="text-[10px] font-medium text-slate-400">{{ $komentar->created_at->format('d M Y, H:i') }} WIB</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-6">
                            <p class="text-sm text-slate-400">Belum ada komentar atau tanggapan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Komentar Input Form -->
                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Tulis Tanggapan</h3>
                    <form action="{{ route('komentar.store', $laporan->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        <div class="flex-1">
                            <textarea name="komentar" required rows="3" class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none transition-all" placeholder="Bagikan informasi atau tanggapan Anda..."></textarea>
                        </div>
                        <button type="submit" class="sm:w-auto h-fit px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column (Sidebar) -->
        <div class="w-full lg:w-80 shrink-0 space-y-6">
            
            <!-- Status Penanganan Timeline -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-6">Status Penanganan</h3>
                
                <div class="relative space-y-6 before:absolute before:inset-0 before:ml-4 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-linear-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    
                    <!-- Laporan Diterima -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-green-500/30 z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold text-slate-800 mb-0.5">Laporan Diterima</h4>
                            <p class="text-[10px] text-slate-500 leading-snug mb-1">Laporan telah masuk ke sistem RODOKAN</p>
                            <span class="text-[9px] font-medium text-slate-400">{{ $laporan->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>

                    <!-- Terverifikasi -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Terverifikasi</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Laporan diverifikasi oleh BPBD Kota Bandung</p>
                            @if($laporan->waktu_verifikasi)
                                <span class="text-[9px] font-medium text-slate-400">{{ $laporan->waktu_verifikasi->format('d M Y, H:i') }} WIB</span>
                            @endif
                        </div>
                    </div>

                    <!-- Diteruskan -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Diteruskan ke Instansi</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Diproses', 'Selesai', 'Darurat', 'Ditindaklanjuti']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Laporan diteruskan ke instansi terkait</p>
                        </div>
                    </div>

                    <!-- Dalam Penanganan -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti']) ? 'bg-blue-500 shadow-blue-500/30 text-white' : (in_array($laporan->status, ['Selesai']) ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-100 text-slate-400') }} flex items-center justify-center shrink-0 shadow-sm z-10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti', 'Selesai']) ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Dalam Penanganan</h4>
                            <p class="text-[10px] {{ in_array($laporan->status, ['Diproses', 'Darurat', 'Ditindaklanjuti', 'Selesai']) ? 'text-slate-500' : 'text-slate-400' }} leading-snug mb-1">Tim lapangan sedang menangani lokasi kejadian</p>
                        </div>
                    </div>

                    <!-- Selesai -->
                    <div class="relative flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full {{ $laporan->status === 'Selesai' ? 'bg-green-500 shadow-green-500/30 text-white' : 'bg-slate-50 text-slate-300' }} flex items-center justify-center shrink-0 shadow-sm z-10 border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="pt-1 flex-1">
                            <h4 class="text-xs font-bold {{ $laporan->status === 'Selesai' ? 'text-slate-800' : 'text-slate-400' }} mb-0.5">Selesai</h4>
                            <p class="text-[10px] text-slate-400 leading-snug mb-1">Penanganan selesai dan lokasi aman</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Informasi Laporan -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-5">Informasi Laporan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Kategori</span>
                        <span class="px-2 py-1 bg-red-50 text-red-600 border border-red-100 text-[10px] font-bold rounded">
                            {{ $laporan->kategori->nama ?? 'Bencana Alam' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Tingkat Urgensi</span>
                        <span class="px-2 py-1 {{ $laporan->urgensi == 'Tinggi' ? 'bg-red-50 text-red-600 border border-red-100' : ($laporan->urgensi == 'Sedang' ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'bg-slate-50 text-slate-600 border border-slate-100') }} text-[10px] font-bold rounded flex items-center gap-1">
                            @if($laporan->urgensi == 'Tinggi')
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                            Mendesak
                            @else
                            {{ $laporan->urgensi }}
                            @endif
                        </span>
                    </div>
                    <div class="flex flex-col gap-1.5 pt-1">
                        <span class="text-xs text-slate-500">Instansi Penanganan</span>
                        <span class="text-sm font-bold text-slate-800">BPBD Kota Bandung</span>
                    </div>
                    <div class="flex flex-col gap-1.5 pt-2 border-t border-slate-100">
                        <span class="text-xs text-slate-500">Status Saat Ini</span>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold rounded">
                                {{ $laporan->status == 'Diproses' ? 'Dalam Penanganan' : $laporan->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                        <span class="text-xs text-slate-500">Komentar</span>
                        <span class="text-xs font-bold text-slate-800">{{ $laporan->komentars->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-slate-500">Dukungan</span>
                        <span class="text-xs font-bold text-slate-800">{{ $upvotesCount ?? $laporan->upvotes->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Interaksi Publik -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Interaksi Publik</h3>
                <div class="space-y-3">
                    @php
                        $hasUpvoted = auth()->check() && $laporan->upvotes->contains('user_id', auth()->id());
                    @endphp
                    <form action="{{ route('laporan.upvote', $laporan->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg text-xs font-bold transition-colors bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 shadow-sm">
                            <svg class="w-4 h-4" fill="{{ $hasUpvoted ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            Dukung ({{ $upvotesCount ?? $laporan->upvotes->count() }})
                        </button>
                    </form>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                            Simpan
                        </button>
                        <button class="w-full flex items-center justify-center gap-2 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-bold transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            Bagikan
                        </button>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-2 text-[10px] text-slate-500">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Laporan Publik - Dapat dilihat semua orang
                </div>
            </div>

            <!-- Tindakan Cepat -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Tindakan Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('laporan.create') }}" class="w-full flex items-center justify-center gap-2 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition-colors shadow-sm">
                        Laporkan Kejadian Serupa
                    </a>
                    <a href="{{ route('laporan.public') }}" class="w-full flex items-center justify-center gap-2 py-2.5 bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100 rounded-lg text-xs font-bold transition-colors">
                        Lihat Laporan Lainnya
                    </a>
                </div>
            </div>

            <!-- Laporan Terkait -->
            
            <!-- Donasi Laporan -->
            <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-linear-to-br from-emerald-50 via-white to-white shadow-sm">
                <div class="bg-linear-to-r from-emerald-600 to-teal-600 px-5 py-4 text-white">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 11v-2m0 2a9 9 0 100-18 9 9 0 000 18z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold">Donasi untuk Laporan</h3>
                            <p class="text-xs text-emerald-50/90">Bantu penanganan dengan dukungan dana langsung pada laporan ini.</p>
                        </div>
                    </div>
                </div>

                <div class="p-5">
                    @if(session('success'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
                    @endif

                    <div class="mb-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium uppercase tracking-wide text-slate-500">Total Donasi</span>
                            <span class="text-lg font-extrabold text-slate-900">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <p class="mt-2 text-xs leading-relaxed text-slate-500">Jika belum ada donasi, Anda bisa menjadi kontributor pertama untuk membantu laporan ini.</p>
                    </div>

                    @if($laporan->donasis->count() === 0)
                        <div class="mb-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-4 text-sm text-slate-600">
                            Belum ada donasi untuk laporan ini.
                        </div>
                    @endif

                    @auth
                        <form action="{{ route('laporan.donasi', $laporan->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Nominal (Rp)</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
                                    <input name="jumlah" type="number" min="1000" required class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10" placeholder="50000">
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Pesan (opsional)</label>
                                <textarea name="pesan" rows="3" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10" placeholder="Tinggalkan pesan dukungan..."></textarea>
                            </div>
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 11v-2m0 2a9 9 0 100-18 9 9 0 000 18z"></path></svg>
                                Donasi Sekarang
                            </button>
                        </form>
                    @else
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            Silakan <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">masuk</a> untuk memberikan donasi.
                        </div>
                    @endauth

                    @if($laporan->donasis->count() > 0)
                        <div class="mt-5 border-t border-slate-100 pt-4">
                            <h4 class="mb-3 text-xs font-bold uppercase tracking-wide text-slate-500">Donatur Terbaru</h4>
                            <div class="space-y-3">
                                @foreach($laporan->donasis->take(3) as $donasi)
                                    <div class="flex items-start justify-between gap-3 rounded-xl bg-slate-50 px-4 py-3">
                                        <div>
                                            <div class="text-sm font-semibold text-slate-800">{{ $donasi->user?->name ?? 'Anonim' }}</div>
                                            <div class="text-[11px] text-slate-500">{{ $donasi->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="rounded-full bg-white px-3 py-1 text-xs font-bold text-slate-800 shadow-sm">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if($relatedLaporans->count() > 0)
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <h3 class="text-sm font-bold text-slate-800">Laporan Terkait</h3>
                </div>
                
                <div class="space-y-4">
                    @foreach($relatedLaporans as $related)
                        <a href="{{ route('laporan.show', $related->id) }}" class="block p-4 bg-white border border-slate-100 rounded-xl hover:border-blue-200 hover:shadow-md transition-all group">
                            <span class="inline-block px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-bold rounded mb-2">
                                {{ $related->kategori->nama ?? 'Bencana Alam' }}
                            </span>
                            <h4 class="text-xs font-bold text-slate-800 mb-1 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $related->judul_laporan }}</h4>
                            <div class="flex items-center gap-3 text-[10px] text-slate-400 font-medium">
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> Bandung</span>
                                <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $related->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                <a href="#" class="block text-center mt-4 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
