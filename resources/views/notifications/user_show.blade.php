@extends('layouts.dashboard')

@section('title', 'Detail Notifikasi - RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto w-full space-y-6">
    <!-- Header Notification Info -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex gap-4">
            <div class="w-12 h-12 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900">Laporan Anda telah diverifikasi</h1>
                <div class="flex items-center gap-3 mt-1.5 text-sm text-slate-500 font-medium">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>5 menit lalu</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-green-50 text-green-600 border border-green-100">Status Update</span>
                </div>
            </div>
        </div>
        <div class="mt-6 text-slate-600 text-sm leading-relaxed space-y-4">
            <p>Selamat! Laporan Anda dengan judul <strong>"Banjir di Jalan Soekarno-Hatta"</strong> telah diverifikasi oleh petugas BPBD Kota Bandung. Laporan Anda telah memenuhi standar kelayakan dan akan segera ditindaklanjuti oleh tim tanggap darurat.</p>
            <p>Tim kami menghargai partisipasi aktif Anda dalam membantu masyarakat. Informasi yang Anda berikan sangat membantu dalam upaya penanganan bencana di wilayah Anda.</p>
        </div>
    </div>

    <!-- Laporan Terkait -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">Laporan Terkait</h2>
        </div>
        <div class="p-6">
            <!-- Thumbnail Image -->
            <div class="w-full h-48 sm:h-64 bg-slate-200 rounded-xl mb-5 overflow-hidden">
                <!-- Using placeholder since we don't have the real image -->
                <img src="https://images.unsplash.com/photo-1542385151-efd9000785a0?q=80&w=800&auto=format&fit=crop" alt="Banjir" class="w-full h-full object-cover">
            </div>
            
            <div class="flex items-center gap-2 mb-3">
                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-red-50 text-red-600">Bencana Alam</span>
                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-600">Terverifikasi</span>
            </div>
            
            <h3 class="text-lg font-bold text-slate-900 mb-3">Banjir di Jalan Soekarno-Hatta</h3>
            
            <div class="space-y-1.5 mb-4 text-sm text-slate-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Kec. Dayeuhkolot, Bandung</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Dilaporkan 18 Apr 2026, 14:30 WIB</span>
                </div>
            </div>
            
            <p class="text-sm text-slate-600 mb-6 leading-relaxed">Banjir setinggi 1 meter terjadi di Jalan Soekarno-Hatta akibat hujan deras sejak pagi. Beberapa kendaraan terperangkap dan akses jalan tertutup. Warga diminta mencari jalur alternatif.</p>
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-5 border-t border-slate-100">
                <div class="flex items-center gap-6 text-slate-500 font-medium text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        <span>24</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>12</span>
                    </div>
                </div>
                <button type="button" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors w-full sm:w-auto text-center">Lihat Detail Laporan</button>
            </div>
        </div>
    </div>

    <!-- Riwayat Status Timeline -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">Riwayat Status</h2>
        </div>
        <div class="p-6">
            <div class="relative pl-8 space-y-8 before:absolute before:inset-0 before:ml-12 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-slate-200">
                
                <!-- Vertical Line (override tailwind before if using flex approach) -->
                <div class="absolute left-10 top-2 bottom-6 w-0.5 bg-slate-200"></div>

                <!-- Step 1: Diverifikasi -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 w-12 h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-7 h-7 rounded-full bg-green-500 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-slate-900">Laporan Diverifikasi</h4>
                        <p class="text-sm text-slate-500 mt-1">Laporan telah diverifikasi oleh BPBD Kota Bandung</p>
                        <span class="text-[11px] font-medium text-slate-400 mt-1 block">18 Apr 2026, 15:45 WIB</span>
                    </div>
                </div>

                <!-- Step 2: Diterima -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 w-12 h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-7 h-7 rounded-full bg-blue-500 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-slate-900">Laporan Diterima</h4>
                        <p class="text-sm text-slate-500 mt-1">Laporan Anda telah diterima sistem dan sedang ditinjau</p>
                        <span class="text-[11px] font-medium text-slate-400 mt-1 block">18 Apr 2026, 14:30 WIB</span>
                    </div>
                </div>

                <!-- Step 3: Dibuat -->
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 w-12 h-12 bg-white rounded-full flex items-center justify-center border-4 border-white z-10">
                        <div class="w-7 h-7 rounded-full bg-slate-300 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h4 class="text-sm font-bold text-slate-600">Laporan Dibuat</h4>
                        <p class="text-sm text-slate-500 mt-1">Anda membuat laporan tentang bencana banjir</p>
                        <span class="text-[11px] font-medium text-slate-400 mt-1 block">18 Apr 2026, 14:25 WIB</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tindakan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">Tindakan</h2>
        </div>
        <div class="p-6 flex flex-wrap items-center gap-3">
            <button type="button" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Lihat Komentar
            </button>
            <button type="button" class="px-5 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                Bagikan
            </button>
            <button type="button" class="px-5 py-2.5 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 text-red-600 text-sm font-semibold rounded-xl transition-colors flex items-center gap-2">
                Hapus Notifikasi
            </button>
        </div>
    </div>
</div>
@endsection
