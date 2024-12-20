<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuAnak;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuAnakController extends Controller
{
    // Menampilkan daftar buku anak dalam bentuk tabel
    public function index()
    {
        $bukuanak = BukuAnak::with('buku')->get();
        return view('admin.bukuanak', ['bukuanak' => $bukuanak]);
    }

    // Menampilkan form untuk menambahkan buku anak baru
    public function create()
    {
        $buku = Buku::all(); // Mengambil semua buku induk
        return view('admin.addbukuanak', ['buku' => $buku]);
    }

    // Menyimpan buku anak baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'id_buku_induk' => 'required|string|max:255',
            'status' => 'required|in:tersedia,dipinjam',
        ]);

        // Ambil judul buku dari Buku berdasarkan id_buku_induk
        $buku = Buku::find($request->id_buku_induk);
        if (!$buku) {
            return redirect()->back()->withErrors(['id_buku_induk' => 'Buku induk tidak ditemukan.']);
        }

        // Ambil nomor terakhir dari buku anak yang ada untuk buku induk yang sama
        $lastBukuAnak = BukuAnak::where('id_buku_induk', $request->id_buku_induk)
            ->orderBy('id_buku_anak', 'desc')
            ->first();

        $lastNumber = 1;
        if ($lastBukuAnak) {
            $lastNumber = (int) substr($lastBukuAnak->id_buku_anak, -3) + 1;
        }

        // Format ID Buku Anak dengan ID Buku Induk
        $idBukuAnak = sprintf('%s-%03d', $request->id_buku_induk, $lastNumber);

        // Simpan data buku anak
        BukuAnak::create([
            'id_buku_anak' => $idBukuAnak,
            'id_buku_induk' => $request->id_buku_induk,
            'judul' => $buku->judul, // Isi judul secara otomatis dari model Buku
            'status' => $request->status,
        ]);

        return redirect()->route('bukuanak.index')->with('success', 'Buku anak berhasil ditambahkan.');
    }

    // Menghapus buku anak dari database
    public function destroy($id)
    {
        BukuAnak::findOrFail($id)->delete();
        return redirect()->route('bukuanak.index')->with('success', 'Buku anak berhasil dihapus.');
    }

    // Menambahkan fungsi search untuk mencari buku anak
    public function search(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Ambil parameter pencarian
        $search = $request->input('search');

        // Mencari buku anak berdasarkan id_buku_anak, id_buku_induk, atau status
        $bukuanak = BukuAnak::when($search, function ($query, $search) {
            return $query->where('id_buku_anak', 'like', '%' . $search . '%')
                ->orWhere('id_buku_induk', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        })->get();

        return view('admin.bukuanak', ['bukuanak' => $bukuanak]);
    }
}
