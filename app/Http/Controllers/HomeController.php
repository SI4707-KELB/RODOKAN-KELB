<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Services\BmkgService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(BmkgService $bmkg)
    {
        // Statistik
        $totalLaporan = Laporan::count();
        $responAlert = Laporan::whereIn('status', ['Darurat'])->orWhere('urgensi', 'Tinggi')->count();
        $terverifikasi = Laporan::where('status', 'Terverifikasi')->count();
        $dalamProses = Laporan::whereIn('status', ['Diproses', 'Ditindaklanjuti'])->count();

        // Trending Incidents (berdasarkan upvotes terbanyak)
        $trendingIncidents = Laporan::with(['kategori', 'upvotes'])->where('urgensi', 'Tinggi')
                                    ->withCount(['upvotes', 'komentars'])
                                    ->orderBy('upvotes_count', 'desc')
                                    ->take(3)
                                    ->get();

        // Laporan Publik Terbaru
        $laporanTerbaru = Laporan::with(['kategori', 'upvotes'])->withCount(['upvotes', 'komentars'])->orderBy('created_at', 'desc')
                                 ->take(3)
                                 ->get();

        // Peta Sebaran
        $laporanMap = Laporan::with('kategori')
                             ->whereNotNull('latitude')
                             ->whereNotNull('longitude')
                             ->get();

        // BMKG Data
        $gempa = $bmkg->getLatestEarthquake();
        $cuaca = $bmkg->getWeather();

        return view('welcome', compact(
            'totalLaporan',
            'responAlert',
            'terverifikasi',
            'dalamProses',
            'trendingIncidents',
            'laporanTerbaru',
            'laporanMap',
            'gempa',
            'cuaca'
        ));
    }
}
