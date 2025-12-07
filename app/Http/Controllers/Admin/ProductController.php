<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $tables = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        $all_products = [];

        foreach ($tables as $table) {
            $products = DB::table($table)
                ->select('*', DB::raw("'$table' as kategori"))
                ->get()
                ->map(function ($item) use ($table) {
                    // Normalisasi field stok
                    $item->stok = $item->stok_produk ?? $item->stok ?? 0;
                    $item->terjual = $item->terjual ?? 0;
                    return $item;
                })
                ->toArray();
            
            $all_products = array_merge($all_products, $products);
        }

        return view('admin.products.index', compact('all_products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tabel' => 'required|in:dapur,detergen,obat,rekomendasi',
            'nama_produk' => 'required|string|max:50',
            'merek' => 'nullable|string|max:50',  // Tambahkan validasi merek
            'harga_produk' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',  // Ubah dari 'stok_produk' ke 'stok'
            'deskripsi' => 'required|string',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // Hapus ongkir, layanan, jasa jika tidak ada di tabel
        ]);

        DB::beginTransaction();
        try {
            $tabel = $request->tabel;
            
            // Handle file upload dengan nama lebih pendek
            $fileName = null;
            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $extension = $file->getClientOriginalExtension();
                $fileName = 'prod_' . time() . '.' . $extension;  // Nama lebih pendek
                
                $uploadPath = public_path('menu');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $fileName);
            }
            
            // Siapkan data sesuai struktur migration
            $data = [
                'nama_produk' => $request->nama_produk,
                'merek' => $request->merek ?? 'Generic',
                'harga_produk' => $request->harga_produk,
                'stok' => $request->stok,  // Gunakan 'stok' bukan 'stok_produk'
                'terjual' => 0,
                'deskripsi' => $request->deskripsi,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Tambahkan foto hanya jika ada
            if ($fileName) {
                $data['foto_produk'] = $fileName;
            }
            
            Log::info("Inserting into $tabel:", $data);
            
            // Insert data
            $result = DB::table($tabel)->insert($data);
            
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'tabel' => 'required|in:dapur,detergen,obat,rekomendasi',
            'id' => 'required|integer',
            'stok' => 'required|integer|min:0',  // Tetap 'stok'
        ]);

        try {
            $affected = DB::table($request->tabel)
                ->where('id', $request->id)
                ->update([
                    'stok' => $request->stok,  // Langsung 'stok'
                    'updated_at' => now()
                ]);
                
            return redirect()->route('admin.products.index')
                ->with('success', "Stok produk berhasil diupdate!");

        } catch (\Exception $e) {
            Log::error('Error updating stock:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengupdate stok');
        }
    }

    public function destroy(Request $request, $id)
    {
        Log::info('Delete Product Request:', [
            'id' => $id,
            'tabel' => $request->tabel
        ]);
        
        $request->validate([
            'tabel' => 'required|in:dapur,detergen,obat,rekomendasi',
        ]);

        try {
            $tabel = $request->tabel;
            
            // Ambil data produk untuk logging
            $product = DB::table($tabel)->where('id', $id)->first();
            
            $deleted = DB::table($tabel)
                ->where('id', $id)
                ->delete();
                
            Log::info("Deleted $deleted row(s) from $tabel");

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting product:', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
    
    // Helper method untuk debugging
    public function debugTables()
    {
        $tables = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        $debugInfo = [];
        
        foreach ($tables as $table) {
            try {
                $columns = DB::select("SHOW COLUMNS FROM $table");
                $debugInfo[$table] = [
                    'columns' => array_column($columns, 'Field'),
                    'count' => DB::table($table)->count(),
                    'sample' => DB::table($table)->first()
                ];
            } catch (\Exception $e) {
                $debugInfo[$table] = ['error' => $e->getMessage()];
            }
        }
        
        return response()->json($debugInfo);
    }
}