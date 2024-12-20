<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\BukuTerakhirDibaca;
use App\Models\Member;
use App\Models\Riwayat; // Gunakan model Riwayat
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EbookReadController extends Controller
{
    public function read($id)
    {
        $buku = Buku::find($id);
        $member = Member::where('id_user', Auth::id())->first();

        if (!$buku) {
            return redirect()->route('pengguna.produk.index')->with('error', 'Buku tidak ditemukan.');
        }

        $riwayat = Riwayat::where('id_buku_induk', $id)
                          ->where('id_user', Auth::id())
                          ->first();

        if (!$riwayat) {
            return redirect()->route('pengguna.produk.index')->with('error', 'Anda harus meminjam ebook ini terlebih dahulu sebelum membacanya.');
        }

        // Ambil halaman terakhir yang dibaca oleh user
        $bukuTerakhirDibaca = BukuTerakhirDibaca::where('id_user', Auth::user()->id_user)
        ->where('id_buku', $buku->id_buku_induk)
        ->first();

        // Jika ada, gunakan halaman terakhir yang dibaca, jika tidak, mulai dari halaman 1
        $halamanTerakhir = $bukuTerakhirDibaca ? $bukuTerakhirDibaca->halaman_terakhir : 1;

        return view('pengguna.read', compact('buku', 'member', 'riwayat', 'halamanTerakhir'));
    }

    public function saveLastPage(Request $request)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();
    
        // Validasi input 'page' dan pastikan 'id_buku' ada di query string atau body
        $validated = $request->validate([
            'page' => 'required|integer|min:1',
        ]);
    
        $bukuId = $request->query('id_buku') ?? $request->input('id_buku'); // Mengambil id_buku dari query atau body
    
        // Cek apakah sudah ada data untuk buku ini
        $bukuTerakhirDibaca = BukuTerakhirDibaca::where('id_user', $user->id_user)  // Perbaiki ke $user->id
            ->where('id_buku', $bukuId)
            ->first();
    
        // Cek apakah halaman terakhir yang dikirim berbeda dari yang disimpan
        if ($bukuTerakhirDibaca) {
            if ($bukuTerakhirDibaca->halaman_terakhir != $validated['page']) {
                // Update halaman terakhir yang dibaca jika berbeda
                $bukuTerakhirDibaca->halaman_terakhir = $validated['page'];
                $bukuTerakhirDibaca->save();
            }
        } else {
            BukuTerakhirDibaca::create([
                'id_user' => $user->id_user,  // Gunakan $user->id
                'id_buku' => $bukuId,
                'halaman_terakhir' => $validated['page'],
            ]);
        }
    
        // Kembalikan respon JSON
        return response()->json(['message' => 'Halaman terakhir berhasil disimpan.', 'halamanTerakhir' => $validated['page']]);
    }
}
