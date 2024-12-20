<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve all users
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function create()
    {
        // Display form to add a new user
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_as' => 'required|integer',
        ]);

        // Create a new user
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_as' => $request->input('role_as'),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id_user)
    {
        // Retrieve the user to be edited
        $user = User::findOrFail($id_user);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id_user)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id_user . ',id_user',
            'password' => 'nullable|string|min:8|confirmed',
            'role_as' => 'required|integer',
        ]);

        // Retrieve the user to be updated
        $user = User::findOrFail($id_user);

        // Update the user
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_as' => $request->input('role_as'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id_user)
    {
        // Delete the user
        $user = User::findOrFail($id_user);
        $user->delete();

        return redirect()->route('admin.user.insex')->with('success', 'User berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $users = User::where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('id_user', 'like', '%' . $searchTerm . '%')
                        ->get();

        return view('admin.user', compact('users'));
    }
}
