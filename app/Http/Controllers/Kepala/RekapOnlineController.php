<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatExport;

class RekapOnlineController extends Controller
{
    // Menampilkan halaman rekap peminjaman online ebook
    public function rekapOnline(Request $request)
    {
        // Ambil bulan dari request, jika kosong tampilkan data keseluruhan
        $bulan = $request->get('bulan');
    
        // Kondisi untuk menampilkan total peminjaman sepanjang masa jika 'total' dipilih
        if ($bulan == 'total') {
            $totalPeminjaman = Riwayat::count(); // Menghitung seluruh peminjaman tanpa filter
        } else {
            $totalPeminjaman = Riwayat::whereMonth('tanggal_peminjaman', $bulan)->count(); // Peminjaman berdasarkan bulan
        }
    
        return view('kepala.rekaponline', compact('totalPeminjaman'));
    }
    

    // Menangani ekspor data rekap peminjaman ebook
    public function exportRekapOnline(Request $request)
    {
        // Ekspor seluruh data peminjaman, tanpa filter bulan
        return Excel::download(new RiwayatExport(), 'Rekap_Peminjaman_Ebook.xlsx');
    }
}
