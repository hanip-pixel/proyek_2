<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Cek jika sudah login menggunakan session custom
        if (Session::get('loggedin')) {
            return redirect()->intended('/');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        try {
            // Cari user di database pengguna
            $user = DB::connection('mysql_pengguna')
                ->table('pengguna')
                ->where('email', $request->email)
                ->first();

            if (!$user) {
                return back()->withErrors([
                    'email' => 'Email tidak ditemukan!',
                ])->withInput($request->only('email'));
            }

            // Verifikasi password
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => 'Kata sandi salah!',
                ])->withInput($request->only('email'));
            }

            // ✅ MANUAL AUTH - TANPA LARAVEL AUTH DEFAULT
            Session::put([
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'loggedin' => true
            ]);

            // Load keranjang dari database
            $keranjang = $this->loadCartFromDatabase($user->id);
            if (!empty($keranjang)) {
                Session::put('keranjang', $keranjang);
            }

            return redirect()->intended('/')->with([
                'success' => 'Login berhasil! Selamat datang ' . $user->username . '!'
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ])->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        $username = Session::get('username');
        
        // Clear semua session
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with([
            'info' => 'Anda telah logout. Sampai jumpa lagi ' . ($username ?? '') . '!'
        ]);
    }

    /**
     * Fungsi untuk memuat keranjang dari database
     */
    private function loadCartFromDatabase($user_id)
    {
        try {
            $cart = [];
            
            $items = DB::connection('mysql_pengguna')
                ->table('keranjang_pengguna')
                ->where('user_id', $user_id)
                ->get();

            foreach ($items as $item) {
                $cart[$item->produk_key] = [
                    'nama' => $item->nama_produk,
                    'harga' => $item->harga_produk,
                    'foto' => $item->foto_produk,
                    'jumlah' => $item->jumlah
                ];
            }
            
            return $cart;
            
        } catch (\Exception $e) {
            \Log::error('Error loading cart for user ' . $user_id . ': ' . $e->getMessage());
            return [];
        }
    }
}