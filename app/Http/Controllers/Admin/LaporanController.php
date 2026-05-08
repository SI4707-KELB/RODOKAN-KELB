<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of all reports for admin.
     */
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'admin', 'kategori']);

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_laporan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by kecamatan (district)
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        // Filter by urgency
        if ($request->filled('urgensi')) {
            $query->where('urgensi', $request->urgensi);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $laporans = $query->paginate(15);

        // Get filter options
        $statuses = ['Menunggu', 'Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $kategoris = Kategori::all();
        $kecamatan = Laporan::select('kecamatan')->distinct()->whereNotNull('kecamatan')->pluck('kecamatan');
        $urgencies = ['Rendah', 'Sedang', 'Tinggi', 'Darurat'];

        // Statistics
        $stats = [
            'total' => Laporan::count(),
            'menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'terverifikasi' => Laporan::where('status', 'Terverifikasi')->count(),
            'diproses' => Laporan::where('status', 'Diproses')->count(),
            'ditindaklanjuti' => Laporan::where('status', 'Ditindaklanjuti')->count(),
            'selesai' => Laporan::where('status', 'Selesai')->count(),
            'ditolak' => Laporan::where('status', 'Ditolak')->count(),
        ];

        return view('admin.laporan.index', compact('laporans', 'statuses', 'kategoris', 'kecamatan', 'urgencies', 'stats'));
    }

    /**
     * Display the specified report in detail.
     */
    public function show($id)
    {
        $laporan = Laporan::with(['user', 'admin', 'kategori'])->findOrFail($id);
        $statuses = ['Menunggu', 'Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];

        return view('admin.laporan.show', compact('laporan', 'statuses'));
    }

    /**
     * Show the form for editing a report's status and notes.
     */
    public function edit($id)
    {
        $laporan = Laporan::with(['user', 'admin'])->findOrFail($id);
        $statuses = ['Menunggu', 'Terverifikasi', 'Diproses', 'Ditindaklanjuti', 'Selesai', 'Ditolak'];
        $admins = User::where('role', 'admin')->get();

        return view('admin.laporan.edit', compact('laporan', 'statuses', 'admins'));
    }

    /**
     * Update the specified report in storage.
     */
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Terverifikasi,Diproses,Ditindaklanjuti,Selesai,Ditolak',
            'catatan_verifikasi' => 'nullable|string|max:500',
            'alasan_penolakan' => 'nullable|string|max:500',
            'admin_id' => 'nullable|exists:users,id',
        ]);

        $oldStatus = $laporan->status;
        $laporan->update($validated);

        // Update waktu_verifikasi if status changed and it's first verification
        if ($oldStatus === 'Menunggu' && $laporan->status !== 'Menunggu') {
            $laporan->update(['waktu_verifikasi' => Carbon::now()]);
        }

        return redirect()->route('admin.laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil diperbarui');
    }

    /**
     * Delete the specified report.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil dihapus');
    }

    /**
     * Bulk update reports status.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:laporans,id',
            'status' => 'required|in:Menunggu,Terverifikasi,Diproses,Ditindaklanjuti,Selesai,Ditolak',
        ]);

        Laporan::whereIn('id', $validated['ids'])->update([
            'status' => $validated['status'],
            'waktu_verifikasi' => Carbon::now(),
            'admin_id' => auth()->id(),
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui secara massal');
    }

    /**
     * Get statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total' => Laporan::count(),
            'hari_ini' => Laporan::whereDate('created_at', Carbon::today())->count(),
            'menunggu' => Laporan::where('status', 'Menunggu')->count(),
            'terverifikasi' => Laporan::where('status', 'Terverifikasi')->count(),
            'diproses' => Laporan::where('status', 'Diproses')->count(),
            'ditindaklanjuti' => Laporan::where('status', 'Ditindaklanjuti')->count(),
            'selesai' => Laporan::where('status', 'Selesai')->count(),
            'ditolak' => Laporan::where('status', 'Ditolak')->count(),
            'darurat' => Laporan::where('urgensi', 'Darurat')->count(),
        ];

        // Top categories
        $topKategori = Laporan::select('kategoris.nama', DB::raw('count(laporans.id) as total'))
            ->join('kategoris', 'laporans.kategori_id', '=', 'kategoris.id')
            ->groupBy('kategoris.nama')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Top districts
        $topKecamatan = Laporan::select('kecamatan', DB::raw('count(*) as total'))
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Trend last 7 days
        $tren = Laporan::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'statistik' => $stats,
                'top_kategori' => $topKategori,
                'top_kecamatan' => $topKecamatan,
                'tren_7_hari' => $tren,
            ]
        ]);
    }

    /**
     * Export reports to CSV.
     */
    public function export(Request $request)
    {
        $query = Laporan::with(['user', 'kategori']);

        // Apply same filters as index
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        $laporans = $query->get();

        $csv = "ID,Judul,Pelapor,Email,Kategori,Kecamatan,Status,Urgensi,Tanggal Dibuat,Catatan\n";

        foreach ($laporans as $laporan) {
            $csv .= "\"{$laporan->id}\"";
            $csv .= ",\"" . str_replace('"', '""', $laporan->judul_laporan) . "\"";
            $csv .= ",\"" . str_replace('"', '""', $laporan->user->name ?? '-') . "\"";
            $csv .= ",\"" . ($laporan->user->email ?? '-') . "\"";
            $csv .= ",\"" . str_replace('"', '""', $laporan->kategori->nama ?? '-') . "\"";
            $csv .= ",\"{$laporan->kecamatan}\"";
            $csv .= ",\"{$laporan->status}\"";
            $csv .= ",\"{$laporan->urgensi}\"";
            $csv .= ",\"{$laporan->created_at->format('Y-m-d H:i')}\"";
            $csv .= ",\"" . str_replace('"', '""', $laporan->catatan_verifikasi ?? '-') . "\"";
            $csv .= "\n";
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="laporan_' . Carbon::now()->format('Y-m-d') . '.csv"');
    }
}
