<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Riwayat;
use App\Models\BukuAnak;
use App\Models\Historionline;
use App\Models\Member;
use App\Models\TransaksiDetail;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Menentukan tahun yang dipilih untuk peminjaman online dan offline, atau menggunakan tahun saat ini
        $tahunOnline = $request->input('tahun_online') ?? Carbon::now()->year;
        $tahunOffline = $request->input('tahun_offline') ?? Carbon::now()->year;
        
        // Hitung jumlah ebook yang sedang dipinjam (total semua peminjaman ebook) untuk tahun online
        $jumlahEbookDipinjam = Historionline::whereYear('tanggal_peminjaman', $tahunOnline)->count();
        $jumlahBukuTersedia = BukuAnak::where('status', 'tersedia')->count();
        $totalMember = Member::where('status', '!=', 'Pegawai')->count();
        $totalDenda = TransaksiDetail::where('status', 'Sudah Mengembalikan')->sum('denda');

        // Ambil jumlah peminjaman ebook per bulan untuk tahun online yang dipilih
        $peminjamanPerBulanOnline = Historionline::selectRaw('YEAR(tanggal_peminjaman) as year, MONTH(tanggal_peminjaman) as month, COUNT(*) as total')
            ->whereYear('tanggal_peminjaman', $tahunOnline)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Inisialisasi array untuk menyimpan data peminjaman online
        $peminjamanDataOnline = array_fill(0, 12, 0); // Buat array dengan 12 elemen, semuanya 0

        foreach ($peminjamanPerBulanOnline as $data) {
            $monthIndex = $data->month - 1;
            $peminjamanDataOnline[$monthIndex] = $data->total;
        }

        // Ambil jumlah peminjaman offline per bulan untuk tahun offline yang dipilih
        $peminjamanOfflinePerBulan = TransaksiDetail::selectRaw('YEAR(transaksi.tanggal_peminjaman) as year, MONTH(transaksi.tanggal_peminjaman) as month, COUNT(*) as total')
            ->join('bukuanak', 'transaksi_detail.id_buku_anak', '=', 'bukuanak.id_buku_anak')
            ->join('buku', 'bukuanak.id_buku_induk', '=', 'buku.id_buku_induk')
            ->join('transaksi', 'transaksi_detail.id_transaksi', '=', 'transaksi.id_transaksi')
            ->whereYear('transaksi.tanggal_peminjaman', $tahunOffline)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Inisialisasi data peminjaman offline
        $peminjamanOfflineData = array_fill(0, 12, 0); // Array 12 elemen (Januari-Desember)
        foreach ($peminjamanOfflinePerBulan as $data) {
            $monthIndex = $data->month - 1;
            $peminjamanOfflineData[$monthIndex] = $data->total;
        }

        $tahunTersediaOnline = Historionline::selectRaw('YEAR(tanggal_peminjaman) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray(); // Menjadi array

        $tahunTersediaOffline = TransaksiDetail::selectRaw('YEAR(transaksi.tanggal_peminjaman) as year')
            ->join('transaksi', 'transaksi.id_transaksi', '=', 'transaksi_detail.id_transaksi')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray(); // Menjadi array

        // Gabungkan kedua array dan hilangkan duplikat
        $tahunTersedia = array_unique(array_merge($tahunTersediaOnline, $tahunTersediaOffline));
        $tahunTersedia = array_values($tahunTersedia); // Reset index array


        return view('admin.dashboard', compact(
            'jumlahEbookDipinjam',
            'peminjamanDataOnline', // Online
            'peminjamanOfflineData', // Offline
            'jumlahBukuTersedia',
            'totalMember',
            'totalDenda',
            'tahunTersedia'
        ));
    }
}
