@extends('layouts.auth')

@section('title', 'Login - RODOKAN')

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
            <p class="text-blue-100 text-sm mb-12">Sistem Pelaporan Keluhan Jawa Barat</p>

            <!-- Dashboard Preview Card -->
            <div class="bg-blue-500/30 backdrop-blur-sm border border-blue-400/30 rounded-2xl p-6 mb-8 shadow-lg">
                <h3 class="font-semibold mb-4">Live Dashboard</h3>
                
                <!-- Mock Map Area -->
                <div class="bg-blue-600/50 rounded-xl h-32 mb-4 relative flex items-center justify-center overflow-hidden">
                    <div class="absolute w-2 h-2 bg-blue-300 rounded-full top-1/4 left-1/4 opacity-70"></div>
                    <div class="absolute w-3 h-3 bg-blue-200 rounded-full bottom-1/3 right-1/3 opacity-50"></div>
                    <!-- Pin Icon -->
                    <svg class="w-8 h-8 text-white absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <!-- Ripple effect -->
                    <div class="w-12 h-12 bg-white/20 rounded-full absolute animate-ping opacity-75"></div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="bg-blue-600/40 rounded-lg p-2">
                        <div class="text-[10px] text-blue-200 mb-1">Laporan Hari Ini</div>
                        <div class="text-lg font-bold">47</div>
                    </div>
                    <div class="bg-blue-600/40 rounded-lg p-2">
                        <div class="text-[10px] text-blue-200 mb-1">Aktif</div>
                        <div class="text-lg font-bold">12</div>
                    </div>
                    <div class="bg-blue-600/40 rounded-lg p-2">
                        <div class="text-[10px] text-blue-200 mb-1">Selesai</div>
                        <div class="text-lg font-bold">35</div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/30 rounded-lg mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-sm">Real-time Monitoring</h4>
                        <p class="text-xs text-blue-200 mt-1">Pantau Keluhan secara langsung</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-blue-500/30 rounded-lg mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-sm">Verified Reports</h4>
                        <p class="text-xs text-blue-200 mt-1">Laporan terverifikasi & terpercaya</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-blue-200/80">
            &copy; 2026 RODOKAN - Pemerintah Provinsi Jawa Barat
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="flex-1 flex items-center justify-center p-6 lg:p-12 relative">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Masuk ke RODOKAN</h1>
            <p class="text-sm text-slate-500 mb-8">Pantau dan laporkan Keluhan secara cepat dan terintegrasi</p>

            <!-- Role Toggle -->
            <div class="bg-slate-100 p-1 rounded-xl flex items-center mb-6 border border-slate-200/50">
                <button type="button" class="w-1/2 py-2.5 text-[13px] font-semibold rounded-lg bg-white shadow-sm text-blue-600 border border-slate-200/50 transition-all text-center">Masyarakat</button>
                <button type="button" class="w-1/2 py-2.5 text-[13px] font-semibold rounded-lg text-slate-500 hover:text-slate-700 transition-all text-center">Admin Pemerintah</button>
            </div>

            <!-- Login Form -->
            <form action="#" method="POST" class="space-y-5">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-medium text-slate-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="nama@email.com" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 focus:bg-white" placeholder="Masukkan password" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer">
                            <svg class="h-4 w-4 text-slate-400 hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-xs text-slate-600 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-xs">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Lupa password?</a>
                    </div>
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-slate-500">atau</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-3">
                    <a href="#" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-slate-200 rounded-xl shadow-sm bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all">
                        <!-- Google Logo SVG -->
                        <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Masuk dengan Google
                    </a>
                    <a href="#" class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-slate-200 rounded-xl shadow-sm bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all">
                        <!-- SatuData Logo mock -->
                        <div class="h-4 w-4 mr-2 bg-blue-600 text-white rounded-[4px] flex items-center justify-center font-bold text-[8px]">SD</div>
                        Masuk dengan SatuData
                    </a>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-slate-600">
                Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Daftar</a>
            </p>

            <div class="mt-12 text-center flex items-center justify-center gap-1 text-slate-400">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="text-[10px]">Dilindungi dengan enkripsi 256-bit SSL</span>
            </div>
        </div>
    </div>
</div>
@endsection
