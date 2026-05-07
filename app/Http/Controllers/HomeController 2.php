<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik
        $totalLaporan = Laporan::count();
        $responAlert = Laporan::whereIn('status', ['Darurat'])->orWhere('urgensi', 'Tinggi')->count();
        $terverifikasi = Laporan::where('status', 'Terverifikasi')->count();
        $dalamProses = Laporan::whereIn('status', ['Diproses', 'Ditindaklanjuti'])->count();

        // Trending Incidents (di sini kita simulasikan dengan mengambil laporan urgensi tinggi terbaru)
        $trendingIncidents = Laporan::with('kategori')->where('urgensi', 'Tinggi')
                                    ->orderBy('created_at', 'desc')
                                    ->take(3)
                                    ->get()
                                    ->map(function($laporan) {
                                        // Fake trending count for UI purposes
                                        $laporan->trending_count = rand(10, 50);
                                        return $laporan;
                                    });

        // Laporan Publik Terbaru
        $laporanTerbaru = Laporan::with('kategori')->orderBy('created_at', 'desc')
                                 ->take(3)
                                 ->get();

        // Peta Sebaran (contoh data marker)
        $laporanMap = Laporan::whereNotNull('latitude')
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
