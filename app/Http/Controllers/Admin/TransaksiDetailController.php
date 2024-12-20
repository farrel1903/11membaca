<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use App\Models\BukuAnak;
use App\Models\Buku;
use App\Models\Categories;
use App\Models\JenisDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TransaksiDetailController extends Controller
{
    // Menampilkan daftar transaksi dengan pencarian
    public function index(Request $request)
    {
        $query = Transaksi::query();
    
        if ($request->filled('filter') && $request->filled('search')) {
            $filter = $request->input('filter');
            $search = $request->input('search');
    
            switch ($filter) {
                case 'id_transaksi':
                    $query->where('id_transaksi', $search);
                    break;
                case 'nis_nik':
                    $query->where('nis_nik', $search);
                    break;
                case 'tanggal_peminjaman':
                    $query->whereDate('tanggal_peminjaman', $search);
                    break;
            }
        }
    
        $transaksis = $query->with('transaksiDetail')->paginate(10);
        $totalDenda = $this->calculateTotalDenda(); // Tambahkan total denda jika diperlukan
    
        return view('admin.peminjamanoffline', compact('transaksis', 'totalDenda'))
            ->with('filter', $request->input('filter'))
            ->with('search', $request->input('search'));
    }
    

    // Menampilkan semua detail transaksi
    public function showDetail($id)
    {
        $transaksi = Transaksi::with('transaksiDetail')->find($id);
        $transaksiDetail = $transaksi->transaksiDetail;
        // Inisialisasi total denda
        $totalDenda = 0;

        // Iterasi setiap transaksiDetail dan jumlahkan denda
        foreach ($transaksi->transaksiDetail as $detail) {
            $totalDenda += $detail->denda; // Tambahkan denda pada total
        }
        $jenisDenda = JenisDenda::where('jenis_denda', '!=', 'Terlambat')->get(); // Menambahkan jenis denda
    
        return view('admin.transaksi', compact('transaksi', 'transaksiDetail', 'totalDenda', 'jenisDenda'));
    }
    
    

    public function show(string $id_transaksi)
    {
        $transaksi = TransaksiDetail::where('id_transaksi', $id_transaksi)->first();
        $transaksiDetail = TransaksiDetail::where('id_transaksi', $id_transaksi)->get();
        $jenisDenda = JenisDenda::all();
        $denda = $transaksiDetail->pluck('denda');
        $totalDenda = $denda->sum();

        return view('admin.transaksi', compact('transaksiDetail', 'totalDenda', 'transaksi', 'jenisDenda'));
    }

    // Menghitung total denda semua transaksi
    public function calculateTotalDenda()
    {
        $totalDenda = TransaksiDetail::where('status', 'Sudah Mengembalikan')->sum('denda');
        return $totalDenda;
    }

    public function showTransaksi()
    {
        $transaksiDetail = TransaksiDetail::all();
        $totalDenda = $this->calculateTotalDenda();
        $jenisDenda = JenisDenda::all();
        $transaksi = null;
    
        return view('admin.transaksi', compact('transaksiDetail', 'totalDenda', 'jenisDenda', 'transaksi'));
    }
    

    // Menghapus transaksi dari database
    public function destroy($id)
    {
        // Temukan transaksi berdasarkan ID
        $transaksi = Transaksi::with('transaksiDetail')->findOrFail($id);

        // Kembalikan status buku anak terkait dengan transaksi
        foreach ($transaksi->transaksiDetail as $detail) {
            $bukuAnak = BukuAnak::findOrFail($detail->id_buku_anak);
            $bukuAnak->update(['status' => 'tersedia']);
        }

        // Hapus transaksi dan detailnya
        $transaksi->transaksiDetail()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }


    public function return(Request $request)
    {
        // Validasi form
        $request->validate([
            'id_transaksi' => 'required|exists:transaksi,id_transaksi',
            'tanggal_pengembalian' => 'required|date',
            'jenis_denda' => 'required|exists:jenis_denda,id_jenis_denda',
            'buku_ids' => 'required|array',
        ]);
    
        // Mendapatkan transaksi_detail berdasarkan id_transaksi dan id_buku_anak
        foreach ($request->buku_ids as $buku_id) {
            $id_buku = explode(',', $buku_id);
            foreach ($id_buku as $id) {
                $bukuAnak = BukuAnak::find($id)->id_buku_induk;
                $transaksi = Transaksi::find($request->id_transaksi)->tanggal_pengembalian;
                $keterlambatan = Carbon::parse($transaksi)->diffInDays(Carbon::parse($request->tanggal_pengembalian), false);
                $denda = $this->hitungDenda($request->jenis_denda, $bukuAnak, $keterlambatan);
                TransaksiDetail::where('id_transaksi', $request->id_transaksi)
                                                  ->where('id_buku_anak', $id)
                                                  ->update([
                                                    'tanggal_pengembalian_buku' => $request->tanggal_pengembalian,
                                                    'status' => 'Sudah Mengembalikan',
                                                    'denda' => $denda,
                                                    'id_jenis_denda' => $request->jenis_denda,
                                                  ]);
            
                // Update buku yang dikembalikan
                $buku = BukuAnak::find($id);
                if ($buku) {
                    $buku->status = 'tersedia'; // Atau status yang sesuai
                    $buku->save();
                }
            }
        }
        
        return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dikembalikan.');
    }
    

    public function hitungDenda($jenisDenda, $idBukuInduk, $jumlahHariTerlambat)
    {
        $denda = 0;
        $jenisDenda = JenisDenda::find($jenisDenda)->jenis_denda;
        $buku = Buku::where('id_buku_induk', $idBukuInduk)->first();

        if ($jumlahHariTerlambat > 0) {
            // $denda += $buku->kategori->harga_keterlambatan * $jumlahHariTerlambat; //jika denda bertambah
            $denda = $buku->kategori->harga_keterlambatan * $jumlahHariTerlambat;
        }
    
        if ($jenisDenda == 'Hilang' || $jenisDenda == 'Buku Rusak') {
            // $denda += $buku->harga; //jika denda bertambah
            $denda = $buku->harga;

        }
    
        return $denda;
    }
    
}

