<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $laporanClass = \App\Models\Laporan::class;

        if (!file_exists(app_path('Models/Laporan.php')) || !class_exists($laporanClass)) {
            return view('welcome', [
                'totalLaporan' => 0,
                'responAlert' => 0,
                'terverifikasi' => 0,
                'dalamProses' => 0,
                'trendingIncidents' => collect(),
                'laporanTerbaru' => collect(),
                'laporanMap' => collect(),
            ]);
        }

        // Statistik
        $totalLaporan = $laporanClass::count();
        $responAlert = $laporanClass::whereIn('status', ['Darurat'])->orWhere('urgensi', 'Tinggi')->count();
        $terverifikasi = $laporanClass::where('status', 'Terverifikasi')->count();
        $dalamProses = $laporanClass::whereIn('status', ['Diproses', 'Ditindaklanjuti'])->count();

        // Trending Incidents (berdasarkan upvotes terbanyak)
        $trendingIncidents = $laporanClass::with('kategori')->where('urgensi', 'Tinggi')
                                    ->withCount(['upvotes', 'komentars'])
                                    ->orderBy('upvotes_count', 'desc')
                                    ->take(3)
                                    ->get();

        // Laporan Publik Terbaru
        $laporanTerbaru = $laporanClass::with('kategori')->withCount(['upvotes', 'komentars'])->orderBy('created_at', 'desc')
                                 ->take(3)
                                 ->get();

        // Peta Sebaran
        $laporanMap = $laporanClass::with('kategori')
                             ->whereNotNull('latitude')
                             ->whereNotNull('longitude')
                             ->get();

        return view('welcome', compact(
            'totalLaporan',
            'responAlert',
            'terverifikasi',
            'dalamProses',
            'trendingIncidents',
            'laporanTerbaru',
            'laporanMap'
        ));
    }
}
