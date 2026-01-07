<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        // Kalau sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function loginProcess(Request $req)
    {
        $req->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 🔍 Cek email
        $user = User::where('email', $req->email)->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Email tidak terdaftar'
            ])->withInput();
        }

        // 🔐 Cek password
        if (!Auth::attempt([
            'email'    => $req->email,
            'password' => $req->password,
        ])) {
            return back()->withErrors([
                'login' => 'Password salah'
            ])->withInput();
        }

        // 🧑‍💼 CEK KECOCOKAN ROLE
        if ($user->role !== $req->role) {
            Auth::logout();

            return back()->withErrors([
                'login' => 'Role tidak sesuai dengan akun'
            ])->withInput();
        }

        $req->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('login');
    }
}