<div class="bg-white border border-slate-200 rounded-xl p-5 mb-8 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-base">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Cari & Filter
        </div>
        <a href="{{ url()->current() }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
            Reset Filter
        </a>
    </div>

    <form method="GET" action="{{ url()->current() }}" class="space-y-4">
        <!-- Input Pencarian -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari judul laporan, lokasi, atau kategori" class="pl-10 block w-full text-sm rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-600 py-2.5 px-3 bg-white shadow-sm transition-all placeholder:text-slate-400">
        </div>

        <!-- Dropdowns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Filter Urutkan -->
            <div>
                <select name="sort" id="sort" onchange="this.form.submit()" class="w-full text-xs rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-500 py-2.5 px-3 bg-white shadow-sm appearance-none">
                    <option value="">Urutkan</option>
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                    <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Dukungan Terbanyak</option>
                </select>
            </div>

            <!-- Filter Kategori Keluhan -->
            <div>
                <select name="kategori" id="kategori" onchange="this.form.submit()" class="w-full text-xs rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-500 py-2.5 px-3 bg-white shadow-sm">
                    <option value="">Semua Kategori</option>
                    @if(isset($kategoris))
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Filter Lokasi -->
            <div>
                <select name="lokasi" id="lokasi" onchange="this.form.submit()" class="w-full text-xs rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-500 py-2.5 px-3 bg-white shadow-sm">
                    <option value="">Semua Lokasi</option>
                    @if(isset($lokasis))
                        @foreach($lokasis as $lokasi)
                            @if($lokasi)
                                <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                                    {{ $lokasi }}
                                </option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Filter Status Penanganan -->
            <div>
                <select name="status" id="status" onchange="this.form.submit()" class="w-full text-xs rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-500 py-2.5 px-3 bg-white shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Terverifikasi" {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Ditindaklanjuti" {{ request('status') == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                    <option value="Darurat" {{ request('status') == 'Darurat' ? 'selected' : '' }}>Darurat</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
        </div>
    </form>
</div>
