<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class DetailBukuController extends Controller
{
    // Menampilkan detail buku dalam bentuk card
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.detailbuku', compact('buku'));
    }
}
