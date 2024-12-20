<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Historionline; 
use App\Models\Buku;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HistoriOnlineController extends Controller
{
    // Fungsi untuk menampilkan semua riwayat peminjaman
    public function index()
    {
        $member = Member::where('id_user', Auth::id())->first();
    
        // Mengambil semua data dari tabel historionline milik user yang sedang login, diurutkan dari terbaru ke terlama
        $history = Historionline::with('buku')
                    ->where('id_user', Auth::id()) // Menambahkan filter untuk id_user
                    ->orderBy('tanggal_peminjaman', 'desc')
                    ->get();
    
        return view('pengguna.history', compact('history', 'member')); // Menampilkan ke view history.blade.php
    }
    

    // Fungsi untuk menyimpan riwayat peminjaman ebook
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

        // Menyimpan riwayat peminjaman
        $history = new Historionline(); 
        $history->id_pinjam = $this->generateIdPinjam(); 
        $history->id_buku_induk = $request->id_buku_induk;
        $history->id_user = $request->id_user;
        $history->judul = $buku->judul; 
        $history->kategori = $buku->kategori; 
        $history->isbn = $buku->isbn; 
        $history->tanggal_peminjaman = Carbon::parse($request->tanggal_peminjaman);
        $history->save();

        return redirect()->back()->with('success', 'Riwayat peminjaman berhasil disimpan!');
    }

    // Fungsi untuk menampilkan detail riwayat peminjaman tertentu
    public function show($id_pinjam)
    {
        $history = Historionline::where('id_pinjam', $id_pinjam)->firstOrFail();
        return view('history_detail', compact('history')); // Menampilkan detail riwayat ke history_detail.blade.php
    }

    // Fungsi untuk menghapus riwayat peminjaman
    public function destroy($id_pinjam)
    {
        $history = Historionline::where('id_pinjam', $id_pinjam)->firstOrFail();
        $history->delete();

        return redirect()->back()->with('success', 'Riwayat peminjaman berhasil dihapus!');
    }

    // Fungsi untuk generate ID peminjaman
    private function generateIdPinjam()
    {
        return 'PNJ' . str_pad((Historionline::count() + 1), 3, '0', STR_PAD_LEFT);
    }
}