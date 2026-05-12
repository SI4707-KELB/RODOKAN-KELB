<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerifikasiLaporanController extends Controller
{
    /**
     * Get data for verification page.
     */
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Stats
        $menungguVerifikasi = Laporan::where('status', 'Menunggu')->count();
        $terverifikasiHariIni = Laporan::whereIn('status', ['Terverifikasi', 'Diproses', 'Selesai'])
            ->whereDate('waktu_verifikasi', $today)
            ->count();
        $ditolakHariIni = Laporan::where('status', 'Ditolak')
            ->whereDate('waktu_verifikasi', $today)
            ->count();

        $recentVerifications = Laporan::whereNotNull('waktu_verifikasi')
            ->orderBy('waktu_verifikasi', 'desc')
            ->take(100)
            ->get();
        
        $totalHours = 0;
        $count = 0;
        foreach($recentVerifications as $laporan) {
            $hours = $laporan->created_at->diffInHours($laporan->waktu_verifikasi);
            $totalHours += $hours;
            $count++;
        }
        $rataRataWaktu = $count > 0 ? round($totalHours / $count, 1) : 0;

        // Calculate totals for tabs
        $totalMenunggu = $menungguVerifikasi;
        $totalTerverifikasi = Laporan::whereIn('status', ['Terverifikasi', 'Diproses', 'Selesai'])->count();
        $totalDitolak = Laporan::where('status', 'Ditolak')->count();

        // Fetch reports based on tab (filter)
        $tab = $request->query('tab', 'menunggu'); // menunggu, terverifikasi, ditolak

        $query = Laporan::with(['user', 'admin'])->withCount(['upvotes', 'komentars'])->orderBy('created_at', 'desc');

        if ($tab === 'menunggu') {
            $query->where('status', 'Menunggu');
        } elseif ($tab === 'terverifikasi') {
            $query->whereIn('status', ['Terverifikasi', 'Diproses', 'Selesai']);
        } elseif ($tab === 'ditolak') {
            $query->where('status', 'Ditolak');
        }

        $laporans = $query->paginate(10);

        $laporans->getCollection()->transform(function ($laporan) {
            $catClass = 'badge-category';
            $catName = $laporan->kategori->nama ?? 'Umum';
            
            if (stripos($catName, 'Infrastruktur') !== false) $catClass .= ' infrastruktur';
            elseif (stripos($catName, 'Bencana') !== false) $catClass .= ' bencana';
            elseif (stripos($catName, 'Pelayanan') !== false) $catClass .= ' pelayanan';

            $laporan->catClass = $catClass;
            $laporan->catName = $catName;

            $laporan->urgencyClass = 'badge-urgency ' . strtolower($laporan->urgensi ?? 'low');
            
            $borderClass = 'border-menunggu';
            if (in_array($laporan->status, ['Terverifikasi', 'Diproses', 'Selesai'])) {
                $borderClass = 'border-terverifikasi';
            } elseif ($laporan->status === 'Ditolak') {
                $borderClass = 'border-ditolak';
            }
            $laporan->borderClass = $borderClass;

            // Real stats from database
            $laporan->upvotes = $laporan->upvotes_count ?? 0;
            $laporan->comments = $laporan->komentars_count ?? 0;
            $laporan->views = 0; // Views not tracked in db yet

            return $laporan;
        });

        return view('admin.verifikasi.index', compact(
            'menungguVerifikasi',
            'terverifikasiHariIni',
            'ditolakHariIni',
            'rataRataWaktu',
            'totalMenunggu',
            'totalTerverifikasi',
            'totalDitolak',
            'laporans',
            'tab'
        ));
    }

    /**
     * Show detail verification page for a report
     */
    public function show($id)
    {
        $laporan = Laporan::with(['kategori', 'user', 'statusHistories', 'komentars', 'upvotes', 'evidences'])
            ->findOrFail($id);

        return view('admin.verifikasi.show', compact('laporan'));
    }

    /**
     * Verify a report
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'catatan_verifikasi' => 'nullable|string',
            'admin_id' => 'required|exists:users,id', // or get from auth()->id() if authentication is implemented
        ]);

        $laporan = Laporan::findOrFail($id);

        if ($laporan->status !== 'Menunggu') {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan tidak dalam status Menunggu Verifikasi'
            ], 400);
        }

        $laporan->update([
            'status' => 'Terverifikasi',
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'admin_id' => $request->admin_id,
            'waktu_verifikasi' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil diverifikasi',
            'data' => $laporan
        ]);
    }

    /**
     * Reject a report
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
            'admin_id' => 'required|exists:users,id', // or get from auth()->id()
        ]);

        $laporan = Laporan::findOrFail($id);

        if ($laporan->status !== 'Menunggu') {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan tidak dalam status Menunggu Verifikasi'
            ], 400);
        }

        $laporan->update([
            'status' => 'Ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'admin_id' => $request->admin_id,
            'waktu_verifikasi' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil ditolak',
            'data' => $laporan
        ]);
    }
}
