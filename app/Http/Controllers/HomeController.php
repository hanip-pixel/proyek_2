<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dapur;
use App\Models\Detergen;
use App\Models\Obat;
use App\Models\Rekomendasi;

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
    
    private function getFilteredProducts($filter)
    {
        switch ($filter) {
            case 'rekomendasi':
                return Rekomendasi::select('*')->selectRaw("'rekomendasi' as barang")->get();
                
            case 'terbaru':
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as barang")->latest()->first();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as barang")->latest()->first();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as barang")->latest()->first();
                $obat = Obat::select('*')->selectRaw("'obat' as barang")->latest()->first();
                
                return collect([$rekomendasi, $dapur, $detergen, $obat])->filter()->take(6);
                
            case 'stok_menipis':
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as barang")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as barang")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as barang")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                $obat = Obat::select('*')->selectRaw("'obat' as barang")->where('stok', '<', 5)->orderBy('stok')->take(6)->get();
                
                $result = $rekomendasi->concat($dapur)->concat($detergen)->concat($obat)->sortBy('stok')->take(6);
                return $result->isEmpty() ? collect() : $result;
                
            case 'terlaris':
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as barang")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as barang")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as barang")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                $obat = Obat::select('*')->selectRaw("'obat' as barang")->where('terjual', '>', 150)->orderByDesc('terjual')->take(6)->get();
                
                $result = $rekomendasi->concat($dapur)->concat($detergen)->concat($obat)->sortByDesc('terjual')->take(6);
                
                if ($result->isEmpty()) {
                    $dapur = Dapur::select('*')->selectRaw("'dapur' as barang")->orderByDesc('terjual')->take(6)->get();
                    $detergen = Detergen::select('*')->selectRaw("'detergen' as barang")->orderByDesc('terjual')->take(6)->get();
                    $obat = Obat::select('*')->selectRaw("'obat' as barang")->orderByDesc('terjual')->take(6)->get();
                    return $dapur->concat($detergen)->concat($obat)->sortByDesc('terjual')->take(6);
                }
                
                return $result;
                
            default:
                return Rekomendasi::select('*')->selectRaw("'rekomendasi' as barang")->get();
        }
    }
    
    private function getCategoryProducts($kategori)
    {
        switch ($kategori) {
            case 'detergen':
                return Detergen::all();
            case 'obat':
                return Obat::all();
            default: // 'dapur'
                return Dapur::all();
        }
    }
}