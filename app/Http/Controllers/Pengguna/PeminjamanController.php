<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Historionline; // Ganti dengan model Historionline
use App\Models\Riwayat; // Tambahkan model Riwayat
use App\Models\Member; 
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Fungsi untuk meminjam ebook
    public function pinjamEbook(Request $request)
    {
        $user = Auth::user();
        $member = Member::where('id_user', $user->id_user)->first();
    
        // Hitung jumlah peminjaman aktif dari tabel Historionline
        $jumlahEbookDipinjam = Historionline::where('id_user', $user->id_user)->count();
    
        // Cek tingkatan member dan batas peminjaman
        if ($member && $member->tingkatan !== 'Pro' && $jumlahEbookDipinjam >= 10) {
            return redirect()->back()->with([
                'limitReached' => true,
                'error' => 'Batas maksimal pinjam untuk akun non-Pro adalah 10 ebook.'
            ]);
        }
    
        if (Historionline::where('id_buku_induk', $request->id_buku_induk)->exists()) 
            return redirect()->back()->with([
                'error' => 'Buku Sudah Dipinjam Sebelumnya.'
            ]);
        try {
            // Simpan data peminjaman ke tabel 'historionline' dengan transaksi
            DB::transaction(function () use ($request, $user) {
                $bukuInduk = Buku::findOrFail($request->id_buku_induk); // Gunakan findOrFail untuk validasi
                $tanggalSekarang = now();
            
                Historionline::create([
                    'id_user' => $user->id_user,
                    'id_buku_induk' => $bukuInduk->id_buku_induk,
                    'judul' => $bukuInduk->judul,
                    'kategori' => $bukuInduk->kategori->kategori,
                    'isbn' => $bukuInduk->ISBN,
                    'tanggal_peminjaman' => $tanggalSekarang,
                ]);
            
                // Jika tabel 'riwayat' juga ingin diisi, Anda dapat membuka komentar di bawah
                /*
                Riwayat::create([
                    'id_user' => $user->id_user,
                    'id_buku_induk' => $bukuInduk->id_buku_induk,
                    'judul' => $bukuInduk->judul,
                    'kategori' => $bukuInduk->kategori->kategori,
                    'isbn' => $bukuInduk->ISBN,
                    'tanggal_peminjaman' => $tanggalSekarang,
                ]);
                */
            });
        
            return redirect()->route('pengguna.ebook.read', $request->id_buku_induk);
        } catch (\Exception $e) {
            // Tangani error transaksi
            return redirect()->back()->with([
                'error' => 'Terjadi kesalahan saat meminjam ebook. Silakan coba lagi.'
            ]);
        }
    }

    // Fungsi untuk menghasilkan ID peminjaman
    private function generateIdPinjam()
    {
        return 'PNJ' . str_pad((Historionline::count() + 1), 3, '0', STR_PAD_LEFT); // Contoh format PNJ001
    }
}
