<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Get all data for the dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $today = Carbon::today();

        // 1. Summary Statistics
        $totalLaporanHariIni = Laporan::whereDate('created_at', $today)->count();
        $menungguVerifikasi = Laporan::where('status', 'Menunggu')->count();
        $sedangDiproses = Laporan::where('status', 'Diproses')->count();
        $ditindaklanjuti = Laporan::where('status', 'Ditindaklanjuti')->count();
        $selesai = Laporan::where('status', 'Selesai')->count();
        $laporanDarurat = Laporan::where('status', 'Darurat')->count();

        // 2. Data for Map
        $petaSebaran = Laporan::select('id', 'judul_laporan', 'status', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // 3. Emergency Reports (Latest)
        $daftarDarurat = Laporan::where('status', 'Darurat')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 4. Top Categories
        $kategoriTerbanyak = Laporan::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 5. Top Districts (Kecamatan)
        $kecamatanTerbanyak = Laporan::select('kecamatan', DB::raw('count(*) as total'))
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 6. Trend over last 7 days
        $tren7Hari = Laporan::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // 7. Latest Reports
        $laporanTerbaru = Laporan::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistik' => [
                    'total_hari_ini' => $totalLaporanHariIni,
                    'menunggu_verifikasi' => $menungguVerifikasi,
                    'sedang_diproses' => $sedangDiproses,
                    'ditindaklanjuti' => $ditindaklanjuti,
                    'selesai' => $selesai,
                    'laporan_darurat' => $laporanDarurat,
                ],
                'peta_sebaran' => $petaSebaran,
                'daftar_darurat' => $daftarDarurat,
                'kategori_terbanyak' => $kategoriTerbanyak,
                'kecamatan_terbanyak' => $kecamatanTerbanyak,
                'tren_7_hari' => $tren7Hari,
                'laporan_terbaru' => $laporanTerbaru,
            ]
        ]);
    }
}
