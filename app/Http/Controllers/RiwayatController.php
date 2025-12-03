<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RiwayatController extends Controller
{
    public function index()
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $user_id = Session::get('user_id');

        if (!$user_id) {
            return redirect('/login')->with('error', 'User ID tidak ditemukan!');
        }

        // PERBAIKAN: Gunakan 'username' sebagai kondisi where
        $profil_pengguna = DB::table('profil_pengguna')
            ->where('username', $user_id)  // ✅ UBAH: 'id' menjadi 'username'
            ->first();

        // Ambil semua data transaksi user diurutkan dari yang terbaru
        $semua_transaksi = DB::table('riwayat_transaksi')
            ->where('user_id', $user_id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $transaksi_terakhir = $semua_transaksi->first();
        
        // Kelompokkan transaksi
        $transaksi_dikelompokkan = [];
        foreach ($semua_transaksi as $transaksi) {
            $key = $transaksi->tanggal_transaksi;
            if (!isset($transaksi_dikelompokkan[$key])) {
                $transaksi_dikelompokkan[$key] = [];
            }
            $transaksi_dikelompokkan[$key][] = $transaksi;
        }

        krsort($transaksi_dikelompokkan);

        return view('pages.riwayat', compact(
            'profil_pengguna',
            'transaksi_terakhir',
            'transaksi_dikelompokkan',
            'semua_transaksi'
        ));
    }

    public function show($id)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $user_id = Session::get('user_id');

        // Ambil detail transaksi
        $transaksi = DB::table('riwayat_transaksi')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        return view('pages.detail_riwayat', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $user_id = Session::get('user_id');

        $request->validate([
            'status' => 'required|in:dikemas,dikirim,selesai'
        ]);

        // Update status transaksi
        $updated = DB::table('riwayat_transaksi')
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Status transaksi berhasil diupdate!');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate status transaksi!');
    }

    public function filter(Request $request)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $user_id = Session::get('user_id');
        $status = $request->get('status');

        // Query dasar
        $query = DB::table('riwayat_transaksi')
            ->where('user_id', $user_id);

        // Filter berdasarkan status jika dipilih
        if ($status && in_array($status, ['dikemas', 'dikirim', 'selesai'])) {
            $query->where('status', $status);
        }

        $semua_transaksi = $query->orderBy('tanggal_transaksi', 'desc')->get();

        // PERBAIKAN: Gunakan 'username' sebagai kondisi where
        $profil_pengguna = DB::table('profil_pengguna')
            ->where('username', $user_id)  // ✅ UBAH: 'id' menjadi 'username'
            ->first();

        $transaksi_terakhir = $semua_transaksi->first();
        
        // Kelompokkan transaksi
        $transaksi_dikelompokkan = [];
        foreach ($semua_transaksi as $transaksi) {
            $key = $transaksi->tanggal_transaksi;
            if (!isset($transaksi_dikelompokkan[$key])) {
                $transaksi_dikelompokkan[$key] = [];
            }
            $transaksi_dikelompokkan[$key][] = $transaksi;
        }

        krsort($transaksi_dikelompokkan);

        return view('pages.riwayat', compact(
            'profil_pengguna',
            'transaksi_terakhir',
            'transaksi_dikelompokkan',
            'semua_transaksi',
            'status'
        ));
    }
}