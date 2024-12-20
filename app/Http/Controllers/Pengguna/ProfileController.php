<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Method untuk menampilkan profile pengguna
    public function index()
    {
        // Ambil data member berdasarkan user yang sedang login
        $member = Member::where('id_user', Auth::id())->first();

        // Jika data member tidak ditemukan`
        if (!$member) {
            return redirect()->back()->with('error', 'Data profile tidak ditemukan');
        }

        // Return view dengan data member
        return view('pengguna.profile', compact('member'));
    }

    // Method untuk mengarahkan ke halaman edit profile
    public function edit()
    {
        $member = Member::where('id_user', Auth::id())->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Data profile tidak ditemukan');
        }

        return view('pengguna.editprofile', compact('member'));
    }

    // Method untuk menyimpan perubahan profile
    public function update(Request $request)
    {
        // Validasi input tanpa 'nik'
        $request->validate([
            'nama' => ['required', 'string', 'max:255'], // Validasi nama
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi foto
        ]);
    
        // Ambil data member yang sedang login
        $member = Member::where('id_user', Auth::id())->first();
    
        if (!$member) {
            return redirect()->back()->with('error', 'Data profile tidak ditemukan');
        }
    
        // Simpan foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($member->foto) {
                $fotoPath = 'fotomember/' . basename($member->foto);
                if (Storage::exists('public/' . $fotoPath)) {
                    Storage::delete('public/' . $fotoPath);
                }
            }
    
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('fotomember', 'public');
            $member->foto = $fotoPath; // Simpan path foto
        }
    
        // Update data member termasuk 'nama'
        $member->update([
            'nama' => $request->input('nama'), // Tambahkan baris ini
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'no_telepon' => $request->input('no_telepon'),
        ]);
    
        return redirect()->route('profile.index')->with('success', 'Profile berhasil diperbarui.');
    }
    
}
