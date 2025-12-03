<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data - PERBAIKAN: hapus spesifikasi connection di Rule::unique
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:15',
                Rule::unique('pengguna', 'username') // ✅ SUDAH BENAR
            ],
            'email' => [
                'required',
                'email', 
                'max:50',
                Rule::unique('pengguna', 'email') // ✅ PERBAIKAN: hapus 'mysql_pengguna.'
            ],
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $pengguna = Pengguna::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date' => now(),
        ]);

        if ($pengguna) {
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login.');
        }

        return redirect()->back()
            ->with('error', 'Gagal melakukan registrasi.')
            ->withInput();
    }
}