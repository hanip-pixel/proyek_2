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

        // Ambil data profil pengguna
        $profil_pengguna = DB::connection('mysql_pengguna')
            ->table('profil_pengguna')
            ->where('id', $user_id)
            ->first();

        // Ambil semua data transaksi user diurutkan dari yang terbaru
        $semua_transaksi = DB::connection('mysql_pengguna')
            ->table('riwayat_transaksi')
            ->where('user_id', $user_id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $transaksi_terakhir = $semua_transaksi->first();
        
        // Kelompokkan transaksi berdasarkan tanggal_transaksi
        $transaksi_dikelompokkan = [];
        foreach ($semua_transaksi as $transaksi) {
            $key = $transaksi->tanggal_transaksi;
            if (!isset($transaksi_dikelompokkan[$key])) {
                $transaksi_dikelompokkan[$key] = [];
            }
            $transaksi_dikelompokkan[$key][] = $transaksi;
        }

        // Urutkan berdasarkan tanggal (dari terbaru)
        krsort($transaksi_dikelompokkan);

        return view('pages.riwayat', compact(
            'profil_pengguna',
            'transaksi_terakhir',
            'transaksi_dikelompokkan',
            'semua_transaksi'
        ));
    }
}