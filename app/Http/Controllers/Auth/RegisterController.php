<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // Jangan lupa import ini

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data dengan specify connection
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'max:15',
                Rule::unique('mysql_pengguna.pengguna', 'username')
            ],
            'email' => [
                'required',
                'email', 
                'max:50',
                Rule::unique('mysql_pengguna.pengguna', 'email')
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