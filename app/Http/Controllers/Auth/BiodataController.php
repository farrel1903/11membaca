<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    /**
     * Display the form to create biodata.
     */
    public function create()
    {
        return view('auth.biodata');
    }

    /**
     * Store a new member's biodata.
     */
    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'nis_nik' => ['required', 'string', 'regex:/^\d{16}$/', 'unique:member,nis_nik'],
            'jenis_kelamin' => ['required', 'string'],
            'no_telepon' => ['required', 'string'],
            'asal_sekolah' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Validasi untuk memastikan user ditemukan
        if (!$user) {
            return redirect()->back()->withErrors(['msg' => 'User tidak ditemukan.']);
        }

        // Mengatur default nama file foto jika tidak ada foto yang diunggah
        $fotoPath = null;

        // Jika ada foto yang diunggah, simpan file foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotomember', 'public'); // Menyimpan file ke storage/app/public/fotomember
        }

        // Simpan biodata
        Member::create([
            'nis_nik' => $validatedData['nis_nik'],
            'id_user' => $user->id_user,
            'nama' => $user->name,
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'no_telepon' => $validatedData['no_telepon'],
            'status' => $user->status, // Menggunakan status dari user
            'asal_sekolah' => 'umum',
            'tingkatan' => 'NonPro', // Menetapkan tingkatan default
            'foto' => $fotoPath, // Menyimpan path foto
        ]);

        // Tentukan rute berdasarkan peran user
        return $this->redirectBasedOnRole($user->role_as);
        
    }

    /**
     * Redirect user based on their role.
     */
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 3:
                return redirect()->route('kepala.dashboard');
            default:
                return redirect()->route('pengguna.dashboard'); // Perbaiki typo di sini
        }
    }
}
