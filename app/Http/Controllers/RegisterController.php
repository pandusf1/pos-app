<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
public function showRegisterForm()    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,kasir',
        ]);

        // 🔐 proteksi admin
        if ($request->role === 'admin') {
            if ($request->admin_code !== env('ADMIN_REGISTER_CODE')) {
                return back()->withErrors([
                    'admin_code' => 'Kode admin tidak valid'
                ])->withInput();
            }
        }

        // Buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 🔹 Tidak login otomatis
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login');
    }
}
