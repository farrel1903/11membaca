<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Historionline; // Menggunakan model historionline
use App\Models\Member;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil data member berdasarkan user yang sedang login
        $member = Member::where('id_user', Auth::id())->first();

        $user = Auth::user();

        // Ambil riwayat peminjaman yang masih aktif untuk pengguna saat ini
        $riwayat = Historionline::where('id_user', $user->id_user)->get();

        // Hitung jumlah peminjaman aktif
        $jumlahEbookDipinjam = $riwayat->count();

        // Kirim data ke view riwayat
        return view('pengguna.riwayat', compact('riwayat', 'jumlahEbookDipinjam', 'member'));
    }

// Fungsi untuk meminjam ebook
// public function pinjamEbook(Request $request)
// {
//     $user = Auth::user();
//     $member = Member::where('id_user', $user->id_user)->first();

//     // Hitung jumlah peminjaman aktif dari tabel Historionline
//     $jumlahEbookDipinjam = Historionline::where('id_user', $user->id_user)->count();

//     // Cek tingkatan member
//     if ($member->tingkatan !== 'Pro' && $jumlahEbookDipinjam >= 10) {
//         // Jika member bukan "Pro" dan sudah mencapai batas, berikan pesan peringatan
//         return redirect()->back()->with(['limitReached' => true, 'error' => 'Batas maksimal pinjam untuk akun non-Pro adalah 10 ebook.']);
//     }

//     // Simpan data peminjaman ke tabel 'historionline' dan 'riwayat' dengan transaksi
//     DB::transaction(function () use ($request, $user) {
//         $idPinjam = $this->generateIdPinjam();

//         Historionline::create([
//             'id_pinjam' => $idPinjam,
//             'id_user' => $user->id_user,
//             'id_buku_induk' => $request->id_buku_induk,
//             'judul' => $request->judul,
//             'kategori' => $request->kategori,
//             'isbn' => $request->isbn,
//             'tanggal_pinjam' => now(),
//         ]);

//         Riwayat::create([
//             'id_pinjam' => $idPinjam,
//             'id_user' => $user->id_user,
//             'id_buku_induk' => $request->id_buku_induk,
//             'judul' => $request->judul,
//             'kategori' => $request->kategori,
//             'isbn' => $request->isbn,
//             'tanggal_pinjam' => now(),
//         ]);
//     });

//     return redirect()->back()->with('success', 'Ebook berhasil dipinjam.');
// }



    // Fungsi untuk generate ID peminjaman otomatis seperti PNJ001
    private function generateIdPinjam()
    {
        // Kunci eksklusif untuk memastikan tidak ada konflik pada saat generate ID
        $lastPinjam = Historionline::lockForUpdate()->orderBy('id_pinjam', 'desc')->first(); // Ganti Riwayat dengan Historionline

        if ($lastPinjam) {
            // Ambil angka terakhir dari id_pinjam
            $lastNumber = (int) substr($lastPinjam->id_pinjam, 3);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada peminjaman, mulai dari 1
            $newNumber = 1;
        }

        // Gabungkan prefix "PNJ" dengan angka baru dan tambahkan leading zeroes
        return 'PNJ' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function destroy($id_pinjam)
    {
        // Cari data peminjaman berdasarkan id_pinjam
        $riwayat = Historionline::where('id_pinjam', $id_pinjam)->first();

        // Cek apakah peminjaman ditemukan
        if (!$riwayat) {
            return redirect()->back()->with('error', 'Riwayat peminjaman tidak ditemukan.');
        }


        // Hapus peminjaman
        $riwayat->delete();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('peminjamanonline')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }


    public function peminjamanOnline()
    {
        // Ambil semua data riwayat peminjaman
        $riwayat = Historionline::all(); // Ganti Riwayat dengan Historionline
        $riwayat->transform(function ($item) {
            $item->tanggal_pinjam = Carbon::parse($item->tanggal_pinjam)->format('d-m-Y');
            return $item;
        });
        // Kirim data ke view peminjamanonline
        return view('admin.peminjamanonline', compact('riwayat'));
    }

    public function search(Request $request)
    {
        // Ambil input pencarian dan filter dari query string
        $search = $request->input('search');
        $filter = $request->input('filter');

        // Mengambil riwayat peminjaman berdasarkan pencarian dengan filter
        $riwayat = Historionline::where($filter, 'LIKE', '%' . $search . '%')->get();

        // Hitung jumlah peminjaman aktif
        $jumlahEbookDipinjam = $riwayat->count();

        // Kirim data ke view riwayat
        return view('admin.peminjamanonline', compact('riwayat', 'jumlahEbookDipinjam'));
    }


    public function show($id)
    {
        // Ambil data peminjaman berdasarkan ID
        $riwayat = Historionline::findOrFail($id); // Ganti Riwayat dengan Historionline

        // Kirim data ke view
        return view('pengguna.riwayat_show', compact('riwayat'));
    }
}
