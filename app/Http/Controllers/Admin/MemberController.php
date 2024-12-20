<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        // Ambil semua data member
        $members = Member::where('status', '!=', 'Pegawai')->get();
        return view('admin.member', compact('members'));
    }

    public function showdetail($id)
    {
        // Ambil data member berdasarkan id_user
        $member = Member::where('id_user', $id)->firstOrFail();
        return view('admin.detailmember', compact('member'));
    }

    public function create()
    {
        // Tampilkan form untuk menambah member
        return view('auth.biodata'); // Ganti dengan nama form biodata
    }

    public function store(Request $request)
    {
        // Validasi input
        // $request->validate([
        //     'nik' => ['required', 'string', 'max:15'],
        //     'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
        //     'no_telepon' => ['required', 'string', 'max:20'],
        //     'status' => ['required', 'in:Full,General'],
        //     'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi foto
        // ]);

        // Ambil data user yang saat ini sedang login
        $user = Auth::user();
        $id_user = $user->id_user; // ID user dari user yang saat ini login
        $nama = $user->name; // Nama user dari user yang saat ini login

        // Simpan foto jika ada
        $filename = null; // Inisialisasi filename
        if ($request->file('foto')) {
            $filename = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('members'), $filename);
        }

        // Simpan data member
        $status = null; // Default status null
        if (Auth::user()->role == 0) {
            $emailDomain = substr(strrchr(Auth::user()->email, "@"), 1);
            $status = $emailDomain === 'siswa.com' ? 'Full' : ($emailDomain === 'gmail.com' ? 'General' : null);
        }
        Member::create([
            'nis_nik' => $request->input('nis_nik'),
            'nama' => $nama,
            'id_user' => $id_user,
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'no_telepon' => $request->input('no_telepon'),
            'status' => $status,
            'tingkatan' => 'NonPro', // Menetapkan tingkatan default
            'foto' => $filename,
        ]);

        if (Auth::user()->role == 3) {
            return redirect()->route('kepala.dashboard')->with('success', 'Member berhasil ditambahkan.');
        }
        return redirect()->route('pengguna.dashboard')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data member berdasarkan id_user
        $member = Member::where('id_user', $id)->firstOrFail();
        return view('admin.editmember', compact('member'));
    }


    public function update(Request $request, $id_user)
    {
        // Ambil data member berdasarkan id_user
        $member = Member::where('id_user', $id_user)->firstOrFail();

        // Validasi input
        $request->validate([
            'nis_nik' => ['required', 'string', 'unique:member,nis_nik,' . $member->id_user . ',id_user'], // Menggunakan nama tabel yang benar
            'nama' => ['required', 'string'], // Validasi untuk nama
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'asal_sekolah' => ['required', 'string'], // Validasi untuk asal_sekolah
            'tingkatan' => ['required', 'in:NonPro,Pro'], // Validasi untuk tingkatan
            'status' => ['required', 'in:Full,General,Pegawai'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi foto
        ]);

        // Simpan foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($member->foto) {
                $fotoPath = 'members/' . $member->foto;
                if (Storage::exists($fotoPath)) {
                    Storage::delete($fotoPath);
                }
            }

            // Simpan foto baru
            $filename = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('members'), $filename);
            $member->foto = $filename; // Set foto baru
        }

        // Update data member
        $member->update([
            'nis_nik' => $request->input('nis_nik'),
            'nama' => $request->input('nama'), // Menambahkan nama
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'no_telepon' => $request->input('no_telepon'),
            'asal_sekolah' => $request->input('asal_sekolah'), // Menambahkan asal_sekolah
            'tingkatan' => $request->input('tingkatan'), // Menambahkan tingkatan
            'status' => $request->input('status'), // Pastikan status diupdate sesuai input
        ]);

        // Kembali ke halaman member dengan pesan sukses
        return redirect()->route('admin.member.index')->with('success', 'Member berhasil diperbarui.');
    }


    public function destroy($id)
    {
        // Find the user by ID
        $user = User::where('id_user', $id)->first();

        // Check if the user exists
        if (!$user) {
            return redirect()->route('admin.member.index')->with('error', 'User tidak ditemukan.');
        }

        // Find the member by user ID
        $member = Member::where('id_user', $user->id_user)->first();

        // Check if the member exists
        if ($member) {
            // Delete the member's photo if it exists
            if ($member->foto) {
                $fotoPath = 'members/' . $member->foto;
                if (Storage::exists($fotoPath)) {
                    Storage::delete($fotoPath);
                }
            }

            // Delete the member record
            $member->delete();
        }

        // Delete the user record
        $user->delete();

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search') && $request->filled('filter')) {
            switch ($request->filter) {
                case 'nama':
                    $query->where('nama', 'like', '%' . $request->search . '%');
                    break;
                case 'nis_nik':
                    $query->where('nis_nik', $request->search);
                    break;
                case 'id_user':
                    $query->where('id_user', $request->search);
                    break;
                case 'no_telepon':
                    $query->where('no_telepon', $request->search);
                    break;
                case 'asal_sekolah':
                    $query->where('asal_sekolah', 'like', '%' . $request->search . '%');
                    break;
            }
        }

        // Tambahkan filter untuk status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $members = $query->get();

        return view('admin.member', compact('members'));
    }

    public function updateMultiple(Request $request)
    {
        $selectedMembers = $request->input('selected_members');
        $newStatus = $request->input('new_status');
        $newTingkatan = $request->input('new_tingkatan');
    
        if (!$selectedMembers || (!$newStatus && !$newTingkatan)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada perubahan yang dilakukan.']);
        }
    
        // Update tingkatan dan status hanya jika nilai baru disediakan
        Member::whereIn('id_user', $selectedMembers)->update(array_filter([
            'status' => $newStatus,
            'tingkatan' => $newTingkatan,
        ]));
    
        return response()->json(['success' => true, 'message' => 'Apakah anda yakin ingin melakukan perubahan?']);
    }
    
}
