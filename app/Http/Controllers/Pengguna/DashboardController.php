<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $buku = Buku::all(); // Ambil semua data buku
        $member = Member::where('id_user', Auth::id())->first();
        
        return view('pengguna.dashboard', compact('buku', 'member')); // Kirim data buku dan member ke view
    }
}
