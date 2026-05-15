@extends('layouts.dashboard')

@section('title', 'Buat Laporan Baru - RODOKAN')

@section('content')
<div class="p-8 max-w-7xl mx-auto">
    
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Left Column: Form -->
        <div class="flex-1 w-full space-y-6">
            
            <!-- Page Header Card -->
            <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-6 border-l-4 border-l-blue-500">
                <h1 class="text-xl font-bold text-slate-800 mb-1">Buat Laporan Baru</h1>
                <p class="text-sm text-slate-500">Sampaikan laporan keluhan secara lengkap agar dapat diproses lebih cepat oleh tim tanggap darurat</p>
            </div>

            <form action="{{ route('laporan.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Dasar -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Informasi Dasar</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_laporan" value="{{ old('judul_laporan') }}" placeholder="Contoh: Banjir di Jalan Soekarno-Hatta" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400">
                            @error('judul_laporan')
                                <p class="text-[10px] text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[10px] text-slate-400 mt-1.5">Buat judul yang jelas dan singkat</p>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Kejadian / Kronologi <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="4" placeholder="Jelaskan kronologi kejadian secara detail..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-[10px] text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                            <p class="text-[10px] text-slate-400 mt-1.5">Minimal 50 karakter. Jelaskan apa yang terjadi, kapan, dan dampaknya.</p>
                        </div>
                    </div>
                </div>

                <!-- Kategori Keluhan -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Kategori Keluhan <span class="text-red-500">*</span></h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <!-- Category Item 1 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="1">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-blue-500 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Infrastruktur</span>
                            </div>
                        </label>
                        <!-- Category Item 2 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="2">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-green-500 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Kebersihan</span>
                            </div>
                        </label>
                        <!-- Category Item 3 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="3">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-yellow-500 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Keamanan</span>
                            </div>
                        </label>
                        <!-- Category Item 4 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="4">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-orange-500 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Energi & Air</span>
                            </div>
                        </label>
                        <!-- Category Item 5 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="5">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-red-600 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Kesehatan</span>
                            </div>
                        </label>
                        <!-- Category Item 6 -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="kategori" class="peer sr-only" value="6">
                            <div class="border border-slate-200 rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center hover:border-blue-300 hover:bg-blue-50/30 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <div class="w-10 h-10 rounded-lg bg-slate-500 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Lainnya</span>
                            </div>
                        </label>
                    </div>
                    @error('kategori')
                        <p class="text-[10px] text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waktu Kejadian -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Waktu Kejadian</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Kejadian <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-600">
                            @error('tanggal_kejadian')
                                <p class="text-[10px] text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Waktu Kejadian <span class="text-red-500">*</span></label>
                            <input type="time" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}" class="w-full px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-600">
                            @error('waktu_kejadian')
                                <p class="text-[10px] text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Lokasi Kejadian -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Lokasi Kejadian</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Contoh: Jl. Soekarno-Hatta No. 123, Kec. Dayeuhkolot, Bandung" class="w-full pl-9 pr-3 py-2.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder:text-slate-400">
                            </div>
                            @error('alamat')
                                <p class="text-[10px] text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input id="use_current_location" type="checkbox" class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 cursor-pointer">
                            <label for="use_current_location" class="ml-2 text-xs font-medium text-slate-700 cursor-pointer">Gunakan lokasi saya saat ini</label>
                        </div>

                        <!-- Map Placeholder -->
                        <div class="w-full h-48 bg-slate-200 rounded-lg relative overflow-hidden flex items-center justify-center">
                            <!-- SVG pattern to look like roads -->
                            <svg class="absolute inset-0 w-full h-full text-slate-300" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1.5"/>
                                    </pattern>
                                </defs>
                                <rect width="100%" height="100%" fill="url(#grid)" />
                            </svg>
                            <!-- Pin -->
                            <div class="relative z-10 text-slate-600 flex flex-col items-center">
                                <svg class="w-10 h-10 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                <div class="w-3 h-3 bg-blue-500 border-2 border-white rounded-full absolute top-3"></div>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-200/50 to-transparent"></div>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti Laporan -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Upload Bukti Laporan</h2>
                    
                    <label for="foto_bukti" class="border-2 border-dashed border-slate-300 rounded-xl p-8 flex flex-col items-center justify-center text-center hover:bg-slate-50 transition-colors cursor-pointer group block">
                        <div id="upload-placeholder" class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 group-hover:text-blue-500 group-hover:bg-blue-50 transition-colors mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-700 mb-1">Klik untuk upload atau drag & drop</p>
                            <p class="text-[10px] text-slate-400">JPG atau PNG (Max 5MB per file, maksimal 3 foto)</p>
                        </div>
                        <div id="preview-container" class="hidden w-full flex flex-wrap gap-4 justify-center mt-4">
                            <!-- Previews akan muncul di sini -->
                        </div>
                        <input type="file" id="foto_bukti" name="foto_bukti[]" multiple accept="image/png, image/jpeg" class="hidden" onchange="previewImages(event)">
                    </label>
                    @error('foto_bukti')
                        <p class="text-[10px] text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tingkat Urgensi -->
                <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 mb-4">Tingkat Urgensi <span class="text-red-500">*</span></h2>
                    
                    <div class="grid grid-cols-3 gap-3">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="urgensi" class="peer sr-only" value="rendah">
                            <div class="border border-slate-200 rounded-xl py-3 text-center hover:border-slate-300 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50/50 peer-checked:ring-1 peer-checked:ring-blue-500">
                                <span class="text-xs font-semibold text-slate-700">Rendah</span>
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="urgensi" class="peer sr-only" value="sedang">
                            <div class="border border-slate-200 rounded-xl py-3 text-center hover:border-slate-300 transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:ring-1 peer-checked:ring-orange-500">
                                <span class="text-xs font-semibold text-slate-700">Sedang</span>
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="urgensi" class="peer sr-only" value="tinggi">
                            <div class="border border-slate-200 rounded-xl py-3 text-center hover:border-slate-300 transition-all peer-checked:border-red-500 peer-checked:bg-red-50/50 peer-checked:ring-1 peer-checked:ring-red-500">
                                <span class="text-xs font-semibold text-slate-700">Tinggi</span>
                            </div>
                        </label>
                    </div>
                    @error('urgensi')
                        <p class="text-[10px] text-red-500 mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Anonim Checkbox -->
                <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="anonim" name="anonim" value="1" type="checkbox" class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 cursor-pointer mt-0.5" {{ old('anonim') ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-xs">
                            <label for="anonim" class="font-bold text-slate-800 cursor-pointer">Kirim laporan secara anonim</label>
                            <p class="text-slate-500 mt-0.5">Identitas Anda akan disembunyikan dari publik, namun tetap tercatat dalam sistem</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2 pb-10">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Kirim Laporan Resmi
                    </button>
                    <button type="button" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                        Simpan Draft
                    </button>
                    <button type="reset" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                        Reset Form
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Sidebar Panels -->
        <div class="hidden lg:block w-80 shrink-0 space-y-6">
            
            <!-- Ringkasan Laporan -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-800 mb-4">Ringkasan Laporan</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Status</span>
                        <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 font-bold rounded text-[10px]">Draft</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Pelapor</span>
                        <span class="font-bold text-slate-800">{{ auth()->user()->name ?? 'Anonim' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Kategori</span>
                        <span class="font-bold text-slate-800">-</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-slate-500">Foto</span>
                        <span class="font-bold text-slate-800">0 / 3</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <div class="flex justify-between items-center text-xs font-bold text-slate-800 mb-2">
                        <span>Kelengkapan</span>
                        <span class="text-blue-600">0%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 mb-4">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: 0%"></div>
                    </div>
                    
                    <ul class="space-y-2 text-[11px] text-slate-400">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Judul laporan
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Kategori bencana
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Lokasi kejadian
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tanggal & waktu
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Deskripsi kejadian
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Bukti foto (opsional)
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tips Laporan Efektif -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-sm font-bold text-blue-800">Tips Laporan Efektif</h3>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-[10px] text-blue-700 leading-relaxed">Gunakan foto yang jelas dan menunjukkan kondisi sebenarnya</p>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <p class="text-[10px] text-blue-700 leading-relaxed">Pastikan lokasi yang dilaporkan akurat</p>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-3.5 h-3.5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <p class="text-[10px] text-blue-700 leading-relaxed">Isi kronologi singkat namun lengkap untuk mempercepat verifikasi</p>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</div>
</div>

<script>
    function previewImages(event) {
        const previewContainer = document.getElementById('preview-container');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const files = event.target.files;
        
        previewContainer.innerHTML = '';
        
        if (files.length > 0) {
            uploadPlaceholder.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            
            Array.from(files).slice(0, 3).forEach(file => { // Max 3 preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-24 h-24 object-cover rounded-lg border border-slate-200 shadow-sm';
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        } else {
            uploadPlaceholder.classList.remove('hidden');
            previewContainer.classList.add('hidden');
        }
    }
</script>
@endsection
