<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1000',
            'pesan' => 'nullable|string|max:500',
        ]);

        $laporan = \App\Models\Laporan::findOrFail($id);

        $donasi = \App\Models\Donasi::create([
            'laporan_id' => $laporan->id,
            'user_id' => auth()->id(),
            'jumlah' => $validated['jumlah'],
            'pesan' => $validated['pesan'] ?? null,
            'status' => 'Berhasil',
            'metode_pembayaran' => 'Manual',
        ]);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Terima kasih! Donasi Anda telah dicatat.');
    }
}
