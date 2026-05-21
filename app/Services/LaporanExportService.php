<?php

namespace App\Services;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class LaporanExportService
{
    public function buildQuery(Request $request): Builder
    {
        $query = Laporan::with(['user', 'kategori']);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        return $query->orderByDesc('created_at');
    }

    public function exportCsv(Request $request): Response
    {
        $laporans = $this->buildQuery($request)->get();
        $csv = "ID,Judul,Pelapor,Email,Kategori,Kecamatan,Alamat,Status,Urgensi,Tanggal Dibuat,Catatan\n";

        foreach ($laporans as $laporan) {
            $csv .= $this->csvRow($laporan);
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="laporan_'.Carbon::now()->format('Y-m-d').'.csv"');
    }

    public function exportExcel(Request $request): Response
    {
        $laporans = $this->buildQuery($request)->get();

        $html = view('exports.laporan-excel', compact('laporans'))->render();

        return response($html, 200)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="laporan_'.Carbon::now()->format('Y-m-d').'.xls"');
    }

    public function exportPdf(Request $request): Response
    {
        $laporans = $this->buildQuery($request)->get();

        $pdf = Pdf::loadView('exports.laporan-pdf', [
            'laporans' => $laporans,
            'generatedAt' => Carbon::now()->format('d M Y H:i'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan_'.Carbon::now()->format('Y-m-d').'.pdf');
    }

    private function csvRow(Laporan $laporan): string
    {
        $row = [
            $laporan->id,
            $laporan->judul_laporan,
            $laporan->user->name ?? '-',
            $laporan->user->email ?? '-',
            $laporan->kategori->nama ?? '-',
            $laporan->kecamatan,
            $laporan->alamat ?? '-',
            $laporan->status,
            $laporan->urgensi,
            $laporan->created_at->format('Y-m-d H:i'),
            $laporan->catatan_verifikasi ?? '-',
        ];

        return '"'.implode('","', array_map(fn ($v) => str_replace('"', '""', (string) $v), $row))."\"\n";
    }
}
