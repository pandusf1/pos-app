<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan halaman form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses pendaftaran
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role'     => 'required', 
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi foto
        ]);

        // 2. Siapkan variabel untuk URL foto
        // Default pakai gambar kosong atau null
        $avatarUrl = null; 

        // 3. Cek apakah user meng-upload foto?
        if ($request->hasFile('avatar')) {
            // Upload ke Cloudinary (folder 'avatars')
            $upload = $request->file('avatar')->storeOnCloudinary('avatars');
            
            // Ambil URL HTTPS yang aman
            $avatarUrl = $upload->getSecurePath();
        }

        // 4. Simpan ke Database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'avatar'   => $avatarUrl, // URL dari Cloudinary masuk sini
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}