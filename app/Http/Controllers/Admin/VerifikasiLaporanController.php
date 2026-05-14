<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\ValidasiLaporan;
use App\Services\ValidasiLaporanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerifikasiLaporanController extends Controller
{
    protected $validasiService;

    public function __construct(ValidasiLaporanService $validasiService)
    {
        $this->validasiService = $validasiService;
    }

    public function index(Request $request)
    {
        $today = Carbon::today();

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

        $totalMenunggu = $menungguVerifikasi;
        $totalTerverifikasi = Laporan::whereIn('status', ['Terverifikasi', 'Diproses', 'Selesai'])->count();
        $totalDitolak = Laporan::where('status', 'Ditolak')->count();

        $tab = $request->query('tab', 'menunggu');

        $query = Laporan::with(['user', 'admin', 'validasi'])->withCount(['upvotes', 'komentars'])->orderBy('created_at', 'desc');

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

            $laporan->upvotes = $laporan->upvotes_count ?? 0;
            $laporan->comments = $laporan->komentars_count ?? 0;
            $laporan->views = 0;

            if ($laporan->validasi) {
                $laporan->validasi_percentage = $laporan->validasi->getProgressPercentage();
            }

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

    public function show($id)
    {
        $laporan = Laporan::with(['kategori', 'user', 'statusHistories', 'komentars', 'upvotes', 'evidences', 'validasi'])
            ->findOrFail($id);

        if (!$laporan->validasi) {
            $validasi = $this->validasiService->performAutoValidation($laporan);
            $validasi->save();
            $laporan->validasi = $validasi;
        }

        $validasiReport = $this->validasiService->getValidationReport($laporan);

        return view('admin.verifikasi.show', compact('laporan', 'validasiReport'));
    }

    public function getValidasi($id)
    {
        $laporan = Laporan::with('validasi')->findOrFail($id);

        if (!$laporan->validasi) {
            $validasi = $this->validasiService->performAutoValidation($laporan);
            $validasi->save();
            $laporan->validasi = $validasi;
        }

        $report = $this->validasiService->getValidationReport($laporan);

        return response()->json([
            'status' => 'success',
            'data' => [
                'validasi' => $laporan->validasi,
                'report' => $report,
            ]
        ]);
    }

    public function updateValidasi(Request $request, $id)
    {
        $request->validate([
            'deskripsi_lengkap' => 'boolean',
            'foto_tersedia' => 'boolean',
            'lokasi_gps' => 'boolean',
            'lokasi_bandung' => 'boolean',
            'kategori_sesuai' => 'boolean',
            'tidak_duplikasi' => 'boolean',
            'foto_relevan' => 'boolean',
            'urgensi_sesuai' => 'boolean',
        ]);

        $laporan = Laporan::findOrFail($id);

        if (!$laporan->validasi) {
            $validasi = $this->validasiService->performAutoValidation($laporan);
            $validasi->save();
        } else {
            $validasi = $laporan->validasi;
        }

        $this->validasiService->updateValidasiManual($validasi, $request->all());

        return response()->json([
            'status' => 'success',
            'data' => $this->validasiService->getValidationReport($laporan),
        ]);
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'catatan_verifikasi' => 'nullable|string',
            'admin_id' => 'required|exists:users,id',
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

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
            'admin_id' => 'required|exists:users,id',
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

