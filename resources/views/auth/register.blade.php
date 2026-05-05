@extends('layouts.auth')

@section('title', 'Register - RODOKAN')

@section('content')
<div class="flex min-h-screen">
    <!-- Left Sidebar (Blue) -->
    <div class="hidden lg:flex lg:w-5/12 bg-blue-600 text-white flex-col justify-between p-12 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-blue-500/20 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-blue-700/20 blur-3xl"></div>

        <div class="relative z-10">
            <!-- Logo -->
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="text-2xl font-bold tracking-wide">RODOKAN</span>
            </div>
            <p class="text-blue-100 text-sm mb-16">Sistem Keluhan Bencana Jawa Barat</p>

            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-4 leading-tight">Bergabung dengan Komunitas Tanggap Keluhan</h2>
                <p class="text-blue-100 text-sm leading-relaxed">Bersama membangun sistem pelaporan yang cepat, akurat, dan terpercaya untuk keselamatan masyarakat Jawa Barat</p>
            </div>

            <!-- Features -->
            <div class="space-y-6">
                <!-- Feature 1 -->
                <div class="flex items-start gap-4 p-4 bg-blue-500/20 rounded-2xl border border-blue-400/20">
                    <div class="p-2 bg-blue-400/30 rounded-lg shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-sm mb-1">Laporan Real-time</h4>
                        <p class="text-xs text-blue-200 leading-relaxed">Laporkan Keluhan dengan lokasi akurat dan dapatkan respon cepat dari pihak berwenang</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="flex items-start gap-4 p-4 bg-blue-500/20 rounded-2xl border border-blue-400/20">
                    <div class="p-2 bg-blue-400/30 rounded-lg shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-sm mb-1">Notifikasi Darurat</h4>
                        <p class="text-xs text-blue-200 leading-relaxed">Terima peringatan dini dan update status Keluhan di wilayah Anda</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="flex items-start gap-4 p-4 bg-blue-500/20 rounded-2xl border border-blue-400/20">
                    <div class="p-2 bg-blue-400/30 rounded-lg shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-sm mb-1">Komunitas Peduli</h4>
                        <p class="text-xs text-blue-200 leading-relaxed">Bergabung dengan ribuan warga yang aktif memantau dan melaporkan kondisi lingkungan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-blue-200/80 mt-12">
            &copy; 2026 RODOKAN - Pemerintah Provinsi Jawa Barat
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 overflow-y-auto">
        <div class="w-full max-w-[500px] bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8 my-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Buat Akun RODOKAN</h1>
            <p class="text-sm text-slate-500 mb-8 leading-relaxed">Daftar untuk melaporkan Keluhan, memantau status, dan berpartisipasi dalam informasi publik</p>

            <!-- Role Toggle -->
            <div class="bg-slate-100 p-1 rounded-xl flex items-center mb-6 border border-slate-200/50">
                <button type="button" class="w-1/2 py-2.5 text-[13px] font-semibold rounded-lg bg-white shadow-sm text-blue-600 border border-slate-200/50 transition-all text-center">Masyarakat</button>
                <button type="button" class="w-1/2 py-2.5 text-[13px] font-semibold rounded-lg text-slate-500 hover:text-slate-700 transition-all text-center">Admin Pemerintah</button>
            </div>

            <!-- Register Form -->
            <form action="#" method="POST" class="space-y-4">
                @csrf
                
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" id="name" name="name" class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" id="email" name="email" class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="nama@email.com" required>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone" class="block text-xs font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <input type="tel" id="phone" name="phone" class="block w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="08xx xxxx xxxx" required>
                    </div>
                </div>

                <!-- Kota/Kabupaten -->
                <div>
                    <label for="city" class="block text-xs font-medium text-slate-700 mb-1">Kota/Kabupaten</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <select id="city" name="city" class="block w-full pl-9 pr-8 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white appearance-none text-slate-500">
                            <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Bekasi">Bekasi</option>
                            <option value="Bogor">Bogor</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full pl-9 pr-9 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="Minimal 8 karakter" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <svg class="h-4 w-4 text-slate-400 hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full pl-9 pr-9 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="Masukkan ulang password" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <svg class="h-4 w-4 text-slate-400 hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Anonim -->
                <div class="mt-4 p-3 bg-blue-50 rounded-xl border border-blue-100">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="anonim" name="anonim" type="checkbox" class="w-4 h-4 text-blue-600 bg-white border-blue-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer mt-0.5">
                        </div>
                        <div class="ml-2 text-xs">
                            <label for="anonim" class="font-medium text-slate-800 cursor-pointer">Kirim laporan secara anonim bila diperlukan</label>
                            <p id="anonim-description" class="text-slate-500 mt-0.5">Identitas Anda tetap terlindungi saat melaporkan bencana sensitif</p>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="mt-4 text-center text-xs text-slate-600">
                    Saya menyetujui <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Syarat & Ketentuan</a> dan <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Kebijakan Privasi</a> RODOKAN
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Masuk</a>
            </p>

            <div class="mt-8 text-center flex items-center justify-center gap-1 text-slate-400">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="text-[10px]">Data Anda dilindungi dengan enkripsi 256-bit SSL</span>
            </div>
        </div>
    </div>
</div>
@endsection
