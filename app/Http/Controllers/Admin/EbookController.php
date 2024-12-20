<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Ebook;
use Illuminate\Http\Request;

class EbookController extends Controller
{
    public function index()
    {
        $ebook = Ebook::all();
        return view('admin.ebook', ['ebook' => $ebook]);
    }


    public function create()
    {
        return view('admin.addebook');
    }

    public function ebook()
    {
        // Mengambil semua kategori dan mengirimkannya ke view
        $ebook = Ebook::all();
        return view('admin.ebook', ['ebook' => $ebook]);
    }

    public function fetchEbook()
    {
        // Mengambil semua kategori dan mengembalikannya dalam format JSON
        $ebook = Ebook::all();
        return response()->json(['ebook' => $ebook], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku_induk' => 'required|string|max:255',
            'id_rak' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|integer',
            'ISBN' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $ebook = new Ebook();
        $ebook->kode_buku = $request->kode_buku;
        $ebook->nama = $request->nama;
        $ebook->kategori_id = $request->kategori;
        $ebook->ISBN = $request->ISBN;
        $ebook->Penulis = $request->Penulis;
        $ebook->Penerbit = $request->Penerbit;
        $ebook->Deskripsi = $request->Deskripsi;
        $ebook->stok = $request->stok;

        if ($request->hasFile('foto')) {
            $filename = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('fotobuku'), $filename);
            $ebook->foto = $filename;
        }

        $ebook->save();

        return redirect()->route('ebooks.index')->with('success', 'Buku Berhasil Ditambah');
    }


    public function category2()
    {
        $category = Categories::all();
        return view('admin.addebook', ['category' => $category]);
    }

    public function show(string $id)
    {
        // Menampilkan detail kategori berdasarkan ID
        $ebook = Ebook::findOrFail($id);
        return view('admin.show_ebook', ['ebook' => $ebook]);
    }

    public function edit($id)
    {
        $ebook = Ebook::findOrFail($id);
        $category = Categories::all();
        return view('admin.editebook', ['ebook' => $ebook, 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_buku' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|integer',
            'ISBN' => 'required|string|max:255',
            'Penulis' => 'required|string|max:255',
            'Penerbit' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $ebook = Ebook::findOrFail($id);
        $ebook->kode_buku = $request->kode_buku;
        $ebook->nama = $request->nama;
        $ebook->kategori_id = $request->kategori;
        $ebook->ISBN = $request->ISBN;
        $ebook->Penulis = $request->Penulis;
        $ebook->Penerbit = $request->Penerbit;
        $ebook->Deskripsi = $request->Deskripsi;
        $ebook->stok = $request->stok;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($ebook->foto && file_exists(public_path('fotobuku/' . $ebook->foto))) {
                unlink(public_path('fotobuku/' . $ebook->foto));
            }
            $filename = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('fotobuku'), $filename);
            $ebook->foto = $filename;
        }

        $ebook->save();

        return redirect()->route('ebooks.index')->with('success', 'Buku Berhasil Diperbarui');
    }

    public function destroy(string $id)
    {
        $ebook = Ebook::findOrFail($id);
        $ebook->delete();
        return redirect()->route('ebooks.index')->with('success', 'eBook berhasil dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $ebooks = Ebook::where('nama', 'like', "%$search%")
            ->orWhere('kode_buku', 'like', "%$search%")
            ->get();
    
        return view('admin.ebook', ['ebook' => $ebooks]);
    }
    
    

}
