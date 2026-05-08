<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Dashboard Controller Class

    /**
     * Get all data for the dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $today = Carbon::today();

        if (auth()->check() && auth()->user()->role !== 'admin') {
            $laporanku = Laporan::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
            $totalLaporanku = $laporanku->count();
            $laporanSelesai = $laporanku->where('status', 'Selesai')->count();
            $laporanDiproses = $laporanku->whereIn('status', ['Menunggu', 'Diproses', 'Darurat', 'Ditindaklanjuti'])->count();
            return view('user.dashboard.index', compact('laporanku', 'totalLaporanku', 'laporanSelesai', 'laporanDiproses'));
        }

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
        $kategoriTerbanyak = Laporan::select('kategoris.nama as kategori', DB::raw('count(laporans.id) as total'))
            ->join('kategoris', 'laporans.kategori_id', '=', 'kategoris.id')
            ->groupBy('kategoris.nama')
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
        $startDate = Carbon::today()->subDays(6); // 7 days including today
        $trenData = Laporan::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $tren7Hari = collect();
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $tren7Hari->push((object)[
                'date' => $date,
                'total' => isset($trenData[$date]) ? $trenData[$date]->total : 0
            ]);
        }

        // 7. Latest Reports
        $laporanTerbaru = Laporan::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalLaporanHariIni',
            'menungguVerifikasi',
            'sedangDiproses',
            'ditindaklanjuti',
            'selesai',
            'laporanDarurat',
            'petaSebaran',
            'daftarDarurat',
            'kategoriTerbanyak',
            'kecamatanTerbanyak',
            'tren7Hari',
            'laporanTerbaru'
        ));
    }
}
