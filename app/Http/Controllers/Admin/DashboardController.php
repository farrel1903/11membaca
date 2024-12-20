<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Riwayat;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahEbookDipinjam = Riwayat::count();
        return view('dashboard');
    }
}
