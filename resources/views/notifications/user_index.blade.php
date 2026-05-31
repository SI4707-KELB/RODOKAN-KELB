@extends('layouts.dashboard')

@section('title', 'Notifikasi - RODOKAN')

@section('content')
<div class="p-6 max-w-4xl mx-auto w-full">
    <!-- Header -->
    <h1 class="text-2xl font-extrabold text-slate-900 mb-6">Notifikasi</h1>

    <!-- Summary Box -->
    <div class="bg-white rounded-xl border border-slate-200 p-5 mb-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-800">Semua Notifikasi</h2>
            <p class="text-sm text-slate-500">Anda memiliki 3 notifikasi yang belum dibaca</p>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium">
            <button type="button" class="text-blue-600 hover:text-blue-700 transition-colors">Tandai Semua Dibaca</button>
            <button type="button" class="text-slate-500 hover:text-slate-700 transition-colors">Hapus Semua</button>
        </div>
    </div>

    <!-- Belum Dibaca Section -->
    <div class="bg-[#f8fbff] rounded-xl border border-blue-100 border-l-4 border-l-blue-600 shadow-sm mb-6 overflow-hidden">
        <div class="px-5 py-3 border-b border-blue-100/50 bg-[#f0f6ff]/50">
            <h3 class="text-xs font-bold text-blue-800 uppercase tracking-wider">Belum Dibaca</h3>
        </div>
        <div class="divide-y divide-blue-100/50">
            <!-- Item 1 -->
            <div class="p-5 flex justify-between items-start group hover:bg-blue-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Laporan Anda telah diverifikasi</h4>
                        <p class="text-sm text-slate-600 mt-1 mb-2">Laporan "Banjir di Jalan Soekarno-Hatta" telah diverifikasi oleh petugas.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>5 menit lalu</span>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-bold ml-2">Lihat Laporan</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Item 2 -->
            <div class="p-5 flex justify-between items-start group hover:bg-blue-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Komentar baru pada laporan Anda</h4>
                        <p class="text-sm text-slate-600 mt-1 mb-2">Ahmad Hidayat mengomentari laporan "Pohon tumbang menghalangi jalan".</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>1 jam lalu</span>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-bold ml-2">Lihat Komentar</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Item 3 -->
            <div class="p-5 flex justify-between items-start group hover:bg-blue-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Peringatan Bencana di Wilayah Anda</h4>
                        <p class="text-sm text-slate-600 mt-1 mb-2">Banjir tinggi dilaporkan di Kecamatan Dayeuhkolot, Bandung. Harap waspada.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>2 jam lalu</span>
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-bold ml-2">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Sudah Dibaca Section -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-3 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sudah Dibaca</h3>
        </div>
        <div class="divide-y divide-slate-100">
            <!-- Item 1 -->
            <div class="p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-orange-300/80 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-600">Laporan sedang ditindaklanjuti</h4>
                        <p class="text-sm text-slate-500 mt-1 mb-2">Laporan "Genangan air setinggi 50cm" sedang dalam proses penanganan oleh BPBD.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>3 jam lalu</span>
                            <a href="#" class="text-slate-500 hover:text-slate-700 font-bold ml-2">Lihat Progress</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-300 hover:text-slate-500 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Item 2 -->
            <div class="p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-300/80 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-600">Skor Partisipasi Meningkat!</h4>
                        <p class="text-sm text-slate-500 mt-1 mb-2">Selamat! Skor partisipasi Anda naik menjadi 87 poin. Anda termasuk top 15% kontributor.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>5 jam lalu</span>
                            <a href="#" class="text-slate-500 hover:text-slate-700 font-bold ml-2">Lihat Skor</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-300 hover:text-slate-500 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Item 3 -->
            <div class="p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-300/80 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-600">3 komentar baru</h4>
                        <p class="text-sm text-slate-500 mt-1 mb-2">Laporan Anda tentang banjir mendapat 3 komentar dari warga lainnya.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>1 hari lalu</span>
                            <a href="#" class="text-slate-500 hover:text-slate-700 font-bold ml-2">Lihat Semua</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-300 hover:text-slate-500 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Item 4 -->
            <div class="p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-green-300/80 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-600">Laporan telah diselesaikan</h4>
                        <p class="text-sm text-slate-500 mt-1 mb-2">Penanganan untuk laporan "Pohon tumbang" telah selesai dilakukan.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>2 hari lalu</span>
                            <a href="#" class="text-slate-500 hover:text-slate-700 font-bold ml-2">Lihat Laporan</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-300 hover:text-slate-500 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Item 5 -->
            <div class="p-5 flex justify-between items-start group hover:bg-slate-50/50 transition-colors">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-slate-300 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-600">Update Sistem</h4>
                        <p class="text-sm text-slate-500 mt-1 mb-2">RODOKAN telah diperbarui dengan fitur baru: Notifikasi real-time dan peta interaktif.</p>
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>3 hari lalu</span>
                            <a href="#" class="text-slate-500 hover:text-slate-700 font-bold ml-2">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
                <button class="text-slate-300 hover:text-slate-500 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection
