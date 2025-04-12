<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(request $request)
    {

        $query = User::query();

        if($request->has('search') && $request->search != ''){
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $data['users'] = $query->latest()->get();
        return view('Page.User.index', $data);
    }

    public function create()
    {
        return view('Page.User.create');
    }

    public function store(Request $request)
    { 
        $validate = $request->validate([
        'name' => 'required',
        'role' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
        ], 
        [
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Hash password
        $validate['password'] = Hash::make($validate['password']);

        // Simpan data
        $user = User::create($validate);

        if (!$user) {
            return redirect()->back()->with('error', 'Gagal membuat user.');
        }

        return redirect()->route('users.index')->with('success', 'Success Create User');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('Page.User.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required',
    ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');

    }
}
