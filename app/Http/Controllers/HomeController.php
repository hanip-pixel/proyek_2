<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dapur;
use App\Models\Detergen;
use App\Models\Obat;
use App\Models\Rekomendasi;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'rekomendasi');
        $kategori = $request->get('kategori', 'dapur');
        
        // Ambil produk berdasarkan filter
        $products_rekomendasi = $this->getFilteredProducts($filter);
        
        // Ambil produk berdasarkan kategori
        $products_kategori = $this->getCategoryProducts($kategori);
        
        return view('pages.index', compact(
            'filter', 
            'kategori', 
            'products_rekomendasi', 
            'products_kategori'
        ));
    }
    
    // Method baru untuk handle AJAX request
    public function filterProducts(Request $request)
    {
        $filter = $request->get('filter', 'rekomendasi');
        $kategori = $request->get('kategori', 'dapur');
        
        $products = $this->getFilteredProducts($filter);
        
        return response()->json([
            'success' => true,
            'products' => $products,
            'filter' => $filter
        ]);
    }
    
    private function getFilteredProducts($filter)
    {
        switch ($filter) {
            case 'rekomendasi':
                return Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->get();
                
            case 'terbaru':
                // Gunakan kolom 'id' sebagai pengganti created_at
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->orderBy('id', 'desc')->first();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->orderBy('id', 'desc')->first();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->orderBy('id', 'desc')->first();
                $obat = Obat::select('*')->selectRaw("'obat' as tabel_asal")->orderBy('id', 'desc')->first();
                
                return collect([$rekomendasi, $dapur, $detergen, $obat])->filter()->take(6);
                
            case 'stok_menipis':
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $obat = Obat::select('*')->selectRaw("'obat' as tabel_asal")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                
                $result = $rekomendasi->concat($dapur)->concat($detergen)->concat($obat)->sortBy('stok')->take(6);
                return $result->isEmpty() ? collect() : $result;
                
            case 'terlaris':
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $obat = Obat::select('*')->selectRaw("'obat' as tabel_asal")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                
                $result = $rekomendasi->concat($dapur)->concat($detergen)->concat($obat)->sortByDesc('terjual')->take(6);
                
                if ($result->isEmpty()) {
                    $dapur = Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->orderByDesc('terjual')->take(6)->get();
                    $detergen = Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->orderByDesc('terjual')->take(6)->get();
                    $obat = Obat::select('*')->selectRaw("'obat' as tabel_asal")->orderByDesc('terjual')->take(6)->get();
                    return $dapur->concat($detergen)->concat($obat)->sortByDesc('terjual')->take(6);
                }
                
                return $result;
                
            default:
                return Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->get();
        }
    }
    
    private function getCategoryProducts($kategori)
    {
        switch ($kategori) {
            case 'detergen':
                return Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->get();
            case 'obat':
                return Obat::select('*')->selectRaw("'obat' as tabel_asal")->get();
            default: // 'dapur'
                return Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->get();
        }
    }
}