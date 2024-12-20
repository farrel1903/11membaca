<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\JenisDenda;
use Illuminate\Http\Request;

class JenisDendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisDenda = JenisDenda::when($search, function ($query, $search) {
            return $query->where('jenis_denda', 'like', "%{$search}%");
        })->get();
    
        return view('admin.jenisdenda', compact('jenisDenda'));
    }
    

    public function create()
    {
        return view('jenis_denda.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_denda' => 'required|string|max:255',
            'jenis_denda' => 'required|string|max:255',
        ]);

        JenisDenda::create($request->all());

        return redirect()->route('jenis_denda.index')->with('success', 'Jenis denda berhasil ditambahkan.');
    }

    // Tambahkan method edit, update dan destroy jika perlu
}
