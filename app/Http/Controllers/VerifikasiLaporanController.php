<?php

namespace App\Http\Controllers;

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

        // Calculate average verification time
        // avg(waktu_verifikasi - created_at)
        // Since sqlite or other DBs might not support raw time diff easily, we can use DB::raw or just simple avg if supported,
        // or calculate it in PHP for simplicity. Let's use raw query for standard SQL if possible, 
        // or calculate the average in hours from a subset of recent verifications.
        // For simplicity, we assume an approximation or just return a static/calculated value for demonstration.
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

        // Fetch reports based on tab (filter)
        $tab = $request->query('tab', 'menunggu'); // menunggu, terverifikasi, ditolak

        $query = Laporan::with(['user', 'admin'])->orderBy('created_at', 'desc');

        if ($tab === 'menunggu') {
            $query->where('status', 'Menunggu');
        } elseif ($tab === 'terverifikasi') {
            $query->whereIn('status', ['Terverifikasi', 'Diproses', 'Selesai']);
        } elseif ($tab === 'ditolak') {
            $query->where('status', 'Ditolak');
        }

        $laporans = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistik' => [
                    'menunggu_verifikasi' => $menungguVerifikasi,
                    'terverifikasi_hari_ini' => $terverifikasiHariIni,
                    'ditolak_hari_ini' => $ditolakHariIni,
                    'rata_rata_waktu_jam' => $rataRataWaktu,
                ],
                'laporans' => $laporans
            ]
        ]);
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
