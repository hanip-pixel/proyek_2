<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('pengguna')
            ->leftJoin('profil_pengguna', 'pengguna.username', '=', 'profil_pengguna.username')
            ->select(
                'pengguna.username', // ✅ GUNAKAN username, BUKAN id
                'pengguna.email',
                'pengguna.date',
                'profil_pengguna.nama',
                'profil_pengguna.kelamin',
                'profil_pengguna.tanggal_lahir',
                'profil_pengguna.telepon',
                DB::raw("CONCAT(COALESCE(profil_pengguna.desa, ''), ', ', COALESCE(profil_pengguna.kecamatan, ''), ', ', COALESCE(profil_pengguna.kabupaten, '')) as alamat"),
                'profil_pengguna.foto'
            )
            ->orderBy('pengguna.date', 'DESC')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}