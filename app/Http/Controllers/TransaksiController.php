<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransaksiController extends Controller
{
    public function show($id, $tabel)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Validasi nama tabel
        $tabel_valid = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        if (!in_array($tabel, $tabel_valid)) {
            abort(404, 'Tabel tidak valid');
        }

        // Ambil produk dari database
        $produk = DB::table($tabel)
            ->where('id', $id)
            ->first();

        if (!$produk) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Ambil ulasan
        $ulasan = DB::table('ulasan')
            ->where('produk_id', $id)
            ->where('tabel', $tabel)
            ->orderBy('tanggal', 'desc')
            ->get();

        $total_ulasan = $ulasan->count();

        // Rata-rata rating
        $avg_rating = DB::table('ulasan')
            ->where('produk_id', $id)
            ->where('tabel', $tabel)
            ->avg('rating');

        $avg_rating = round($avg_rating ?: 0, 1);

        // Share info
        $url_produk = url("/transaksi/{$id}/{$tabel}");
        $nama_produk = $produk->nama_produk;
        $harga = number_format($produk->harga_produk, 0, ',', '.');
        $deskripsi_singkat = strtok($produk->deskripsi, '-');
        $pesan_share = urlencode("Cek produk ini: $nama_produk\nHarga: Rp$harga\n$url_produk\n$deskripsi_singkat");

        return view('pages.transaksi', compact(
            'produk', 'tabel', 'ulasan', 'total_ulasan', 
            'avg_rating', 'url_produk', 'pesan_share',
            'id'
        ));
    }

    // Method untuk handle query string
    public function showWithQuery(Request $request)
    {
        $id = $request->get('id');
        $tabel = $request->get('tabel');
        
        if (!$id || !$tabel) {
            abort(404, 'Parameter tidak lengkap');
        }
        
        return $this->show($id, $tabel);
    }

