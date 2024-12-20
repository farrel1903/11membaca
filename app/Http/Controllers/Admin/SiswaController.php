<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('admin.siswa', compact('siswa'));
    }

    public function create()
    {
        return view('admin.addsiswa'); // Ganti dengan nama view yang sesuai untuk form tambah siswa
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'kelas' => 'required|string|in:X RPL 1,X RPL 2,XI RPL 1,XI RPL 2,XI AKL 1,XI AKL 2',
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('siswa.index');
    }

    public function destroy($nis)
    {
        $siswa = Siswa::find($nis);
        if ($siswa) {
            $siswa->delete();
        }

        return redirect()->route('siswa.index');
    }


    public function edit($nis)
    {
        $siswa = Siswa::findOrFail($nis);
        return view('admin.editsiswa', ['siswa' => $siswa]);
    }

    public function update(Request $request, $nis)
    {
        $request->validate([
            'nis' => 'required',
            'full_name' => 'required',
            'gender' => 'required|string|in:Laki-laki,Perempuan',
            'kelas' => 'required|string|in:X RPL 1,X RPL 2,XI RPL 1,XI RPL 2,XI AKL 1,XI AKL 2',
        ]);

        $siswa = Siswa::where('nis', $nis)->firstOrFail();
        $siswa->nis = $request->nis;
        $siswa->full_name = $request->full_name;
        $siswa->gender = $request->gender;
        $siswa->kelas = $request->kelas;
        $siswa->save();

        return redirect()->route('siswa.index')->with('success', 'Siswa Berhasil Diperbarui');
    }



    public function search(Request $request)
    {
        $search = $request->input('search');
        $siswa = Siswa::where('full_name', 'like', "%$search%")
            ->orWhere('nis', 'like', "%$search%")
            ->get();

        return view('admin.siswa', ['siswa' => $siswa]);
    }
}
