<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Buku;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_pinjam' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'judul_buku' => 'required|string'
        ]);

        // Simpan rating ke database
        Rating::create([
            'id_pinjam' => $request->id_pinjam,
            'rating' => $request->rating,
            'judul_buku' => $request->judul_buku,
        ]);

        return response()->json(['success' => true]);
    }
}