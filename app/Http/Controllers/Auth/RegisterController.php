<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Alamat tujuan setelah pendaftaran
    protected $redirectTo = '/biodata';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Validasi data pendaftaran
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'ends_with:@gmail.com'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Buat pengguna baru
    protected function create(array $data)
    {
        // Tentukan default role
        $role = 0; // Default role untuk pengguna biasa

        // Tidak ada lagi penentuan role berdasarkan email

        // Tentukan status hanya jika domain email adalah @gmail.com
        $status = null; // Default status null
        if (strpos($data['email'], '@gmail.com') !== false) {
            $status = 'General'; // Status untuk pengguna dengan email @gmail.com
        }

        return User::create([
            'id_user' => User::generateIdUser(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_as' => $role,
            'status' => $status, // Status yang sudah ditentukan
        ]);
    }
}
