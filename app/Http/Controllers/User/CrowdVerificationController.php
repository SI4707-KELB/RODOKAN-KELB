<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CrowdVerification;
use App\Models\Laporan;
use Illuminate\Http\Request;

class CrowdVerificationController extends Controller
{
    public function store(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->user_id === auth()->id()) {
            return redirect()->route('laporan.show', $laporan->id)
                ->with('error', 'Anda tidak dapat memvalidasi laporan sendiri.');
        }

        $validated = $request->validate([
            'is_valid' => 'required|boolean',
            'komentar' => 'nullable|string|max:500',
        ]);

        CrowdVerification::updateOrCreate(
            [
                'laporan_id' => $laporan->id,
                'user_id' => auth()->id(),
            ],
            [
                'is_valid' => $validated['is_valid'],
                'komentar' => $validated['komentar'] ?? null,
            ]
        );

        return redirect()->route('laporan.show', $laporan->id)->with('success', 'Terima kasih, verifikasi Anda tersimpan.');
    }
}
