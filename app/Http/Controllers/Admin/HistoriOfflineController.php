<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Historioffline;
use App\Models\Buku;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoriOfflineController extends Controller
{
    // Fungsi untuk menampilkan semua riwayat peminjaman offline
    public function index()
    {
        $member = Member::where('id_user', Auth::id())->first();

        // Mengambil semua data dari tabel historioffline milik user yang sedang login, diurutkan dari terbaru ke terlama
        $history = Historioffline::with('buku')
            ->where('id_user', Auth::id()) // Menambahkan filter untuk id_user
            ->orderBy('tanggal_peminjaman', 'desc')
            ->get();

        return view('pengguna.history_offline', compact('history', 'member')); // Menampilkan ke view history_offline.blade.php
    }

    // Fungsi untuk menyimpan riwayat peminjaman offline
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_buku_induk' => 'required|exists:buku,id_buku_induk',
            'id_user' => 'required|exists:users,id',
            'tanggal_peminjaman' => 'required|date',
        ]);

        // Mendapatkan data buku
        $buku = Buku::find($request->id_buku_induk);

        // Menyimpan riwayat peminjaman offline
        $history = new Historioffline();
        $history->id_pinjam = $this->generateIdPinjam();
        $history->id_buku_induk = $request->id_buku_induk;
        $history->id_user = $request->id_user;
        $history->judul = $buku->judul;
        $history->kategori = $buku->kategori;
        $history->isbn = $buku->isbn;
        $history->tanggal_peminjaman = Carbon::parse($request->tanggal_peminjaman);
        $history->tanggal_pengembalian = null; // Set null jika tidak ada tanggal pengembalian saat penyimpanan
        $history->save();

        return redirect()->back()->with('success', 'Riwayat peminjaman offline berhasil disimpan!');
    }

    // Fungsi untuk menampilkan detail riwayat peminjaman offline tertentu
    public function show($id_pinjam)
    {
        $history = Historioffline::where('id_pinjam', $id_pinjam)->firstOrFail();
        return view('history_offline_detail', compact('history')); // Menampilkan detail riwayat ke history_offline_detail.blade.php
    }

    // Fungsi untuk menghapus riwayat peminjaman offline
    public function destroy($id_pinjam)
    {
        $history = Historioffline::where('id_pinjam', $id_pinjam)->firstOrFail();
        $history->delete();

        return redirect()->back()->with('success', 'Riwayat peminjaman offline berhasil dihapus!');
    }

    // Fungsi untuk mengembalikan buku
    public function returnBook(Request $request, $id_pinjam)
    {
        // Validasi input
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
        ]);

        // Mencari riwayat peminjaman berdasarkan id_pinjam
        $history = Historioffline::where('id_pinjam', $id_pinjam)->firstOrFail();

        // Mengupdate tanggal pengembalian
        $history->tanggal_pengembalian = Carbon::parse($request->tanggal_pengembalian);
        $history->save();

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    // Fungsi untuk generate ID peminjaman
    private function generateIdPinjam()
    {
        $randomString = strtoupper(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3)); // Menghasilkan 3 huruf acak
        return 'PNJ' . str_pad((Historioffline::count() + 1), 3, '0', STR_PAD_LEFT) . $randomString; // Menggabungkan dengan angka dan huruf acak
    }
}
