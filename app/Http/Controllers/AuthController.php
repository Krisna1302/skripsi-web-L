<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ==============================
    // TAMPILKAN FORM LOGIN
    // ==============================
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ==============================
    // PROSES LOGIN / AUTENTIKASI
    // ==============================
    public function login(Request $request)
{
    // Validasi input login
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Cari user berdasarkan username
    $user = User::where('username', $credentials['username'])->first();

    // Cek apakah user ada dan password cocok
    if ($user && Hash::check($credentials['password'], $user->password)) {
        // Login user
        Auth::login($user);

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->role === 'mahasiswa') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'dosen') {
            return redirect()->route('dashboard.dosen');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard'); // Tambahkan ini
        }
    }

    // Jika login gagal, kembalikan error
    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}

// ==============================
// LOGOUT
// ==============================
public function logout(Request $request)
{
    Auth::logout();

    // invalidate session biar aman
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Berhasil logout');
}

}
