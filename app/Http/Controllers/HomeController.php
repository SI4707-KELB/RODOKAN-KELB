<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kategori;
use App\Services\BmkgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(BmkgService $bmkg)
    {
        // Statistik
        $totalLaporan = Laporan::count();
        $responAlert = Laporan::whereIn('status', ['Darurat'])->orWhere('urgensi', 'Tinggi')->count();
        $terverifikasi = Laporan::where('status', 'Terverifikasi')->count();
        $dalamProses = Laporan::whereIn('status', ['Diproses', 'Ditindaklanjuti'])->count();

        // Distribusi per Kategori
        $kategoriStats = Laporan::select('kategori_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_id')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                $kat = Kategori::find($item->kategori_id);
                return [
                    'nama' => $kat ? $kat->nama : 'Lainnya',
                    'total' => $item->total,
                ];
            });

        // Top Kecamatan
        $topKecamatan = Laporan::select('kecamatan', DB::raw('count(*) as total'))
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', 'Tidak Diketahui')
            ->where('kecamatan', '!=', '')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Laporan minggu ini vs minggu lalu
        $mingguIni = Laporan::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $mingguLalu = Laporan::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
        $trendMinggu = $mingguLalu > 0 ? round((($mingguIni - $mingguLalu) / $mingguLalu) * 100, 1) : 0;

        // Distribusi per hari minggu ini
        $mingguData = collect();
        $startWeek = Carbon::now()->startOfWeek();
        $hariIndo = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        for ($i = 0; $i < 7; $i++) {
            $tgl = $startWeek->copy()->addDays($i);
            $total = Laporan::whereDate('created_at', $tgl)->count();
            $mingguData->push([
                'hari' => $hariIndo[$i],
                'label' => $tgl->format('d/m'),
                'total' => $total,
            ]);
        }
        $maxMinggu = $mingguData->max('total') ?: 1;

        // Tingkat penyelesaian
        $totalValid = Laporan::where('status', '!=', 'Ditolak')->count();
        $totalSelesai = Laporan::where('status', 'Selesai')->count();
        $tingkatPenyelesaian = $totalValid > 0 ? round(($totalSelesai / $totalValid) * 100, 1) : 0;

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
            'cuaca',
            'kategoriStats',
            'topKecamatan',
            'mingguIni',
            'trendMinggu',
            'tingkatPenyelesaian',
            'mingguData',
            'maxMinggu'
        ));
    }
}
