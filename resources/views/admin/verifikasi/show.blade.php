@extends('layouts.dashboard')

@section('title', 'Detail Verifikasi Laporan - RODOKAN')

@section('content')
<style>
    /* Break out of overflow container for truly fixed positioning */
    .verification-checklist-fixed {
        position: fixed !important;
        top: 6rem !important;
        right: 2rem !important;
        width: 20rem !important;
        max-height: calc(100vh - 7.5rem) !important;
        z-index: 9999 !important;
    }
</style>

<div class="p-8 max-w-7xl mx-auto pb-20">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('verifikasi.index') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Verifikasi
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Detail Verifikasi Laporan</h1>
        <p class="text-slate-500 mt-1">Tinjau dan verifikasi laporan dari masyarakat</p>
    </div>

    <!-- Fixed Checklist Sidebar - Using portal-like fixed element -->
    <div class="verification-checklist-fixed bg-white rounded-2xl border border-slate-200/60 p-6 shadow-lg overflow-y-auto">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Checklist Verifikasi</h3>
        
        <form class="space-y-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Deskripsi laporan jelas dan lengkap</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Foto bukti tersedia</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Lokasi GPS tersedia</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Lokasi berada di Kota Bandung</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Kategori sesuai klasifikasi</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Tidak ada duplikasi laporan</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Bukti foto relevan dengan laporan</span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm text-slate-700">Tingkat urgensi sesuai kondisi</span>
            </label>

            <div class="pt-2 pb-2 text-xs text-slate-600 border-t border-slate-100">
                <span class="font-semibold">1/8</span> Item terverifikasi
            </div>
        </form>

        <!-- Action Buttons inside Fixed Card -->
        <div class="mt-4 pt-4 border-t border-slate-100 space-y-3">
            <button onclick="showVerifyModal({{ $laporan->id }})" class="w-full px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Setujui
            </button>
            
            <button onclick="showRejectModal({{ $laporan->id }})" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Tolak Laporan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-8">
        <!-- Main Content (Left & Center) -->
        <div class="col-span-2 space-y-6">
            <!-- Report Header Card -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 mb-2">{{ $laporan->judul_laporan }}</h2>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-lg">RK-{{ str_pad($laporan->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center flex-wrap gap-2">
                            @php
                                $categoryColor = match(strtolower($laporan->kategori->nama ?? '')) {
                                    'infrastruktur' => 'bg-orange-100 text-orange-700',
                                    'bencana' => 'bg-red-100 text-red-700',
                                    'pelayanan' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                                $urgencyColor = match($laporan->urgensi) {
                                    'Rendah' => 'bg-blue-100 text-blue-700',
                                    'Sedang' => 'bg-yellow-100 text-yellow-700',
                                    'Tinggi' => 'bg-red-100 text-red-700',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp
                            <span class="px-2.5 py-1 {{ $categoryColor }} text-xs font-bold rounded">
                                {{ $laporan->kategori->nama ?? 'Lainnya' }}
                            </span>
                            <span class="px-2.5 py-1 {{ $urgencyColor }} text-xs font-bold rounded">
                                Urgente {{ ucfirst($laporan->urgensi) }}
                            </span>
                            <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Reporter Info -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Pelapor</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $laporan->is_anonim ? 'Anonim' : ($laporan->user->name ?? 'Unknown') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Waktu</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $laporan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Kecamatan</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $laporan->kecamatan }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium mb-1">Interaksi</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $laporan->upvotes->count() }} upvotes, {{ $laporan->komentars->count() ?? 0 }} komentar</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Deskripsi Laporan</h3>
                <p class="text-slate-700 leading-relaxed">{{ $laporan->deskripsi }}</p>
            </div>

            <!-- Evidence Photos -->
            @if($laporan->foto)
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Bukti Foto Kejadian
                </h3>
                <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Bukti Kejadian" class="w-full rounded-xl object-cover max-h-96">
                @if($laporan->evidences && $laporan->evidences->count() > 0)
                    <p class="text-xs text-slate-500 mt-3">{{ $laporan->evidences->count() }} foto</p>
                @endif
            </div>
            @endif

            <!-- Location Map -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Lokasi Kejadian</h3>
                <div class="w-full h-64 bg-slate-200 rounded-xl mb-4 flex items-center justify-center">
                    @if($laporan->latitude && $laporan->longitude)
                        <div class="text-center">
                            <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <p class="text-xs text-slate-500">{{ $laporan->latitude }}, {{ $laporan->longitude }}</p>
                        </div>
                    @else
                        <p class="text-slate-500">Lokasi GPS tidak tersedia</p>
                    @endif
                </div>
                <p class="text-sm text-blue-600 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.658 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Alamat Lengkap: {{ $laporan->alamat }}
                </p>
            </div>

            <!-- Comments & Discussion -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Tanggapan & Diskusi
                    <span class="text-xs font-normal text-slate-500">({{ $laporan->komentars->count() ?? 0 }} komentar)</span>
                </h3>

                <!-- Comment Input -->
                <div class="mb-6 p-4 bg-slate-50 rounded-xl">
                    <form class="flex gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold uppercase">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <textarea placeholder="Tulis tanggapan Anda..." rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            <div class="mt-2 text-right">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 ml-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Tanggapan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                @if($laporan->komentars && $laporan->komentars->count() > 0)
                    <div class="space-y-4">
                        @foreach($laporan->komentars as $komentar)
                            <div class="flex gap-3 pb-4 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-full bg-slate-300 text-white flex items-center justify-center text-xs font-bold uppercase flex-shrink-0">
                                    {{ substr($komentar->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-sm font-semibold text-slate-800">{{ $komentar->user->name ?? 'Unknown' }}</p>
                                        @if($komentar->user->role === 'admin')
                                            <span class="px-2 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded">Admin</span>
                                        @endif
                                        <span class="text-xs text-slate-500">{{ $komentar->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700">{{ $komentar->konten }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500 text-center py-8">Belum ada komentar</p>
                @endif
            </div>
        </div>

        <!-- Sidebar (Right) - Scrollable Content -->
        <div class="col-span-1 space-y-6">
            <!-- No Action Section -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-3">Tidak Lanjut</h4>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" class="w-4 h-4">
                        <span class="text-slate-700">Status Penanganan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" class="w-4 h-4">
                        <span class="text-slate-700">Iratan Tujuan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" class="w-4 h-4">
                        <span class="text-slate-700">Catatan Pemerintah</span>
                    </label>
                </div>
                <p class="text-xs text-slate-500 mt-3 italic">Tulis catatan untuk instansi terkait...</p>
            </div>

            <!-- Quick Info -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-4">Informasi Cepat</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <span class="text-slate-600">Upvotes:</span>
                        <span class="font-semibold text-slate-800">{{ $laporan->upvotes->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <span class="text-slate-600">Komentar:</span>
                        <span class="font-semibold text-slate-800">{{ $laporan->komentars->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                        <span class="text-slate-600">Views:</span>
                        <span class="font-semibold text-slate-800">234</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Shares:</span>
                        <span class="font-semibold text-slate-800">12</span>
                    </div>
                </div>
            </div>

            <!-- Status History -->
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
                <h4 class="font-bold text-slate-800 mb-4">Status Penanganan</h4>
                <div class="space-y-3">
                    @php
                        $statuses = [
                            ['label' => 'Laporan Diterima', 'icon' => '✓', 'color' => 'bg-green-500', 'date' => $laporan->created_at->format('d M Y, H:i')],
                            ['label' => 'Menunggu Verifikasi', 'icon' => '⏳', 'color' => 'bg-yellow-500', 'date' => ''],
                        ];
                        if ($laporan->waktu_verifikasi) {
                            $statuses[] = ['label' => 'Terverifikasi', 'icon' => '✓', 'color' => 'bg-green-500', 'date' => $laporan->waktu_verifikasi->format('d M Y, H:i')];
                        }
                    @endphp
                    
                    @foreach($statuses as $status)
                        <div class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ $status['color'] }} text-white flex items-center justify-center text-xs font-bold">
                                    {{ $status['icon'] }}
                                </div>
                                <div class="w-0.5 h-6 bg-slate-200 mt-2"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-800">{{ $status['label'] }}</p>
                                @if($status['date'])
                                    <p class="text-xs text-slate-500">{{ $status['date'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-8 transform transition-all">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 id="modalTitle" class="text-xl font-bold text-slate-800 text-center mb-2">Konfirmasi Verifikasi</h3>
        <p id="modalMessage" class="text-sm text-slate-600 text-center mb-8">Apakah Anda yakin ingin memverifikasi laporan ini?</p>
        
        <div id="rejectReasonContainer" class="hidden mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Penolakan</label>
            <textarea id="rejectReason" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
        </div>

        <div class="flex gap-3">
            <button onclick="closeModal()" class="flex-1 px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold rounded-lg transition-colors">
                Batal
            </button>
            <button id="confirmBtn" onclick="confirmAction()" class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-4 p-8 transform transition-all">
        <div id="resultIcon" class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h3 id="resultTitle" class="text-xl font-bold text-slate-800 text-center mb-2">Berhasil!</h3>
        <p id="resultMessage" class="text-sm text-slate-600 text-center mb-8">Laporan berhasil diverifikasi</p>
        
        <button onclick="closeResultModal()" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
            Kembali ke Daftar
        </button>
    </div>
</div>

<script>
let currentReportId = null;
let currentAction = null;

function showVerifyModal(id) {
    currentReportId = id;
    currentAction = 'verify';
    
    document.getElementById('modalTitle').textContent = 'Konfirmasi Verifikasi';
    document.getElementById('modalMessage').textContent = 'Apakah Anda yakin ingin memverifikasi laporan ini?';
    document.getElementById('rejectReasonContainer').classList.add('hidden');
    document.getElementById('confirmBtn').className = 'flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors';
    document.getElementById('confirmBtn').textContent = 'Verifikasi';
    
    document.getElementById('confirmModal').classList.remove('hidden');
}

function showRejectModal(id) {
    currentReportId = id;
    currentAction = 'reject';
    
    document.getElementById('modalTitle').textContent = 'Tolak Laporan';
    document.getElementById('modalMessage').textContent = 'Apakah Anda yakin ingin menolak laporan ini?';
    document.getElementById('rejectReasonContainer').classList.remove('hidden');
    document.getElementById('rejectReason').value = '';
    document.getElementById('confirmBtn').className = 'flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors';
    document.getElementById('confirmBtn').textContent = 'Tolak';
    
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    currentReportId = null;
    currentAction = null;
}

function closeResultModal() {
    document.getElementById('resultModal').classList.add('hidden');
    window.location.href = '{{ route("verifikasi.index") }}';
}

function confirmAction() {
    if (currentAction === 'verify') {
        verifyReport(currentReportId);
    } else if (currentAction === 'reject') {
        const reason = document.getElementById('rejectReason').value.trim();
        if (!reason) {
            alert('Silakan masukkan alasan penolakan');
            return;
        }
        rejectReport(currentReportId, reason);
    }
}

function verifyReport(id) {
    const btn = document.getElementById('confirmBtn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';

    fetch(`/verifikasi/${id}/verifikasi`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            catatan_verifikasi: '',
            admin_id: {{ auth()->id() }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            closeModal();
            showResultModal('success', 'Berhasil!', 'Laporan berhasil diverifikasi');
        } else {
            closeModal();
            showResultModal('error', 'Gagal', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        closeModal();
        showResultModal('error', 'Gagal', 'Terjadi kesalahan saat memproses verifikasi');
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Konfirmasi';
    });
}

function rejectReport(id, reason) {
    const btn = document.getElementById('confirmBtn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';

    fetch(`/verifikasi/${id}/tolak`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify({
            alasan_penolakan: reason,
            admin_id: {{ auth()->id() }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            closeModal();
            showResultModal('error', 'Berhasil!', 'Laporan berhasil ditolak');
        } else {
            closeModal();
            showResultModal('error', 'Gagal', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        closeModal();
        showResultModal('error', 'Gagal', 'Terjadi kesalahan saat memproses penolakan');
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Konfirmasi';
    });
}

function showResultModal(type, title, message) {
    const icon = document.getElementById('resultIcon');
    const titleEl = document.getElementById('resultTitle');
    const messageEl = document.getElementById('resultMessage');
    
    if (type === 'success') {
        icon.className = 'w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5';
        icon.innerHTML = '<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
    } else {
        icon.className = 'w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5';
        icon.innerHTML = '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    }
    
    titleEl.textContent = title;
    messageEl.textContent = message;
    
    document.getElementById('resultModal').classList.remove('hidden');
}
</script>
@endsection
