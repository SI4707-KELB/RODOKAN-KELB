<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function create()
    {
        return view('user.laporan.create');
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

        return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim!');
    }

    public function show($id)
    {
        $laporan = \App\Models\Laporan::with(['kategori', 'user', 'statusHistories', 'upvotes'])->findOrFail($id);
        
        $upvotesCount = $laporan->upvotes->count();
        
        // Ambil laporan terkait (berdasarkan kategori yang sama, maksimal 2)
        $relatedLaporans = \App\Models\Laporan::where('kategori_id', $laporan->kategori_id)
            ->where('id', '!=', $laporan->id)
            ->inRandomOrder()
            ->take(2)
            ->get();

        return view('user.laporan.show', compact('laporan', 'upvotesCount', 'relatedLaporans'));
    }

    public function user()
    {
        $laporans = \App\Models\Laporan::with('kategori')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.laporan.user', compact('laporans'));
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
