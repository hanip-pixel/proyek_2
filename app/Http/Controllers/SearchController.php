<?php
// app/Http/Controllers/SearchController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Jika query kosong, redirect ke home
        if (empty($query)) {
            return redirect('/');
        }
        
        // Tabel yang akan dicari
        $tables = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        $results = [];
        
        foreach ($tables as $table) {
            $products = DB::table($table)
                ->where('nama_produk', 'like', '%' . $query . '%')
                ->get();
            
            // Tambahkan field tabel_asal ke setiap produk
            foreach ($products as $product) {
                $product->tabel_asal = $table;
                $results[] = $product;
            }
        }
        
        $total_results = count($results);
        
        // Return view langsung tanpa layout
        return view('pages.search', [
            'results' => $results,
            'total_results' => $total_results,
            'query' => $query
        ]);
    }
}