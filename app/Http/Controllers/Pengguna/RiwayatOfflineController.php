<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\BukuAnak;
use App\Models\JenisDenda;
use App\Models\Categories;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use App\Models\Member;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RiwayatOfflineController extends Controller
{
    // Menampilkan semua detail transaksi
    public function showDetail()
    {
        $member = Member::find(Auth::user()->member->nis_nik);
        $transaksi = Transaksi::with('transaksiDetail')->where('nis_nik', Auth::user()->member->nis_nik)->pluck('id_transaksi');
        $transaksiDetail = TransaksiDetail::whereIn('id_transaksi', $transaksi)->get();
        // Inisialisasi total denda
        $totalDenda = 0;

        // Iterasi setiap transaksiDetail dan jumlahkan denda
        // foreach ($transaksi->transaksiDetail as $detail) {
        //     $totalDenda += $detail->denda; // Tambahkan denda pada total
        // }
        $jenisDenda = JenisDenda::all(); // Menambahkan jenis denda

        return view('pengguna.history', compact('member', 'transaksi', 'transaksiDetail', 'totalDenda', 'jenisDenda'));
    }
}
