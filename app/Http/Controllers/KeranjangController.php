<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    public function index()
    {
        // ✅ CEK LOGIN HANYA DI SINI
        if (!Session::get('loggedin')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Set zona waktu ke WIB
        date_default_timezone_set('Asia/Jakarta');

        // Ambil data keranjang dari session
        $keranjang = Session::get('keranjang', []);
        
        // Hitung total belanja
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('pages.keranjang', compact('keranjang', 'total'));
    }

    public function tambah($key)
    {
        $produk = $this->getProduct($key);
        
        if (!$produk) {
            return redirect()->route('keranjang.index')->with('error', 'Produk tidak ditemukan!');
        }

        // Inisialisasi keranjang jika belum ada
        $keranjang = Session::get('keranjang', []);
        
        // Cek apakah produk sudah ada di keranjang
        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] += 1;
        } else {
            // Tambah produk baru ke keranjang
            $keranjang[$key] = [
                'nama' => $produk->nama_produk,
                'harga' => $produk->harga_produk,
                'foto' => $produk->foto_produk,
                'jumlah' => 1
            ];
        }

        // Simpan ke session
        Session::put('keranjang', $keranjang);

        // Simpan ke database keranjang_pengguna
        $this->simpanKeDatabaseKeranjang(Session::get('user_id'), $key, $produk);

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function kurang($key)
    {
        $keranjang = Session::get('keranjang', []);
        
        if (isset($keranjang[$key])) {
            if ($keranjang[$key]['jumlah'] > 1) {
                // Kurangi jumlah
                $keranjang[$key]['jumlah'] -= 1;
                Session::put('keranjang', $keranjang);
                
                // Update di database
                $this->updateDatabaseKeranjang(Session::get('user_id'), $key, -1);
                
                return redirect()->route('keranjang.index')->with('success', 'Jumlah produk berhasil dikurangi!');
            } else {
                // Jika jumlah = 1, hapus produk
                unset($keranjang[$key]);
                Session::put('keranjang', $keranjang);
                
                // Hapus dari database
                $this->hapusDariDatabaseKeranjang(Session::get('user_id'), $key);
                
                return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
            }
        }

        return redirect()->route('keranjang.index')->with('error', 'Produk tidak ditemukan di keranjang!');
    }

    public function hapus($key)
    {
        $keranjang = Session::get('keranjang', []);
        
        if (isset($keranjang[$key])) {
            unset($keranjang[$key]);
            Session::put('keranjang', $keranjang);
            
            // Hapus dari database
            $this->hapusDariDatabaseKeranjang(Session::get('user_id'), $key);
            
            return redirect()->route('keranjang.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
        }

        return redirect()->route('keranjang.index')->with('error', 'Produk tidak ditemukan di keranjang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string|in:Gopay,Dana,Ovo,COD'
        ]);

        $keranjang = Session::get('keranjang', []);
        $metode_pembayaran = $request->metode_pembayaran;

        if (empty($keranjang)) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {
            $user_id = Session::get('user_id');
            $tanggal_transaksi = now();

            foreach ($keranjang as $key => $item) {
                $produk = $this->getProduct($key);
                if (!$produk) {
                    continue;
                }

                $parts = explode('-', $key);
                $table_produk = $parts[0];
                $produk_id = $parts[1];

                // Hitung total harga
                $total_harga = ($produk->harga_produk * $item['jumlah']) + 
                              $produk->ongkir + 
                              $produk->layanan + 
                              $produk->jasa;

                // Simpan ke riwayat transaksi
                DB::table('riwayat_transaksi')->insert([
                    'user_id' => $user_id,
                    'produk_id' => $produk_id,
                    'tabel_produk' => $table_produk,
                    'nama_produk' => $produk->nama_produk,
                    'harga_produk' => $produk->harga_produk,
                    'ongkir' => $produk->ongkir,
                    'layanan' => $produk->layanan,
                    'jasa' => $produk->jasa,
                    'quantity' => $item['jumlah'],
                    'total_harga' => $total_harga,
                    'metode_pembayaran' => $metode_pembayaran,
                    'foto_produk' => $produk->foto_produk,
                    'tanggal_transaksi' => $tanggal_transaksi,
                    'status' => 'dikemas',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update stok produk
                DB::table($table_produk)
                    ->where('id', $produk_id)
                    ->update([
                        'stok_produk' => DB::raw('stok_produk - ' . $item['jumlah']),
                        'terjual' => DB::raw('terjual + ' . $item['jumlah'])
                    ]);
            }

            // Kosongkan keranjang
            Session::forget('keranjang');

            // Hapus keranjang dari database
            DB::table('keranjang_pengguna')->where('user_id', $user_id)->delete();

            DB::commit();

            // Delay untuk memastikan data tersimpan
            sleep(1);

            return redirect()->route('keranjang.index')->with('success', 'Pembelian berhasil, barang akan segera diproses!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error saat checkout: ' . $e->getMessage());
            return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat memproses pembelian: ' . $e->getMessage());
        }
    }

    /**
     * Get product from database
     */
    private function getProduct($key)
    {
        $parts = explode('-', $key);
        if (count($parts) !== 2) {
            return false;
        }
        
        $table = $parts[0];
        $id = $parts[1];
        
        $table_valid = ['rekomendasi', 'dapur', 'detergen', 'obat'];
        if (!in_array($table, $table_valid)) {
            return false;
        }
        
        return DB::table($table)->where('id', $id)->first();
    }

    /**
     * Simpan ke database keranjang_pengguna
     */
    private function simpanKeDatabaseKeranjang($user_id, $key, $produk)
    {
        // Cek apakah produk sudah ada di keranjang pengguna
        $existing = DB::table('keranjang_pengguna')
            ->where('user_id', $user_id)
            ->where('produk_key', $key)
            ->first();

        if ($existing) {
            // Update jumlah
            DB::table('keranjang_pengguna')
                ->where('user_id', $user_id)
                ->where('produk_key', $key)
                ->update([
                    'jumlah' => DB::raw('jumlah + 1'),
                    'updated_at' => now()
                ]);
        } else {
            // Insert baru
            DB::table('keranjang_pengguna')->insert([
                'user_id' => $user_id,
                'produk_key' => $key,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'foto_produk' => $produk->foto_produk,
                'jumlah' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Update jumlah di database keranjang
     */
    private function updateDatabaseKeranjang($user_id, $key, $change)
    {
        DB::table('keranjang_pengguna')
            ->where('user_id', $user_id)
            ->where('produk_key', $key)
            ->update([
                'jumlah' => DB::raw('jumlah + ' . $change),
                'updated_at' => now()
            ]);
    }

    /**
     * Hapus dari database keranjang
     */
    private function hapusDariDatabaseKeranjang($user_id, $key)
    {
        DB::table('keranjang_pengguna')
            ->where('user_id', $user_id)
            ->where('produk_key', $key)
            ->delete();
    }
}