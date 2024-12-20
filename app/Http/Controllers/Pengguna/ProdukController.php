<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Member;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $member = Member::where('id_user', Auth::id())->first();
        $buku = Buku::paginate(3); // Pagination, menampilkan 3 buku per halaman
        $kategori = Categories::withCount('bukus')->get(); // Mengambil kategori dan jumlah buku di setiap kategori
    
        return view('pengguna.produk', [
            'buku' => $buku,
            'kategori' => $kategori,
            'member' => $member,
        ]);
    }
    

    public function search(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter'); // Ambil filter dari request
        $member = Member::where('id_user', Auth::id())->first();
    
        $buku = Buku::query();
    
        if ($filter && $query) {
            if ($filter == 'judul') {
                $buku->where('judul', 'LIKE', "%{$query}%");
            } elseif ($filter == 'Penulis') {
                $buku->where('Penulis', 'LIKE', "%{$query}%");
            } elseif ($filter == 'kategori') {
                $buku->whereHas('kategori', function ($q) use ($query) {
                    $q->where('kategori', 'LIKE', "%{$query}%");
                });
            }
        } elseif ($query) {
            // Jika filter tidak dipilih, gunakan pencarian global pada judul dan penulis
            $buku->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('Penulis', 'LIKE', "%{$query}%");
        }
    
        $buku = $buku->paginate(8); // Sesuaikan jumlah per halaman
        $kategori = Categories::withCount('bukus')->get();
    
        return view('pengguna.produk', compact('buku', 'kategori', 'member'));
    }
    

    public function filterByCategory($id)
    {
        // Ambil buku berdasarkan kategori
        $buku = Buku::where('kategori_id', $id)->paginate(10); // Ganti 'kategori_id' dengan nama kolom yang sesuai
        $kategori = Categories::withCount('bukus')->get(); // Ambil semua kategori dengan hitungan buku
        $member = Member::where('id_user', Auth::id())->first();

        return view('pengguna.produk', [
            'buku' => $buku,
            'kategori' => $kategori,
            'member' => $member
            
        ]);
    }
}
