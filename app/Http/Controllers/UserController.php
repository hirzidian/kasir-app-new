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

    public function store(Request $r)
{
    // Validasi input
    $request = $r->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'password' => 'required'
    ]);

    // Cek apakah email sudah terdaftar
    $existEmail = User::where('email', $r->email)->first();
    if ($existEmail) {
        return redirect()->back()->with('error', 'Email sudah terdaftar!');
    }

    // Hash password sebelum disimpan
    $request['password'] = Hash::make($r->password);

    // Menyimpan user baru
    User::create($request);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
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
    


    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('Page.User.edit', compact('user'));
    }
    
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');

    }
}
