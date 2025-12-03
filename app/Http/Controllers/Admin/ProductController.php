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
        // Debug input
        Log::info('====== PRODUCT STORE REQUEST ======');
        Log::info('All Input:', $request->all());
        Log::info('Files:', $request->files->all());

        $request->validate([
            'tabel' => 'required|in:dapur,detergen,obat,rekomendasi',
            'nama_produk' => 'required|string|max:50',
            'harga_produk' => 'required|integer|min:0',
            'stok_produk' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'ongkir' => 'required|integer|min:0',
            'layanan' => 'required|integer|min:0',
            'jasa' => 'required|integer|min:0',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $tabel = $request->tabel;
            
            // Cek struktur tabel
            Log::info("Checking table structure: $tabel");
            $columns = DB::select("SHOW COLUMNS FROM $tabel");
            $columnNames = array_column($columns, 'Field');
            Log::info("Columns in $tabel:", $columnNames);
            
            // Handle file upload
            $fileName = null;
            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $file->getClientOriginalName());
                $uploadPath = public_path('menu');
                
                // Pastikan folder ada
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $fileName);
                Log::info('File uploaded to:', ['path' => $uploadPath . '/' . $fileName]);
            } else {
                Log::warning('No file uploaded!');
            }
            
            // Siapkan data berdasarkan struktur tabel yang sebenarnya
            $data = [];
            
            // Field wajib
            $data['nama_produk'] = $request->nama_produk;
            $data['harga_produk'] = $request->harga_produk;
            $data['deskripsi'] = $request->deskripsi;
            
            // Field stok - cek nama kolom yang benar
            if (in_array('stok_produk', $columnNames)) {
                $data['stok_produk'] = $request->stok_produk;
            } elseif (in_array('stok', $columnNames)) {
                $data['stok'] = $request->stok_produk;
            } else {
                Log::error("No stock column found in table $tabel");
                throw new \Exception("Kolom stok tidak ditemukan di tabel $tabel");
            }
            
            // Field opsional berdasarkan tabel
            if (in_array('ongkir', $columnNames)) $data['ongkir'] = $request->ongkir;
            if (in_array('layanan', $columnNames)) $data['layanan'] = $request->layanan;
            if (in_array('jasa', $columnNames)) $data['jasa'] = $request->jasa;
            if (in_array('merek', $columnNames)) $data['merek'] = $request->merek ?? 'Generic';
            if (in_array('terjual', $columnNames)) $data['terjual'] = 0;
            if (in_array('foto_produk', $columnNames) && $fileName) {
                $data['foto_produk'] = $fileName;
            }
            
            Log::info("Data to insert into $tabel:", $data);
            
            // Insert data
            $result = DB::table($tabel)->insert($data);
            Log::info("Insert result: " . ($result ? 'Success' : 'Failed'));
            
            // Dapatkan ID yang baru saja diinsert
            $newId = DB::table($tabel)->max('id');
            Log::info("New product ID: $newId");
            
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan! ID: ' . $newId);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateStock(Request $request)
    {
        Log::info('Update Stock Request:', $request->all());
        
        $request->validate([
            'tabel' => 'required|in:dapur,detergen,obat,rekomendasi',
            'id' => 'required|integer',
            'stok' => 'required|integer|min:0',
        ]);

        try {
            $tabel = $request->tabel;
            $id = $request->id;
            $newStock = $request->stok;
            
            // Cek field stok yang benar
            $columns = DB::select("SHOW COLUMNS FROM $tabel");
            $columnNames = array_column($columns, 'Field');
            
            $stokField = 'stok';
            if (in_array('stok_produk', $columnNames)) {
                $stokField = 'stok_produk';
            }
            
            Log::info("Updating $stokField to $newStock for ID $id in $tabel");
            
            $affected = DB::table($tabel)
                ->where('id', $id)
                ->update([$stokField => $newStock]);
                
            Log::info("Rows affected: $affected");

            return redirect()->route('admin.products.index')
                ->with('success', "Stok produk berhasil diupdate menjadi $newStock!");

        } catch (\Exception $e) {
            Log::error('Error updating stock:', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Gagal mengupdate stok: ' . $e->getMessage());
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