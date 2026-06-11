<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Laporan;
use App\Services\NotificationDispatcherService;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function __construct(
        protected NotificationDispatcherService $notificationDispatcher,
    ) {}

    public function store(Request $request, $laporan_id)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $laporan = Laporan::findOrFail($laporan_id);

        $komentar = Komentar::create([
            'laporan_id' => $laporan->id,
            'user_id' => auth()->id(),
            'isi_komentar' => $request->komentar,
        ]);

        $this->notificationDispatcher->notifyAdminsOnKomentar($komentar);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
