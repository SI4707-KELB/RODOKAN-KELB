<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvidenceRequest;
use App\Models\Evidence;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreEvidenceRequest $request, $laporanId)
    {
        $laporan = Laporan::findOrFail($laporanId);

        $file = $request->file('file');
        $path = $file->store('evidences', 'public');

        $evidence = Evidence::create([
            'report_id' => $laporan->id,
            'user_id' => auth()->id(),
            'evidence_type' => $request->input('evidence_type'),
            'file_path' => $path,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('laporan.show', $laporan->id)->with('success', 'Bukti berhasil diunggah.');
    }

    public function destroy(Request $request, $laporanId, $evidenceId)
    {
        $evidence = Evidence::findOrFail($evidenceId);
        $laporan = Laporan::findOrFail($laporanId);

        // Authorization: uploader or admin
        if (auth()->id() !== $evidence->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Delete file
        if ($evidence->file_path && Storage::disk('public')->exists($evidence->file_path)) {
            Storage::disk('public')->delete($evidence->file_path);
        }

        $evidence->delete();

        return redirect()->route('laporan.show', $laporan->id)->with('success', 'Bukti berhasil dihapus.');
    }
}
