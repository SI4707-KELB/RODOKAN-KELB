<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upvote;
use App\Models\Laporan;

class UpvoteController extends Controller
{
    public function toggle($id)
    {
        $laporan = Laporan::findOrFail($id);
        $user_id = auth()->id();

        $upvote = Upvote::where('laporan_id', $laporan->id)
            ->where('user_id', $user_id)
            ->first();

        if ($upvote) {
            // Jika sudah upvote, maka hapus (un-upvote)
            $upvote->delete();
            $message = 'Dukungan berhasil dibatalkan.';
        } else {
            // Jika belum upvote, maka tambahkan
            Upvote::create([
                'laporan_id' => $laporan->id,
                'user_id' => $user_id,
            ]);
            $message = 'Berhasil memberikan dukungan!';
        }

        return back()->with('success', $message);
    }
}
