<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\BukuAnak;
use App\Models\Member;
use App\Models\TransaksiDetail;
use App\Models\Categories;
use App\Models\Historionline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Impor kelas DB

class PenggunaController extends Controller
{
    /**
     * Menampilkan halaman dashboard pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil member yang terautentikasi
        $member = Member::where('id_user', Auth::id())->first();
        $categories = Categories::all();

        // Ambil 10 buku teratas untuk ebook
        $bukuOnline = Buku::whereNotNull('ebook') // Hanya buku yang memiliki ebook
            ->withCount('riwayat')
            ->orderBy('riwayat_count', 'desc')
            ->take(10)
            ->get();

        // Ambil data peminjaman per ebook dan ambil 10 teratas
        $riwayatPerBuku = Historionline::select('id_buku_induk', DB::raw('COUNT(*) as total'))
            ->groupBy('id_buku_induk')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                // Ambil judul buku berdasarkan id_buku_induk
                $buku = Buku::find($item->id_buku_induk);
                return [
                    'judul' => $buku ? $buku->judul : 'Tidak Diketahui',
                    'total' => $item->total,
                ];
            });

        // Ambil 10 buku yang memiliki peminjaman (yang pernah dipinjam)
        $buku = Buku::whereHas('riwayat') // Hanya buku yang memiliki peminjaman di riwayat
            ->with('kategori') // Relasi kategori
            ->withCount('riwayat') // Menghitung jumlah peminjaman
            ->orderBy('riwayat_count', 'desc') // Urutkan berdasarkan jumlah peminjaman terbanyak
            ->take(10) // Batasi hanya 10 buku
            ->get();

        // Hitung total peminjaman untuk persentase
        $totalOnline = $bukuOnline->sum('riwayat_count');
        // $totalOffline = $bukuOffline->sum('riwayat_count');



        // Ambil data untuk grafik offline berdasarkan peminjaman
        $bukuOffline = TransaksiDetail::join('bukuanak', 'transaksi_detail.id_buku_anak', '=', 'bukuanak.id_buku_anak')
            ->join('buku', 'bukuanak.id_buku_induk', '=', 'buku.id_buku_induk')
            ->where('bukuanak.status', 'dipinjam')
            ->select('buku.judul', DB::raw('COUNT(transaksi_detail.id_buku_anak) as riwayat_count'))
            ->groupBy('buku.id_buku_induk', 'buku.judul')
            ->orderByDesc('riwayat_count')
            ->get();


        $bookBorrowData = TransaksiDetail::select('bukuanak.id_buku_induk', DB::raw('count(*) as total_peminjaman'))
            ->join('bukuanak', 'transaksi_detail.id_buku_anak', '=', 'bukuanak.id_buku_anak')  // Join dengan tabel BukuAnak
            ->join('buku', 'bukuanak.id_buku_induk', '=', 'buku.id_buku_induk')  // Join dengan tabel Buku
            ->groupBy('bukuanak.id_buku_induk')  // Group berdasarkan id_buku_induk
            ->orderBy('bukuanak.id_buku_induk')  // Mengurutkan berdasarkan id_buku_induk
            ->get();
    
        // Menyiapkan data untuk pie chart
        $pieChartData = [];
    
        foreach ($bookBorrowData as $data) {
            // Mengambil judul buku berdasarkan id_buku_induk
            $book = Buku::find($data->id_buku_induk);
    
            // Pastikan buku ditemukan sebelum mengambil judulnya
            if ($book) {
                $pieChartData[] = [
                    'label' => $book->judul,  // Nama buku
                    'value' => $data->total_peminjaman  // Jumlah peminjaman
                ];
            }
        }

        // Kembalikan view dengan variabel yang diperlukan
        return view('pengguna.dashboard', [
            'buku' => $buku, // Buku yang paling sering dipinjam
            'bukuOnline' => $bukuOnline,
            'bukuOffline' => $bukuOffline,
            'totalOnline' => $totalOnline,
            'kategori' => $categories,
            'riwayatPerBuku' => $riwayatPerBuku, // Tambahkan riwayat peminjaman per buku
            'member' => $member, // Tambahkan member ke dalam array
            'pieChartData' => $pieChartData, //peminjaman offline
        ]);
    }
}
