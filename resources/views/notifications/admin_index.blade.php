@extends('layouts.dashboard')

@section('title', 'Notifikasi Admin - RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Notifikasi Admin</h1>
            <p class="text-slate-500 text-sm">Pantau pemberitahuan penting terkait laporan masyarakat Kota Bandung</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Tandai Semua Dibaca
            </button>
            <button type="button" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus Semua
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card 1 -->
        <div class="bg-blue-500 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">12</h3>
                <p class="text-xs font-medium text-white/80">Notifikasi Baru</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Card 2 -->
        <div class="bg-red-600 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">3</h3>
                <p class="text-xs font-medium text-white/80">Laporan Darurat</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Card 3 -->
        <div class="bg-amber-500 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">8</h3>
                <p class="text-xs font-medium text-white/80">Menunggu Verifikasi</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Card 4 -->
        <div class="bg-orange-600 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">5</h3>
                <p class="text-xs font-medium text-white/80">Update Instansi</p>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6 flex overflow-x-auto scrollbar-hide">
        <button type="button" onclick="switchNotifTab('semua')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-blue-600 border-blue-600" data-target="semua">Semua</button>
        <button type="button" onclick="switchNotifTab('belum-dibaca')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="belum-dibaca">Belum Dibaca</button>
        <button type="button" onclick="switchNotifTab('sudah-dibaca')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="sudah-dibaca">Sudah Dibaca</button>
        <button type="button" onclick="switchNotifTab('darurat')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="darurat">Darurat</button>
        <button type="button" onclick="switchNotifTab('verifikasi')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="verifikasi">Verifikasi</button>
        <button type="button" onclick="switchNotifTab('komentar')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="komentar">Komentar Warga</button>
        <button type="button" onclick="switchNotifTab('instansi')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="instansi">Update Instansi</button>
    </div>

    <!-- Main Panel Container -->
    <div class="space-y-6">
        
        <!-- BELUM DIBACA PANEL -->
        <div id="panel-belum-dibaca" class="notif-panel-group bg-white rounded-2xl border border-slate-200 shadow-sm p-6" data-groups="semua,belum-dibaca,darurat,verifikasi,komentar,instansi">
            <h2 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Belum Dibaca (5)
            </h2>
            
            <div class="space-y-4">
                <!-- Item 1: Darurat -->
                <div class="notif-item relative bg-red-50/50 rounded-xl border border-red-100 p-4 pl-5 overflow-hidden group" data-type="darurat">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500 rounded-l-xl"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Laporan Darurat Baru Masuk</h3>
                                <p class="text-xs text-slate-600 mt-1 mb-2">Pohon tumbang menghalangi jalan utama di Kecamatan Coblong, perlu penanganan segera</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                    <span class="text-blue-600 font-bold">RK-9920</span> &bull; 
                                    <span>Coblong</span> &bull; 
                                    <span>5 menit lalu</span> &bull; 
                                    <a href="#" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 2: Verifikasi -->
                <div class="notif-item relative bg-amber-50/50 rounded-xl border border-amber-100 p-4 pl-5 overflow-hidden group" data-type="verifikasi">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500 rounded-l-xl"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Laporan Menunggu Verifikasi</h3>
                                <p class="text-xs text-slate-600 mt-1 mb-2">Laporan jalan rusak parah di Jalan Soekarno Hatta perlu ditinjau dan diverifikasi</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                    <span class="text-blue-600 font-bold">RK-9921</span> &bull; 
                                    <span>Batununggal</span> &bull; 
                                    <span>15 menit lalu</span> &bull; 
                                    <a href="#" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 3: Biasa -->
                <div class="notif-item relative bg-blue-50/50 rounded-xl border border-blue-100 p-4 pl-5 overflow-hidden group" data-type="biasa">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500 rounded-l-xl"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Laporan Baru dari Warga</h3>
                                <p class="text-xs text-slate-600 mt-1 mb-2">Warga melaporkan sampah menumpuk di TPS liar, Kecamatan Batununggal</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                    <span class="text-blue-600 font-bold">RK-9923</span> &bull; 
                                    <span>Batununggal</span> &bull; 
                                    <span>25 menit lalu</span> &bull; 
                                    <a href="#" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 4: Komentar -->
                <div class="notif-item relative bg-purple-50/50 rounded-xl border border-purple-100 p-4 pl-5 overflow-hidden group" data-type="komentar">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-purple-500 rounded-l-xl"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Komentar Baru dari Warga</h3>
                                <p class="text-xs text-slate-600 mt-1 mb-2">Budi Santoso mengomentari: "Kondisi semakin parah, tolong dipercepat penanganannya"</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                    <span class="text-blue-600 font-bold">RK-9921</span> &bull; 
                                    <span>Batununggal</span> &bull; 
                                    <span>30 menit lalu</span> &bull; 
                                    <a href="#" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 5: Instansi -->
                <div class="notif-item relative bg-orange-50/50 rounded-xl border border-orange-100 p-4 pl-5 overflow-hidden group" data-type="instansi">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-500 rounded-l-xl"></div>
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Update dari Instansi</h3>
                                <p class="text-xs text-slate-600 mt-1 mb-2">Dinas PU memperbarui status laporan sampah menumpuk menjadi "Ditindaklanjuti"</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500">
                                    <span class="text-blue-600 font-bold">RK-9918</span> &bull; 
                                    <span>Bandung Wetan</span> &bull; 
                                    <span>1 jam lalu</span> &bull; 
                                    <a href="#" class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-bold">Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 bg-white rounded-lg opacity-0 group-hover:opacity-100 transition-opacity shadow-sm border border-slate-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SUDAH DIBACA PANEL -->
        <div id="panel-sudah-dibaca" class="notif-panel-group bg-white rounded-2xl border border-slate-200 shadow-sm p-6 block" data-groups="semua,sudah-dibaca">
            <h2 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Sudah Dibaca (3)
            </h2>
            
            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="notif-item bg-white rounded-xl border border-slate-200 p-4 overflow-hidden group hover:border-slate-300 transition-colors" data-type="biasa">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Laporan Telah Selesai</h3>
                                <p class="text-xs text-slate-500 mt-1 mb-2">Penanganan jalan berlubang di Cicadas telah selesai dan ditandai sebagai "Selesai"</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                    <span class="text-blue-500 font-bold">RK-8821</span> &bull; 
                                    <span>Cicadas</span> &bull; 
                                    <span>3 jam lalu</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="notif-item bg-white rounded-xl border border-slate-200 p-4 overflow-hidden group hover:border-slate-300 transition-colors" data-type="biasa">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Rekap Harian Tersedia</h3>
                                <p class="text-xs text-slate-500 mt-1 mb-2">Laporan rekap harian untuk 22 April 2026 telah tersedia untuk diunduh</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                    <span>5 jam lalu</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="notif-item bg-white rounded-xl border border-slate-200 p-4 overflow-hidden group hover:border-slate-300 transition-colors" data-type="biasa">
                    <div class="flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-500 text-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Update Sistem</h3>
                                <p class="text-xs text-slate-500 mt-1 mb-2">Sistem RODOKAN telah diperbarui dengan fitur peta interaktif yang lebih baik</p>
                                <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                    <span>1 hari lalu</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="text-slate-400 hover:text-slate-600 p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchNotifTab(tabId) {
        // Show/hide groups based on data-groups attribute
        document.querySelectorAll('.notif-panel-group').forEach(group => {
            const groups = group.getAttribute('data-groups').split(',');
            if (groups.includes(tabId)) {
                group.style.display = 'block';
            } else {
                group.style.display = 'none';
            }
        });
        
        // Filter individual items within the groups
        document.querySelectorAll('.notif-item').forEach(item => {
            const itemType = item.getAttribute('data-type');
            if (tabId === 'semua' || tabId === 'belum-dibaca' || tabId === 'sudah-dibaca') {
                item.style.display = 'block'; // Show all items in their respective panels
            } else {
                if (itemType === tabId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
        
        // Reset all tabs
        document.querySelectorAll('.notif-tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('text-slate-500', 'border-transparent', 'hover:text-slate-700');
        });
        
        // Highlight active tab
        const activeBtn = document.querySelector(`.notif-tab-btn[data-target="${tabId}"]`);
        if(activeBtn) {
            activeBtn.classList.remove('text-slate-500', 'border-transparent', 'hover:text-slate-700');
            activeBtn.classList.add('text-blue-600', 'border-blue-600');
        }
    }
</script>
@endsection
