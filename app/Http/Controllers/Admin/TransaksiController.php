<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi
    public function index(Request $request)
    {
        // Ambil input pencarian dan filter jika ada
        $search = $request->input('search');
        $filter = $request->input('filter');

        // Membuat query untuk mengambil transaksi
        $query = Transaksi::with('transaksiDetail');

        // Jika ada input pencarian
        if ($request->filled('search') && $request->filled('filter')) {
            $query->where($filter, 'like', '%' . $search . '%');
        }

        // Mengambil semua transaksi beserta detailnya
        $transaksi = $query->get();

        // Kembalikan view dengan data transaksi
        return view('admin.peminjamanoffline', ['transaksi' => $transaksi]);
    }


    // Menampilkan form untuk menambahkan transaksi
    public function create()
    {
        $bukuAnak = BukuAnak::where('status', 'tersedia')->get(); // Mengambil buku anak dengan status 'tersedia'
        $members = Member::where('status', '!=', 'Pegawai')->get();
        return view('admin.addpeminjamanoffline', ['bukuAnak' => $bukuAnak, 'members' => $members]);
    }

    // Menghasilkan id_transaksi secara otomatis
    private function generateIdTransaksi()
    {
        $lastTransaksi = Transaksi::orderBy('id_transaksi', 'desc')->first();
        if ($lastTransaksi) {
            $lastId = intval(substr($lastTransaksi->id_transaksi, 3));
            $newId = sprintf('TRX%03d', $lastId + 1);
        } else {
            $newId = 'TRX001';
        }

        return $newId;
    }

    // Menyimpan transaksi ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_buku_anak.*' => 'required|string|max:255',
            'nis_nik' => 'required|string|max:50',
        ]);

        // Buat transaksi baru
        $transaksi = Transaksi::create([
            'id_transaksi' => $this->generateIdTransaksi(),
            'nis_nik' => $request->nis_nik,
            'tanggal_peminjaman' => Carbon::now(),
            'tanggal_pengembalian' => null, // Atur ke null terlebih dahulu
        ]);

        // Looping untuk menyimpan setiap detail transaksi
        foreach ($request->id_buku_anak as $index => $idBukuAnak) {
            if (empty($idBukuAnak)) {
                return redirect()->back()->withErrors(['msg' => 'ID Buku Anak tidak boleh kosong.']);
            }

            // Coba ambil buku anak
            $bukuAnak = \App\Models\BukuAnak::find($idBukuAnak);

            // Cek apakah buku anak ditemukan
            if (!$bukuAnak) {
                return redirect()->back()->withErrors(['msg' => 'Buku Anak tidak ditemukan.']);
            }

            // Ambil kategori buku
            $kategori = \App\Models\Categories::find($bukuAnak->buku->kategori_id); // Ambil kategori buku

            // Pengecekan status buku
            // return $bukuAnak->buku->kategori_id;
            if ($bukuAnak->status === 'tersedia') {
                // Update status buku anak menjadi 'dipinjam'
                $bukuAnak->update(['status' => 'dipinjam']);

                // Hitung tanggal pengembalian berdasarkan waktu_peminjaman dari kategori
                if ($kategori) {
                    $tanggalPengembalian = Carbon::now()->addDays($kategori->waktu_peminjaman);
                } else {
                    return redirect()->back()->withErrors(['msg' => 'Kategori tidak ditemukan untuk buku ini.']);
                }

                // return $tanggalPengembalian;
                // Tambahkan detail transaksi
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_buku_anak' => $idBukuAnak,
                    'judul' => $bukuAnak->judul, // Pastikan untuk menyimpan judul
                    'denda' => 0,
                    // 'tanggal_pengembalian_buku' => $tanggalPengembalian,
                    'id_jenis_denda' => null,
                    'status' => 'Belum Mengembalikan',
                ]);

                // Update tanggal pengembalian transaksi
                $transaksi->tanggal_pengembalian = $tanggalPengembalian;
                $transaksi->save(); // Simpan perubahan transaksi
            } else {
                return redirect()->back()->withErrors(['msg' => 'Buku sudah dipinjam.']);
            }
        }
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }



    // Menampilkan daftar transaksi dengan pencarian
    public function search(Request $request)
    {
        $query = Transaksi::query();

        // Memeriksa apakah ada filter dan kata kunci pencarian
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
                    $query->whereDate('tanggal_peminjaman', $search); // Pastikan format tanggal sesuai
                    break;
            }
        }

        // Mengambil data transaksi dengan pagination
        $transaksis = $query->with('transaksiDetail')->paginate(10); // Ubah jumlah per halaman sesuai kebutuhan

        // Kembali ke view dengan data yang dibutuhkan
        return view('admin.peminjamanoffline', compact('transaksis'))
            ->with('filter', $request->input('filter'))
            ->with('search', $request->input('search'));
    }







    // Menghitung waktu peminjaman dan denda
    private function calculateDenda($tanggalPeminjaman, $tanggalPengembalian, $idBuku, $idJenisDenda)
    {
        $daysLate = Carbon::parse($tanggalPengembalian)->diffInDays(Carbon::parse($tanggalPeminjaman));

        $buku = Buku::with('kategori')->findOrFail($idBuku);

        // Periksa jenis denda
        $hargaDenda = 0;
        if ($idJenisDenda == 1) { // Denda karena rusak/hilang
            $hargaDenda = $buku->harga; // Asumsi denda sesuai harga buku
        } else { // Denda keterlambatan
            $hargaDenda = $buku->kategori->harga_keterlambatan;
        }

        return $daysLate * $hargaDenda;
    }


    public function export()
    {
        return Excel::download(new TransaksiExport, 'rekap_peminjaman_offline.xlsx');
    }
}
