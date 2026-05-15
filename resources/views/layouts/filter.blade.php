<div class="bg-white border border-slate-200 rounded-xl p-5 mb-8 shadow-sm">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2 text-slate-800 font-bold text-lg">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter Laporan
        </div>
        <a href="{{ url()->current() }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
            Reset Filter
        </a>
    </div>

    <form method="GET" action="{{ url()->current() }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Filter Urutkan -->
        <div>
            <label for="sort" class="block text-sm font-medium text-slate-700 mb-2">Urutkan</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="w-full text-sm rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-600 py-2 px-3 bg-white shadow-sm">
                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Dukungan Terbanyak</option>
            </select>
        </div>

        <!-- Filter Kategori Keluhan -->
        <div>
            <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">Kategori Keluhan</label>
            <select name="kategori" id="kategori" onchange="this.form.submit()" class="w-full text-sm rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-600 py-2 px-3 bg-white shadow-sm">
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
            <label for="lokasi" class="block text-sm font-medium text-slate-700 mb-2">Lokasi</label>
            <select name="lokasi" id="lokasi" onchange="this.form.submit()" class="w-full text-sm rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-600 py-2 px-3 bg-white shadow-sm">
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
            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status Penanganan</label>
            <select name="status" id="status" onchange="this.form.submit()" class="w-full text-sm rounded-lg border border-slate-200 focus:border-blue-500 focus:ring-blue-500 text-slate-600 py-2 px-3 bg-white shadow-sm">
                <option value="">Semua Status</option>
                <option value="Terverifikasi" {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Ditindaklanjuti" {{ request('status') == 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
    </form>
</div>
