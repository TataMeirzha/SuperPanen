<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Notifikasi;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun kamu dinonaktifkan. Hubungi admin.']);
            }
            return match($user->role) {
                'superadmin' => redirect('/superadmin/dashboard'),
                'admin_panen' => redirect('/admin-panen/dashboard'),
                'mitra' => redirect('/mitra/dashboard'),
                default => redirect('/user/dashboard'),
            };
        }
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,mitra',
            'no_hp' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'is_active' => true,
        ]);

        // Kirim notifikasi selamat datang
        Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'Selamat Datang di SuperPanen!',
            'pesan' => 'Akun kamu berhasil dibuat. Selamat menggunakan SuperPanen!',
            'tipe' => 'info',
            'url' => $user->role === 'mitra' ? '/mitra/dashboard' : '/user/dashboard',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}