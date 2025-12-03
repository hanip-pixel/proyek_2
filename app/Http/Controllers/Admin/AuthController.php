<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Check credentials manually (karena password plaintext)
        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin && $admin->password === $credentials['password']) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:5|max:15|unique:admin,username',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string',
        ]);

        Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password, // Plaintext sesuai existing
            'date' => now(),
        ]);

        return redirect()->route('admin.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}