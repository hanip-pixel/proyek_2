<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        // Validasi data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Cek apakah email terdaftar - PERBAIKAN: hapus DB::connection()
            $user = DB::table('pengguna')
                ->where('email', $request->email)
                ->first();

            if (!$user) {
                return redirect()->back()
                    ->with('error', 'Email tidak ditemukan!')
                    ->withInput();
            }

            // Update password - PERBAIKAN: hapus DB::connection()
            DB::table('pengguna')
                ->where('email', $request->email)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);

            return redirect()->route('login')
                ->with('success', 'Password berhasil diubah! Silakan login.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah password: ' . $e->getMessage())
                ->withInput();
        }
    }
}