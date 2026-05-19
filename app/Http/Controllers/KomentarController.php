<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;
use App\Models\Laporan;

class KomentarController extends Controller
{
    public function store(Request $request, $laporan_id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $laporan = Laporan::findOrFail($laporan_id);

        Komentar::create([
            'laporan_id' => $laporan->id,
            'user_id' => auth()->id(),
            'isi_komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
