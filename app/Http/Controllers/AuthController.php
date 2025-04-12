<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function authProccess(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($validate)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.index')->with('success', 'Login Success');
        }

        return redirect()->back()->with('error', 'Username/Password Failed');
    }

    public function logOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'LogOut Success');
    }

}
