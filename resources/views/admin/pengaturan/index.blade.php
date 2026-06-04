@extends('layouts.dashboard')

@section('title', 'Pengaturan Admin - RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Pengaturan Admin</h1>
        <p class="text-slate-500 text-sm">Kelola konfigurasi akun, notifikasi, keamanan, dan sistem laporan Pemerintah Kota Bandung</p>
    </div>

    <!-- Main Content Grid -->
    <div class="flex flex-col lg:flex-row gap-6 items-start">
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-72 shrink-0 bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <nav class="space-y-1" id="settings-nav">
                <button type="button" onclick="switchTab('profil')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-blue-700 bg-blue-50" data-target="profil">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Admin
                </button>
                <button type="button" onclick="switchTab('keamanan')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-slate-600 hover:bg-slate-50" data-target="keamanan">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Keamanan Akun
                </button>
                <button type="button" onclick="switchTab('notifikasi')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-slate-600 hover:bg-slate-50" data-target="notifikasi">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    Notifikasi
                </button>

                <button type="button" onclick="switchTab('kategori')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-slate-600 hover:bg-slate-50" data-target="kategori">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Kategori Laporan
                </button>
                <button type="button" onclick="switchTab('status')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-slate-600 hover:bg-slate-50" data-target="status">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Status Laporan
                </button>
                <button type="button" onclick="switchTab('preferensi')" class="settings-tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-colors text-slate-600 hover:bg-slate-50" data-target="preferensi">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Preferensi Dashboard
                </button>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1 w-full min-w-0">
            <!-- Profil Admin Panel -->
            <div id="panel-profil" class="settings-panel bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Profil</h2>
                
                <div class="flex flex-col sm:flex-row gap-6 mb-8">
                    <div class="relative w-24 h-24 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-3xl font-bold shrink-0">
                        AK
                        <button class="absolute -bottom-2 -right-2 w-8 h-8 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-500 shadow-sm hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                    </div>
                    <div class="pt-2">
                        <h3 class="text-xl font-bold text-slate-900">Admin Kota Bandung</h3>
                        <p class="text-sm text-slate-500">Administrator Sistem RODOKAN</p>
                    </div>
                </div>

                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="Admin Kota Bandung">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                            <input type="text" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="Administrator Sistem">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email Dinas</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="email" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="admin@bandung.go.id">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Telepon</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="+62 22 4201234">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Unit Kerja</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" value="Pemerintah Kota Bandung">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <button type="button" class="px-5 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl transition-colors">Batal</button>
                        <button type="button" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Keamanan Akun Panel -->
            <div id="panel-keamanan" class="settings-panel hidden space-y-6">
                <!-- Ubah Password -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-6">Ubah Password</h2>
                    <form>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Lama</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan password lama">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Password Baru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </div>
                                    <input type="password" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan password baru">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </div>
                                    <input type="password" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none" placeholder="Ulangi password baru">
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Autentikasi Dua Faktor -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-6">Autentikasi Dua Faktor</h2>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Aktifkan 2FA</h3>
                            <p class="text-xs text-slate-500 mt-1">Tambahkan lapisan keamanan ekstra untuk akun Anda</p>
                        </div>
                        <!-- Toggle Switch -->
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex gap-3">
                        <div class="text-green-600 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-green-800">2FA Aktif</h4>
                            <p class="text-xs text-green-700 mt-1">Autentikasi dua faktor telah diaktifkan pada akun Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Panel -->
            <div id="panel-notifikasi" class="settings-panel hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Preferensi Notifikasi</h2>
                
                <div class="space-y-2">
                    <!-- Item 1 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Laporan Baru Masuk</h3>
                            <p class="text-xs text-slate-500 mt-1">Notifikasi saat ada laporan baru dari warga</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 2 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Laporan Darurat</h3>
                            <p class="text-xs text-slate-500 mt-1">Notifikasi prioritas tinggi untuk laporan darurat</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 3 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Menunggu Verifikasi</h3>
                            <p class="text-xs text-slate-500 mt-1">Pengingat laporan yang belum diverifikasi</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 4 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Komentar Warga</h3>
                            <p class="text-xs text-slate-500 mt-1">Notifikasi saat warga mengomentari laporan</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 5 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Update Instansi</h3>
                            <p class="text-xs text-slate-500 mt-1">Pemberitahuan saat instansi memperbarui status</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 6 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Laporan Selesai</h3>
                            <p class="text-xs text-slate-500 mt-1">Notifikasi saat laporan ditandai selesai</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>

                    <!-- Item 7 -->
                    <div class="bg-slate-50/50 hover:bg-slate-50 rounded-xl p-4 flex items-center justify-between transition-colors">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Rekap Harian</h3>
                            <p class="text-xs text-slate-500 mt-1">Ringkasan laporan harian setiap pukul 17:00</p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kategori Laporan Panel -->
            <div id="panel-kategori" class="settings-panel hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Kategori Laporan Aktif</h2>
                    <a href="{{ route('admin.kategori.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Kelola Kategori
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php $colors = ['bg-blue-500', 'bg-teal-500', 'bg-red-500', 'bg-green-500', 'bg-purple-500', 'bg-orange-500', 'bg-sky-500', 'bg-yellow-500']; @endphp
                    @forelse($kategoris as $i => $k)
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:border-slate-300 transition-colors">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="w-2.5 h-2.5 rounded-full {{ $colors[$i % count($colors)] }}"></span>
                                <h3 class="text-sm font-bold text-slate-800">{{ $k->nama }}</h3>
                            </div>
                            <p class="text-xs text-slate-500 ml-4.5">Total Laporan: <span class="font-semibold text-slate-700">{{ $k->laporans_count }}</span></p>
                        </div>
                        <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                            <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                        </button>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-8 text-sm text-slate-500">Belum ada kategori</div>
                    @endforelse
                </div>
            </div>

            <!-- Status Laporan Panel -->
            <div id="panel-status" class="settings-panel hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-slate-800">Manajemen Status Laporan</h2>
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Status
                    </button>
                </div>
                
                <div class="space-y-4">
                    <!-- Status Item -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:border-slate-300 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Menunggu</h3>
                                <p class="text-xs text-slate-500 mt-1">Laporan baru yang belum diverifikasi</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg">Default</span>
                            <button class="text-slate-400 hover:text-blue-600 transition-colors p-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status Item -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:border-slate-300 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Diproses</h3>
                                <p class="text-xs text-slate-500 mt-1">Laporan sedang ditangani oleh instansi terkait</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="text-slate-400 hover:text-blue-600 transition-colors p-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Status Item -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:border-slate-300 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Selesai</h3>
                                <p class="text-xs text-slate-500 mt-1">Laporan telah diselesaikan dan ditutup</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-lg">Final</span>
                            <button class="text-slate-400 hover:text-blue-600 transition-colors p-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status Item -->
                    <div class="border border-slate-200 rounded-xl p-4 flex items-center justify-between hover:border-slate-300 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Ditolak</h3>
                                <p class="text-xs text-slate-500 mt-1">Laporan tidak valid atau tidak memenuhi syarat</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-semibold rounded-lg">Final</span>
                            <button class="text-slate-400 hover:text-blue-600 transition-colors p-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Preferensi Dashboard Panel -->
            <div id="panel-preferensi" class="settings-panel hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6">Preferensi Tampilan Dashboard</h2>
                
                <div class="space-y-6">
                    <div class="border border-slate-200 rounded-xl p-5">
                        <h3 class="text-sm font-bold text-slate-800 mb-4">Tema Tampilan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="theme" class="peer sr-only" checked>
                                <div class="rounded-xl border-2 border-slate-200 p-4 hover:border-blue-100 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-center">
                                    <div class="w-full h-16 bg-slate-100 rounded-lg mb-3 shadow-inner flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 peer-checked:text-blue-700">Terang (Default)</span>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer opacity-50 relative">
                                <input type="radio" name="theme" class="peer sr-only" disabled>
                                <div class="rounded-xl border-2 border-slate-200 p-4 transition-all text-center">
                                    <div class="w-full h-16 bg-slate-800 rounded-lg mb-3 shadow-inner flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Gelap</span>
                                </div>
                                <span class="absolute top-2 right-2 bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded font-bold uppercase">Segera</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="border border-slate-200 rounded-xl p-5">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="text-sm font-bold text-slate-800">Animasi UI</h3>
                                <p class="text-xs text-slate-500 mt-1">Aktifkan efek transisi dan animasi di seluruh sistem</p>
                            </div>
                            <button type="button" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-green-500 transition-colors duration-200 ease-in-out focus:outline-none">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="button" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                            Simpan Preferensi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all panels
        document.querySelectorAll('.settings-panel').forEach(panel => {
            panel.classList.add('hidden');
            panel.classList.remove('block');
        });
        
        // Show target panel
        const targetPanel = document.getElementById('panel-' + tabId);
        if(targetPanel) {
            targetPanel.classList.remove('hidden');
            targetPanel.classList.add('block');
        }
        
        // Update styling for all buttons
        document.querySelectorAll('.settings-tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-700', 'bg-blue-50');
            btn.classList.add('text-slate-600', 'hover:bg-slate-50');
            
            // Reset icon colors
            const icon = btn.querySelector('svg');
            if(icon) {
                icon.classList.remove('text-blue-600');
                icon.classList.add('text-slate-400');
            }
        });
        
        // Highlight active button
        const activeBtn = document.querySelector(`.settings-tab-btn[data-target="${tabId}"]`);
        if(activeBtn) {
            activeBtn.classList.remove('text-slate-600', 'hover:bg-slate-50');
            activeBtn.classList.add('text-blue-700', 'bg-blue-50');
            
            // Highlight icon
            const activeIcon = activeBtn.querySelector('svg');
            if(activeIcon) {
                activeIcon.classList.remove('text-slate-400');
                activeIcon.classList.add('text-blue-600');
            }
        }
    }
    
    // Add logic for UI toggle switches
    document.addEventListener('DOMContentLoaded', () => {
        const toggles = document.querySelectorAll('button[role="switch"], .cursor-pointer.rounded-full');
        
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const isGreen = this.classList.contains('bg-green-500');
                const thumb = this.querySelector('span');
                
                if (isGreen) {
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-slate-200');
                    if(thumb) {
                        thumb.classList.remove('translate-x-5');
                        thumb.classList.add('translate-x-0');
                    }
                } else {
                    this.classList.remove('bg-slate-200');
                    this.classList.add('bg-green-500');
                    if(thumb) {
                        thumb.classList.remove('translate-x-0');
                        thumb.classList.add('translate-x-5');
                    }
                }
            });
        });
    });
</script>
@endsection
