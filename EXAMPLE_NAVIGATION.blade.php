<!-- Navigation/Sidebar Example for Admin -->
<!-- File: resources/views/layouts/sidebar.blade.php or navigation.blade.php -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-graph-up"></i> Sistem Pelaporan Bencana
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>

                    <!-- User Menu -->
                    @if(auth()->user()->role === 'user')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('laporan.create') }}">
                                <i class="bi bi-plus-circle"></i> Buat Laporan
                            </a>
                        </li>
                    @endif

                    <!-- Admin Menu -->
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.laporan.index') }}">
                                        <i class="bi bi-clipboard-data"></i> Manajemen Laporan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.laporan.stats') }}">
                                        <i class="bi bi-bar-chart"></i> Statistik & Report
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('verifikasi.index') }}">
                                        <i class="bi bi-check-circle"></i> Verifikasi Laporan
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Badge untuk pending reports -->
                        <li class="nav-item">
                            <span class="badge bg-danger rounded-pill ms-2">
                                {{ \App\Models\Laporan::where('status', 'Menunggu')->count() }}
                            </span>
                        </li>
                    @endif

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Guest Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Optional: Sidebar untuk Desktop -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar - Desktop Only -->
        @auth
        @if(auth()->user()->role === 'admin')
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar" style="min-height: 100vh;">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" 
                           href="{{ route('admin.laporan.index') }}">
                            <i class="bi bi-list-check"></i> Daftar Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.laporan.index', ['status' => 'Menunggu']) }}">
                            <i class="bi bi-clock"></i> Menunggu Verifikasi
                            <span class="badge bg-warning">
                                {{ \App\Models\Laporan::where('status', 'Menunggu')->count() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.laporan.index', ['urgensi' => 'Darurat']) }}">
                            <i class="bi bi-exclamation-triangle"></i> Darurat
                            <span class="badge bg-danger">
                                {{ \App\Models\Laporan::where('urgensi', 'Darurat')->count() }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.laporan.export', request()->query()) }}">
                            <i class="bi bi-download"></i> Export Data
                        </a>
                    </li>
                </ul>

                <hr>

                <div class="card border-0 bg-white">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-3">Statistik</h6>
                        <div class="mb-2">
                            <small class="text-muted">Total Laporan</small>
                            <p class="h5 mb-0">{{ \App\Models\Laporan::count() }}</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Hari Ini</small>
                            <p class="h5 mb-0">{{ \App\Models\Laporan::whereDate('created_at', \Carbon\Carbon::today())->count() }}</p>
                        </div>
                        <div>
                            <small class="text-muted">Selesai</small>
                            <p class="h5 mb-0">{{ \App\Models\Laporan::where('status', 'Selesai')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endauth

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<style>
    .sidebar {
        border-right: 1px solid #dee2e6;
    }

    .nav-link {
        color: #495057;
        padding: 0.75rem 1rem;
    }

    .nav-link:hover {
        color: #007bff;
        background-color: #f8f9fa;
    }

    .nav-link.active {
        color: #007bff;
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
        font-weight: 600;
    }

    .badge {
        margin-left: auto;
    }
</style>
