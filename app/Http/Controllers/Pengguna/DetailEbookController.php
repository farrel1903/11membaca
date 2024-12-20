<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Member;
use App\Models\PeminjamanOffline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DetailEbookController extends Controller
{
    // Menampilkan detail buku dalam bentuk card
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        $member = Member::where('id_user', Auth::id())->first();
        return view('pengguna.detailebook', compact('buku', 'member'));
    }

    public function pinjam($id)
{
    $buku = Buku::findOrFail($id);

    // Logika untuk peminjaman offline
    // Misalnya, Anda bisa membuat entri baru di tabel peminjaman atau melakukan apa pun yang diperlukan
    $peminjaman = new PeminjamanOffline();
    $peminjaman->user_id = Auth::id(); // ID pengguna yang meminjam
    $peminjaman->buku_id = $buku->id; // ID buku yang dipinjam
    // Tambahkan atribut lain yang diperlukan di sini
    $peminjaman->save(); // Simpan peminjaman ke database

    return redirect()->route('pengguna.buku.index')->with('success', 'Buku berhasil dipinjam secara offline.');
}

}