// app/Http/Controllers/TransaksiController.php
public function storeUlasan(Request $request, $id, $tabel)
{
    // Cek login
    if (!Session::get('loggedin')) {
        return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
    }

    // Validasi
    $request->validate([
        'nama' => 'required|string|max:100',
        'komentar' => 'required|string|max:500',
        'rating' => 'required|integer|between:1,5'
    ]);

    // Validasi nama tabel
    $tabel_valid = ['dapur', 'detergen', 'obat', 'rekomendasi'];
    if (!in_array($tabel, $tabel_valid)) {
        return redirect()->back()->with('error', 'Tabel tidak valid');
    }

    // Cek apakah produk ada
    $produk = DB::table($tabel)->where('id', $id)->first();
    if (!$produk) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan');
    }

    // Ambil data pengguna dari session
    $username = Session::get('username'); // Ini string 'hanif'
    $user_id = Session::get('user_id'); // Ini juga string 'hanif'
    
    // Jika user_id adalah string dan tabel ulasan mengharapkan integer,
    // kita perlu mendapatkan ID numerik dari tabel pengguna
    try {
        // Cari user di tabel pengguna untuk mendapatkan ID yang sesuai
        $pengguna = DB::table('pengguna')->where('username', $username)->first();
        
        if ($pengguna) {
            // Jika ada kolom 'id' di tabel pengguna
            if (isset($pengguna->id)) {
                $numeric_user_id = $pengguna->id;
            } else {
                // Jika tidak ada kolom 'id', gunakan username sebagai user_id (string)
                $numeric_user_id = $username;
            }
        } else {
            // Jika tidak ditemukan, gunakan default
            $numeric_user_id = 0;
        }
    } catch (\Exception $e) {
        $numeric_user_id = 0;
    }

    // Buat email default jika tidak ada
    $email = Session::get('email');
    if (!$email && $username) {
        $email = $username . '@user.com';
    }

    // Simpan ulasan
    try {
        DB::table('ulasan')->insert([
            'user_id' => $numeric_user_id, // Gunakan ID numerik atau string
            'produk_id' => $id,
            'tabel' => $tabel,
            'email' => $email,
            'nama' => $request->nama,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
            'tanggal' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect("/transaksi/{$id}/{$tabel}")
            ->with('success', 'Ulasan berhasil dikirim! Terima kasih atas ulasan Anda.');

    } catch (\Exception $e) {
        \Log::error('Error menyimpan ulasan: ' . $e->getMessage());
        
        // Untuk debugging, tampilkan error detail
        return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan saat menyimpan ulasan. Error: ' . $e->getMessage());
    }
}
    // METHOD UNTUK TRANSAKSI LANJUT
    public function showLanjut(Request $request)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        $id = $request->get('id');
        $tabel = $request->get('tabel');

        if (!$id || !$tabel) {
            abort(404, 'Parameter tidak lengkap');
        }

        // Validasi nama tabel
        $tabel_valid = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        if (!in_array($tabel, $tabel_valid)) {
            abort(404, 'Tabel tidak valid');
        }

        // Ambil produk dari database
        $produk = DB::table($tabel)
            ->where('id', $id)
            ->first();

        if (!$produk) {
            abort(404, 'Produk tidak ditemukan');
        }

        // SET BIAYA TETAP
        $ongkir = 1500;
        $layanan = 1000;
        $jasa = 500;

        // Tambahkan properti ongkir, layanan, jasa ke objek produk
        $produk->ongkir = $ongkir;
        $produk->layanan = $layanan;
        $produk->jasa = $jasa;

        // Handle stok_produk jika tidak ada (gunakan stok biasa)
        $produk->stok_produk = $produk->stok_produk ?? $produk->stok ?? 0;

        return view('pages.transaksi_lanjut', compact('produk', 'id', 'tabel'));
    }

    public function prosesPembelian(Request $request)
    {
        // Cek login
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Validasi input
        $request->validate([
            'produk_id' => 'required|integer',
            'tabel' => 'required|string',
            'metode_pembayaran' => 'required|string|in:Gopay,Dana,Ovo,COD',
            'quantity' => 'required|integer|min:1',
            'total_harga' => 'required|numeric'
        ]);

        // ✅ DEBUG DETAIL: Lihat semua data yang dikirim
        \Log::info('=== DATA PEMBELIAN DITERIMA ===');
        \Log::info('Produk ID: ' . $request->produk_id);
        \Log::info('Tabel: ' . $request->tabel);
        \Log::info('Metode Pembayaran: ' . $request->metode_pembayaran);
        \Log::info('Quantity: ' . $request->quantity);
        \Log::info('Total Harga: ' . $request->total_harga);
        \Log::info('User ID: ' . Session::get('user_id'));

        $produk_id = $request->produk_id;
        $tabel = $request->tabel;
        $metode_pembayaran = $request->metode_pembayaran;
        $quantity = $request->quantity;
        $total_harga = $request->total_harga;

        // Validasi nama tabel
        $tabel_valid = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        if (!in_array($tabel, $tabel_valid)) {
            return redirect()->back()->with('error', 'Tabel tidak valid');
        }

        // Ambil produk untuk validasi stok
        $produk = DB::table($tabel)
            ->where('id', $produk_id)
            ->first();

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        // Validasi stok
        $stok = $produk->stok_produk ?? $produk->stok ?? 0;
        if ($stok < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $stok);
        }

        try {
            // SET BIAYA TETAP
            $ongkir = 1500;
            $layanan = 1000;
            $jasa = 500;

            // ✅ DEBUG: HITUNG MANUAL UNTUK VERIFIKASI
            $hitung_manual = ($produk->harga_produk * $quantity) + $ongkir + $layanan + $jasa;
            \Log::info('Hitung manual total: ' . $hitung_manual);
            \Log::info('Total dari form: ' . $total_harga);

            // Simpan transaksi ke database
            $transaksi_id = DB::table('riwayat_transaksi')->insertGetId([
                'user_id' => Session::get('user_id'),
                'produk_id' => $produk_id,
                'tabel_produk' => $tabel,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'ongkir' => $ongkir,
                'layanan' => $layanan,
                'jasa' => $jasa,
                'quantity' => $quantity,
                'total_harga' => $total_harga, // Pakai nilai dari form
                'metode_pembayaran' => $metode_pembayaran,
                'foto_produk' => $produk->foto_produk,
                'status' => 'dikemas',
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update stok produk
            DB::table($tabel)
                ->where('id', $produk_id)
                ->decrement('stok', $quantity);

            // Update terjual
            DB::table($tabel)
                ->where('id', $produk_id)
                ->increment('terjual', $quantity);

            // ✅ DEBUG: Cek apakah transaksi berhasil
            \Log::info('Transaksi berhasil dengan ID: ' . $transaksi_id);

            // Redirect ke halaman riwayat setelah berhasil
            return redirect()->route('riwayat.index')
                ->with('success', 'Pembelian berhasil diproses!');

        } catch (\Exception $e) {
            \Log::error('Error proses pembelian: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}