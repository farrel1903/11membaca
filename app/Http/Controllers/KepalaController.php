<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\BukuAnak;
use App\Models\Historionline;
use App\Models\Member;

class KepalaController extends Controller
{
    /**
     * Menampilkan halaman dashboard kepala.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Hitung jumlah ebook yang sedang dipinjam
        $jumlahEbookDipinjam = Historionline::count();
        $jumlahBukuTersedia = BukuAnak::where('status', 'tersedia')->count();
        $totalMember = Member::where('status', '!=', 'Pegawai')->count();
    
        // Ambil jumlah peminjaman ebook per bulan
        $peminjamanPerBulan = Historionline::selectRaw('YEAR(tanggal_peminjaman) as year, MONTH(tanggal_peminjaman) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    
        // Inisialisasi array untuk menyimpan data peminjaman
        $peminjamanData = array_fill(0, 12, 0); // Buat array dengan 12 elemen, semuanya 0
    
        foreach ($peminjamanPerBulan as $data) {
            // Menghitung bulan dan index
            $monthIndex = $data->month - 1; // Mengubah bulan menjadi index (0-11)
            // Mengisi data peminjaman
            $peminjamanData[$monthIndex] = $data->total;
        }
    
        // Debugging: Periksa nilai yang diambil
        // dd($jumlahEbookDipinjam, $jumlahBukuTersedia, $totalMember, $peminjamanData);
    
        return view('kepala.dashboard', compact('jumlahEbookDipinjam', 'peminjamanData', 'jumlahBukuTersedia', 'totalMember'));
    }
    
}
