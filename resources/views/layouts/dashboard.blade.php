<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - RODOKAN')</title>
    @vite('resources/css/app.css')
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="text-slate-800 antialiased overflow-hidden h-screen flex">

    @php
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
        $sidebarBg = $isAdmin ? 'bg-blue-800 border-r-0' : 'bg-white border-r border-slate-200';
        $logoText = $isAdmin ? 'text-white' : 'text-slate-800';
        $logoIconBg = $isAdmin ? 'bg-white' : 'bg-transparent';
        $logoIconColor = $isAdmin ? 'text-blue-800' : 'text-blue-600';
        $inactiveLink = $isAdmin ? 'text-white/80 hover:bg-white/10' : 'text-slate-600 hover:bg-slate-50';
        $activeLink = $isAdmin ? 'bg-white text-blue-800 font-semibold' : 'bg-blue-50 text-blue-600 font-semibold';
        $inactiveIcon = $isAdmin ? 'text-white/70' : 'text-slate-400';
        $activeIcon = $isAdmin ? 'text-blue-800' : 'text-blue-600';
    @endphp

    <!-- Sidebar -->
    <aside class="w-64 {{ $sidebarBg }} flex flex-col justify-between h-full shrink-0 relative z-20 transition-colors duration-300">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b {{ $isAdmin ? 'border-white/10' : 'border-slate-100' }}">
            <div class="flex items-center gap-3">
                <div class="{{ $logoIconBg }} w-10 h-10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $logoIconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[17px] font-extrabold {{ $logoText }} tracking-tight leading-tight">RODOKAN</span>
                    @if($isAdmin)
                        <span class="text-[11px] text-blue-300 font-medium">Admin Pemkot</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 scrollbar-hide">
            <!-- Common Menu: Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? $activeLink : $inactiveLink }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>

            @if($isAdmin)
                <!-- Admin Menu -->
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.peta.*') ? $activeLink : $inactiveLink }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.peta.*') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Peta Sebaran
                </a>
                <a href="{{ route('verifikasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('verifikasi.*') ? $activeLink : $inactiveLink }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('verifikasi.*') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Verifikasi Laporan
                </a>
            @else
                <!-- Masyarakat Menu -->
                <a href="{{ route('laporan.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('laporan.create') ? $activeLink : $inactiveLink }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('laporan.create') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Buat Laporan
                </a>
                <a href="{{ route('laporan.saya') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('laporan.saya') ? $activeLink : $inactiveLink }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('laporan.saya') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Laporan Saya
                </a>
            @endif

            <!-- Common Menus -->
            @if(!$isAdmin)
            <a href="{{ route('laporan.publik') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('laporan.publik') ? $activeLink : $inactiveLink }}">
                <svg class="w-5 h-5 {{ request()->routeIs('laporan.publik') ? $activeIcon : $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Laporan Publik
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $inactiveLink }}">
                <svg class="w-5 h-5 {{ $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Statistik
            </a>
            @endif
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $inactiveLink }}">
                <svg class="w-5 h-5 {{ $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Notifikasi
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $inactiveLink }}">
                <svg class="w-5 h-5 {{ $inactiveIcon }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Pengaturan
            </a>
        </div>

        <!-- User Profile (Bottom) -->
        <div class="border-t border-slate-100 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm uppercase">
                        {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Guest User' }}</p>
                        <p class="text-[10px] text-slate-500 truncate max-w-[100px]">{{ auth()->user()->email ?? 'guest@example.com' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#f8fafc] relative">
        <!-- Top Navigation -->
        <header class="h-16 flex items-center justify-end px-8 border-b border-slate-200/60 bg-white/50 backdrop-blur-md sticky top-0 z-10 shrink-0">
            <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
        </header>

        <!-- Content scrollable area -->
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            @yield('content')
        </div>
    </main>

    <!-- Success Popup / Modal -->
    @if(session('success'))
        <div id="success-popup" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm opacity-0 transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 transform scale-95 transition-transform duration-300" id="success-modal">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5 relative">
                    <div class="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-20"></div>
                    <svg class="w-8 h-8 text-green-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 text-center mb-2">Pesan Terkirim!</h3>
                <p class="text-sm text-slate-500 text-center mb-8">{{ session('success') }}</p>
                <button onclick="closeSuccessPopup()" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-blue-600/20">
                    Lanjut
                </button>
            </div>
        </div>
        <script>
            // Simple animation for the modal
            document.addEventListener("DOMContentLoaded", () => {
                const popup = document.getElementById('success-popup');
                const modal = document.getElementById('success-modal');
                
                // Show with animation
                setTimeout(() => {
                    popup.classList.remove('opacity-0');
                    modal.classList.remove('scale-95');
                    modal.classList.add('scale-100');
                }, 50);
            });

            function closeSuccessPopup() {
                const popup = document.getElementById('success-popup');
                const modal = document.getElementById('success-modal');
                
                // Hide with animation
                popup.classList.add('opacity-0');
                modal.classList.remove('scale-100');
                modal.classList.add('scale-95');
                
                // Remove from DOM after transition
                setTimeout(() => {
                    popup.remove();
                }, 300);
            }
        </script>
    @endif

</body>
</html>
