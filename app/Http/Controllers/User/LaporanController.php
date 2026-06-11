<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\DuplicateLaporanService;
use App\Services\NotificationDispatcherService;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct(
        protected DuplicateLaporanService $duplicateService,
        protected NotificationDispatcherService $notificationDispatcher,
    ) {}
    public function create()
    {
        return view('user.laporan.create');
    }

    public function checkDuplicate(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|exists:kategoris,id',
            'alamat' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $similar = $this->duplicateService->findSimilar([
            'judul_laporan' => $validated['judul_laporan'] ?? '',
            'deskripsi' => $validated['deskripsi'] ?? '',
            'kategori_id' => $validated['kategori'] ?? null,
            'alamat' => $validated['alamat'] ?? '',
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
        ]);

        return response()->json([
            'has_duplicates' => $similar->isNotEmpty(),
            'duplicates' => $similar,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:20',
            'kategori' => 'required|exists:kategoris,id',
            'tanggal_kejadian' => 'required|date',
            'waktu_kejadian' => 'required',
            'alamat' => 'required|string|max:255',
            'urgensi' => 'required|in:rendah,sedang,tinggi',
            'anonim' => 'nullable|boolean',
            'foto_bukti' => 'nullable|array|max:3',
            'foto_bukti.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Combine date and time
        $waktuKejadian = \Carbon\Carbon::parse($validated['tanggal_kejadian'] . ' ' . $validated['waktu_kejadian']);

        // Set default kecamatan from user
        $kecamatan = auth()->user()->city ?? 'Tidak Diketahui';

        // Prepare photo path if any
        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')[0]->store('laporans', 'public');
        }

        // Create Laporan
        $laporan = \App\Models\Laporan::create([
            'user_id' => auth()->id(),
            'judul_laporan' => $validated['judul_laporan'],
            'deskripsi' => $validated['deskripsi'],
            'kategori_id' => $validated['kategori'],
            'kecamatan' => $kecamatan,
            'alamat' => $validated['alamat'],
            'waktu_kejadian' => $waktuKejadian,
            'status' => 'Menunggu',
            'urgensi' => ucfirst($validated['urgensi']),
            'is_anonim' => $request->has('anonim') ? true : false,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'foto' => $fotoPath,
        ]);

        // Save additional photos if multiple
        if ($request->hasFile('foto_bukti') && count($request->file('foto_bukti')) > 1) {
            $files = $request->file('foto_bukti');
            // We skip the first one since it's already saved in 'foto' column
            for ($i = 1; $i < count($files); $i++) {
                $path = $files[$i]->store('laporans', 'public');
                \DB::table('laporan_evidence')->insert([
                    'laporan_id' => $laporan->id,
                    'user_id' => auth()->id(),
                    'tipe_bukti' => 'Awal',
                    'foto_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->notificationDispatcher->notifyAdminsOnNewLaporan($laporan->fresh());

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim!');
    }

    public function show($id)
    {
        $laporan = \App\Models\Laporan::with([
            'kategori',
            'user',
            'instansi',
            'statusHistories',
            'upvotes',
            'komentars.user',
            'donasis',
            'evidenceLayers.user',
            'crowdVerifications.user',
        ])->findOrFail($id);
        
        $upvotesCount = $laporan->upvotes->count();

        // Total donasi
        $totalDonasi = $laporan->donasis->sum('jumlah');

        // Evidence stats
        $totalEvidences = $laporan->evidenceLayers->count();
        $uniqueContributors = $laporan->evidenceLayers->pluck('user_id')->unique()->filter()->count();
        $latestEvidence = $laporan->evidenceLayers->sortByDesc('created_at')->first();

        $crowdVerifications = $laporan->crowdVerifications;
        $crowdValidCount = $crowdVerifications->where('is_valid', true)->count();
        $crowdInvalidCount = $crowdVerifications->where('is_valid', false)->count();
        $userCrowdVerification = auth()->check() ? $crowdVerifications->firstWhere('user_id', auth()->id()) : null;
        
        // Ambil laporan terkait (berdasarkan kategori yang sama, maksimal 2)
        $relatedLaporans = \App\Models\Laporan::where('kategori_id', $laporan->kategori_id)
            ->where('id', '!=', $laporan->id)
            ->inRandomOrder()
            ->take(2)
            ->get();

        $evidenceLayers = $laporan->evidenceLayers;
        return view('user.laporan.show', compact(
            'laporan',
            'upvotesCount',
            'relatedLaporans',
            'totalDonasi',
            'totalEvidences',
            'uniqueContributors',
            'latestEvidence',
            'evidenceLayers',
            'crowdValidCount',
            'crowdInvalidCount',
            'userCrowdVerification',
        ));
    }

    public function user()
    {
        // Data for dropdowns
        $kategoris = \App\Models\Kategori::all();
        $lokasis = \App\Models\Laporan::select('kecamatan')
            ->distinct()
            ->whereNotNull('kecamatan')
            ->pluck('kecamatan');

        // Stats for current user's reports
        $totalLaporanku = \App\Models\Laporan::where('user_id', auth()->id())->count();
        $laporanDiproses = \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Diproses')->count();
        $laporanDitindaklanjuti = \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Ditindaklanjuti')->count();
        $laporanSelesai = \App\Models\Laporan::where('user_id', auth()->id())->where('status', 'Selesai')->count();

        // Start query for user's reports
        $query = \App\Models\Laporan::with(['kategori', 'upvotes', 'komentars'])
            ->where('user_id', auth()->id());

        // Filter: Search (Cari judul laporan, lokasi, atau kategori)
        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('judul_laporan', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function($qk) use ($search) {
                      $qk->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter: Status Penanganan
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        // Filter: Kategori Keluhan
        if (request()->filled('kategori')) {
            $query->where('kategori_id', request('kategori'));
        }

        // Filter: Lokasi (Kecamatan)
        if (request()->filled('lokasi')) {
            $query->where('kecamatan', request('lokasi'));
        }

        // Filter: Urutkan
        if (request()->filled('sort')) {
            if (request('sort') == 'terlama') {
                $query->orderBy('created_at', 'asc');
            } elseif (request('sort') == 'terpopuler') {
                $query->withCount('upvotes')->orderBy('upvotes_count', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $laporans = $query->paginate(10)->withQueryString();

        return view('user.laporan.user', compact(
            'laporans', 
            'kategoris', 
            'lokasis', 
            'totalLaporanku', 
            'laporanDiproses', 
            'laporanDitindaklanjuti', 
            'laporanSelesai'
        ));
    }

    public function public()
    {
        // Data for dropdowns
        $kategoris = \App\Models\Kategori::all();
        $lokasis = \App\Models\Laporan::select('kecamatan')->distinct()->whereNotNull('kecamatan')->pluck('kecamatan');

        // Start query
        $query = \App\Models\Laporan::with(['kategori', 'user', 'upvotes']);

        // Filter: Status Penanganan
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        } else {
            // Default public statuses
            $query->whereIn('status', ['Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai']);
        }

        // Filter: Kategori Keluhan
        if (request()->filled('kategori')) {
            $query->where('kategori_id', request('kategori'));
        }

        // Filter: Lokasi (Kecamatan)
        if (request()->filled('lokasi')) {
            $query->where('kecamatan', request('lokasi'));
        }

        // Filter: Urutkan
        if (request()->filled('sort')) {
            if (request('sort') == 'terlama') {
                $query->orderBy('created_at', 'asc');
            } elseif (request('sort') == 'terpopuler') {
                $query->withCount('upvotes')->orderBy('upvotes_count', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sort
            $query->orderBy('created_at', 'desc');
        }

        $laporans = $query->paginate(12)->withQueryString();

        return view('user.laporan.public', compact('laporans', 'kategoris', 'lokasis'));
    }
}
