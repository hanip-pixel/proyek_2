<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $username = Session::get('user_id'); // username
        $email = Session::get('email');

        // ✅ PERBAIKAN: CARI BERDASARKAN username
        $profil_pengguna = DB::table('profil_pengguna')
            ->where('username', $username)
            ->first();

        return view('pages.profil', compact('profil_pengguna', 'email', 'username'));
    }

    public function biodata()
    {
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $username = Session::get('user_id');
        $email = Session::get('email');

        $profil_pengguna = DB::table('profil_pengguna')
            ->where('username', $username)
            ->first();

        return view('pages.profil_biodata', compact('profil_pengguna', 'email', 'username'));
    }

    public function alamat()
    {
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $username = Session::get('user_id');
        $email = Session::get('email');

        $profil_pengguna = DB::table('profil_pengguna')
            ->where('username', $username)
            ->first();

        return view('pages.profil_alamat', compact('profil_pengguna', 'email', 'username'));
    }

    public function uploadFoto(Request $request)
    {
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $username = Session::get('user_id');
        $email = Session::get('email');

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto_profil', $fileName, 'public');

                // ✅ PERBAIKAN: UPDATE BERDASARKAN username
                $existing = DB::table('profil_pengguna')
                    ->where('username', $username)
                    ->first();

                if ($existing) {
                    // Update existing
                    DB::table('profil_pengguna')
                        ->where('username', $username)
                        ->update([
                            'foto' => $fileName,
                            'updated_at' => now()
                        ]);
                } else {
                    // Insert new
                    DB::table('profil_pengguna')->insert([
                        'username' => $username,
                        'email' => $email,
                        'foto' => $fileName,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                return redirect()->back()->with('success', 'Foto berhasil diupload!');
            }

            return redirect()->back()->with('error', 'Silakan pilih file terlebih dahulu.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }

public function simpanBiodata(Request $request)
{
    if (!Session::get('loggedin')) {
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
    }

    // Debug: lihat data yang diterima
    \Log::info('Data received in simpanBiodata:', $request->all());

    $request->validate([
        'nama' => 'nullable|string|max:50',
        'tanggal_lahir' => 'nullable|date',
        'kelamin' => 'nullable|in:Laki-laki,Perempuan',
        'telepon' => 'nullable|string|max:20',
        'username' => 'required|string'
    ]);

    $username = $request->username;
    $email = Session::get('email');

    try {
        $data = [
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kelamin' => $request->kelamin,
            'telepon' => $request->telepon,
            'email' => $email,
            'updated_at' => now()
        ];

        // Jangan hapus null values, biarkan update dengan null jika dikosongkan
        // $data = array_filter($data, function($value) {
        //     return !is_null($value);
        // });

        $existing = DB::table('profil_pengguna')
            ->where('username', $username)
            ->first();

        if ($existing) {
            // Update data existing
            DB::table('profil_pengguna')
                ->where('username', $username)
                ->update($data);
                
            $message = 'Data biodata berhasil diupdate!';
        } else {
            // Insert data baru
            $data['username'] = $username;
            $data['created_at'] = now();
            DB::table('profil_pengguna')->insert($data);
            
            $message = 'Data biodata berhasil disimpan!';
        }

        return redirect()->route('profil.index')->with('success', $message);

    } catch (\Exception $e) {
        \Log::error('Error saving biodata: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Gagal menyimpan biodata: ' . $e->getMessage())
            ->withInput();
    }
}

public function simpanAlamat(Request $request)
{
    if (!Session::get('loggedin')) {
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
    }

    $request->validate([
        'kabupaten' => 'nullable|string|max:20',
        'kecamatan' => 'nullable|string|max:25',
        'desa' => 'nullable|string|max:25',
        'rt_rw' => 'nullable|integer',
        'username' => 'required|string'
    ]);

    $username = $request->username;
    $email = Session::get('email');

    try {
        $data = [
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'rt_rw' => $request->rt_rw,
            'email' => $email,
            'updated_at' => now()
        ];

        // Hapus null values
        $data = array_filter($data, function($value) {
            return !is_null($value);
        });

        $existing = DB::table('profil_pengguna')
            ->where('username', $username)
            ->first();

        if ($existing) {
            DB::table('profil_pengguna')
                ->where('username', $username)
                ->update($data);
                
            $message = 'Data alamat berhasil diupdate!';
        } else {
            $data['username'] = $username;
            $data['created_at'] = now();
            DB::table('profil_pengguna')->insert($data);
            
            $message = 'Data alamat berhasil disimpan!';
        }

        return redirect()->route('profil.index')->with('success', $message);

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menyimpan alamat: ' . $e->getMessage())
            ->withInput();
    }
}
}