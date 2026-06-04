<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class PengaturanController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('laporans')->orderBy('laporans_count', 'desc')->get();

        return view('admin.pengaturan.index', compact('kategoris'));
    }
}
