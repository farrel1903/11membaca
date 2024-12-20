<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $rak = Rak::all();
        return view('admin.rak', ['rak' => $rak]);
    }

    public function create()
    {
        return view('admin.create_rak');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rak' => 'required|string|max:255',
        ]);

        Rak::create([
            'id_rak' => $request->id_rak,
        ]);

        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan');
    }

    public function show(string $id_rak)
    {
        $rak = Rak::where('id_rak', $id_rak)->firstOrFail();
        return view('admin.show_rak', ['rak' => $rak]);
    }

    public function edit(string $id_rak)
    {
        $rak = Rak::where('id_rak', $id_rak)->firstOrFail();
        return view('admin.edit_rak', ['rak' => $rak]);
    }

    public function update(Request $request, string $id_rak)
    {
        $request->validate([
            'id_rak' => 'required|string|max:255',
        ]);

        $rak = Rak::where('id_rak', $id_rak)->firstOrFail();
        $rak->update([
            'id_rak' => $request->id_rak,
        ]);

        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui');
    }

    public function destroy(string $id_rak)
    {
        $rak = Rak::where('id_rak', $id_rak)->firstOrFail();
        $rak->delete();

        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Search rak by id_rak
        $rak = Rak::where('id_rak', $search)->get();

        return view('admin.rak', ['rak' => $rak]);
    }
}
