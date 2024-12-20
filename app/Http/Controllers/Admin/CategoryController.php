<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Categories::all();
        return view('admin.kategori', ['category' => $categories]);
    }

    // Menampilkan form untuk menambahkan kategori
    public function create()
    {
        return view('admin.addebook'); // Ganti dengan view yang sesuai
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|max:255',
            'waktu_peminjaman' => 'required|integer',
            'harga_keterlambatan' => 'required|integer',
        ]);
    
        Categories::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }
    

    // Menampilkan detail kategori berdasarkan ID
    public function show(string $id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.show_category', ['category' => $category]);
    }

    // Menampilkan form untuk mengedit kategori berdasarkan ID
    public function edit(string $id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.edit_category', ['category' => $category]);
    }

    // Memperbarui kategori
    public function update(Request $request, string $id)
    {
        // Validasi data
        $request->validate([
            'kategori' => 'required|string|max:255',
            'waktu_peminjaman' => 'required|integer',
            'harga_keterlambatan' => 'required|integer',
        ]);

        $category = Categories::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    // Menghapus kategori berdasarkan ID
    public function destroy(string $id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }

    // Mencari kategori berdasarkan nama
    public function search(Request $request)
    {
        $search = $request->input('search');
        $category = Categories::where('kategori', 'like', "%$search%")->get();

        return view('admin.kategori', ['category' => $category]);
    }

    public function category () {
        //
    }
}
