<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    /**
     * Menampilkan semua ulasan
     */
    public function index()
    {
        $ulasan = DB::table('ulasan')
            ->leftJoin('balasan_ulasan', 'ulasan.id', '=', 'balasan_ulasan.ulasan_id')
            ->select(
                'ulasan.*',
                'balasan_ulasan.id as balasan_id',
                'balasan_ulasan.pesan as balasan_pesan',
                'balasan_ulasan.tanggal as balasan_tanggal',
                'balasan_ulasan.created_at as balasan_created_at'
            )
            ->orderBy('ulasan.tanggal', 'DESC')
            ->get();

        // Ambil nama produk dari tabel yang sesuai
        foreach ($ulasan as $item) {
            $produk = DB::table($item->tabel)
                ->where('id', $item->produk_id)
                ->first();
            
            $item->produk_nama = $produk ? $produk->nama_produk : 'Produk tidak ditemukan';
        }

        return view('admin.ulasan.index', compact('ulasan'));
    }

    /**
     * Menyimpan balasan admin
     */
    public function storeBalasan(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string|max:500'
        ]);

        // Cek apakah ulasan ada
        $ulasan = DB::table('ulasan')->where('id', $id)->first();
        if (!$ulasan) {
            return redirect()->back()->with('error', 'Ulasan tidak ditemukan');
        }

        // Cek apakah sudah ada balasan
        $existingBalasan = DB::table('balasan_ulasan')
            ->where('ulasan_id', $id)
            ->first();

        if ($existingBalasan) {
            // Update balasan yang ada
            DB::table('balasan_ulasan')
                ->where('id', $existingBalasan->id)
                ->update([
                    'pesan' => $request->pesan,
                    'tanggal' => now(),
                    'updated_at' => now()
                ]);
        } else {
            // Buat balasan baru
            DB::table('balasan_ulasan')->insert([
                'ulasan_id' => $id,
                'admin_id' => auth()->guard('admin')->id(),
                'pesan' => $request->pesan,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('admin.ulasan.index')
            ->with('success', 'Balasan berhasil ' . ($existingBalasan ? 'diperbarui' : 'ditambahkan'));
    }

    /**
     * Hapus ulasan
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Hapus balasan terlebih dahulu
            DB::table('balasan_ulasan')
                ->where('ulasan_id', $id)
                ->delete();

            // Hapus ulasan
            DB::table('ulasan')
                ->where('id', $id)
                ->delete();

            DB::commit();

            return redirect()->route('admin.ulasan.index')
                ->with('success', 'Ulasan berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus balasan
     */
    public function destroyBalasan($id)
    {
        DB::table('balasan_ulasan')
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.ulasan.index')
            ->with('success', 'Balasan berhasil dihapus');
    }
}