<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Historioffline;
use App\Models\Categories;
use App\Models\Rak;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan daftar buku dalam bentuk tabel dengan sorting
    public function index(Request $request)
    {
        $sort_by = $request->input('sort_by', 'judul'); // Default sorting by 'judul'
        $sort_direction = $request->input('sort_direction', 'asc'); // Default sorting direction is 'asc'

        // Mengambil semua data buku tanpa pagination Laravel
        $buku = Buku::orderBy($sort_by, $sort_direction)->get();

        return view('admin.buku', ['buku' => $buku, 'sort_by' => $sort_by, 'sort_direction' => $sort_direction]);
    }

    // Menampilkan form untuk menambahkan buku baru
    public function create()
    {
        $categories = Categories::all();
        $rak = Rak::all();
        return view('admin.addbuku', ['categories' => $categories, 'rak' => $rak]);
    }

    // Menyimpan buku baru ke database
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'id_buku_induk' => 'required|string|max:255',
            'id_rak' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required',
            'ISBN' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'sinopsis' => 'nullable|string',
            'jumlah_halaman' => 'required|integer',
            'jumlah_buku' => 'required|integer', // Validasi jumlah total buku
            'harga' => 'required|numeric', // Validasi harga
            'status' => 'required|string|in:full,offline,online', // Validasi status
            'sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $buku = new Buku();
        $buku->id_buku_induk = $request->id_buku_induk;
        $buku->id_rak = $request->id_rak;
        $buku->judul = $request->judul;
        $buku->kategori_id = $request->kategori_id;
        $buku->ISBN = $request->ISBN;
        $buku->Penulis = $request->Penulis;
        $buku->Penerbit = $request->Penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->sinopsis = $request->sinopsis;
        $buku->jumlah_halaman = $request->jumlah_halaman;
        $buku->jumlah_buku = $request->jumlah_buku; // Simpan jumlah total buku
        $buku->harga = $request->harga; // Simpan harga
        $buku->status = $request->status; // Simpan status

        if ($request->hasFile('sampul')) {
            $filename = $request->file('sampul')->getClientOriginalName();
            $request->file('sampul')->move(public_path('fotobuku'), $filename);
            $buku->sampul = $filename;
        }

        if ($request->hasFile('ebook')) {
            $filename = $request->file('ebook')->getClientOriginalName();
            $request->file('ebook')->move(public_path('ebook_pdf'), $filename);
            $buku->ebook = $filename;
        }

        $buku->stok = $this->calculateStok($buku); // Hitung stok berdasarkan jumlah buku yang tersedia
        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambah');
    }


    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku', compact('buku'));
    }

    // Menampilkan form untuk mengedit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $categories = Categories::all();
        $rak = Rak::all();
        return view('admin.editbuku', compact('buku', 'categories', 'rak'));
    }

    // Memperbarui data buku yang sudah ada
    public function update(Request $request, $id_buku)
    {
        // $request->validate([
        //     'id_buku_induk' => 'required|string|max:255',
        //     'id_rak' => 'required|string|max:255',
        //     'judul' => 'required|string|max:255',
        //     'kategori_id' => 'required|exists:categories,kategori_id',
        //     'ISBN' => 'required|string|max:255',
        //     'Penulis' => 'required|string|max:255',
        //     'Penerbit' => 'required|string|max:255',
        //     'tahun_terbit' => 'required|digits:4',
        //     'sinopsis' => 'nullable|string',
        //     'jumlah_halaman' => 'required|integer',
        //     'jumlah_buku' => 'required|integer', // Validasi jumlah total buku
        //     'harga' => 'required|numeric', // Validasi harga
        //     'status' => 'required|string|in:full,offline,online', // Validasi status
        //     'sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        // ]);

        $buku = Buku::findOrFail($id_buku);
        $buku->id_buku_induk = $request->id_buku_induk;
        $buku->id_rak = $request->id_rak;
        $buku->judul = $request->judul;
        $buku->kategori_id = $request->kategori_id;
        $buku->ISBN = $request->ISBN;
        $buku->Penulis = $request->Penulis;
        $buku->Penerbit = $request->Penerbit;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->sinopsis = $request->sinopsis;
        $buku->jumlah_halaman = $request->jumlah_halaman;
        $buku->jumlah_buku = $request->jumlah_buku; // Update jumlah total buku
        $buku->harga = $request->harga; // Update harga
        $buku->status = $request->status; // Update status

        if ($request->hasFile('sampul')) {
            if ($buku->sampul && file_exists(public_path('fotobuku/' . $buku->sampul))) {
                unlink(public_path('fotobuku/' . $buku->sampul));
            }
            $filename = $request->file('sampul')->getClientOriginalName();
            $request->file('sampul')->move(public_path('fotobuku'), $filename);
            $buku->sampul = $filename;
        }

        if ($request->hasFile('ebook')) {
            if ($buku->ebook && file_exists(public_path('ebook_pdf/' . $buku->ebook))) {
                unlink(public_path('ebook_pdf/' . $buku->ebook));
            }
            $filename = $request->file('ebook')->getClientOriginalName();
            $request->file('ebook')->move(public_path('ebook_pdf'), $filename);
            $buku->ebook = $filename;
        }

        $buku->stok = $this->calculateStok($buku); // Hitung stok ulang saat diperbarui
        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Buku Berhasil Diperbarui');
    }


    // Menghapus buku
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file yang terkait dengan buku sebelum menghapus entri dari database
        if ($buku->sampul && file_exists(public_path('fotobuku/' . $buku->sampul))) {
            unlink(public_path('fotobuku/' . $buku->sampul));
        }
        if ($buku->ebook && file_exists(public_path('ebook_pdf/' . $buku->ebook))) {
            unlink(public_path('ebook_pdf/' . $buku->ebook));
        }

        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }

    // Fungsi pencarian buku dengan filter
    public function search(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter'); // Ambil filter dari request
        $sort_by = $request->input('sort_by', 'judul'); // Default sorting by 'judul'
        $sort_direction = $request->input('sort_direction', 'asc'); // Default sorting direction is 'asc'

        // Membuat query dasar
        $query = Buku::query();

        // Menambahkan kondisi pencarian berdasarkan filter yang dipilih
        if ($filter === 'judul') {
            $query->where('judul', 'like', "%$search%");
        } elseif ($filter === 'id_buku_induk') {
            $query->where('id_buku_induk', 'like', "%$search%");
        } elseif ($filter === 'kategori') {
            $query->whereHas('kategori', function ($q) use ($search) {
                $q->where('kategori', 'like', "%$search%");
            });
        }

        // Menambahkan pengurutan
        $bukus = $query->orderBy($sort_by, $sort_direction)->get();

        return view('admin.buku', [
            'buku' => $bukus,
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction
        ]);
    }

    // Metode untuk menghitung stok yang tersedia
    private function calculateStok($buku)
    {
        // Hitung jumlah peminjaman offline yang aktif untuk buku ini
        $jumlahDipinjam = Historioffline::where('id_buku_induk', $buku->id_buku_induk)
            ->whereNull('tanggal_pengembalian') // Menghitung peminjaman yang masih aktif
            ->count();

        // Stok = jumlah_buku - jumlah yang sedang dipinjam
        return $buku->jumlah_buku - $jumlahDipinjam;
    }
}
