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
                // ✅ PERBAIKI: 'rekomendasi' as tabel_asal
                return Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->get();
                
            case 'terbaru':
                // ✅ PERBAIKI SEMUA: ganti 'barang' jadi 'tabel_asal'
                $rekomendasi = Rekomendasi::select('*')->selectRaw("'rekomendasi' as tabel_asal")->latest()->first();
                $dapur = Dapur::select('*')->selectRaw("'dapur' as tabel_asal")->latest()->first();
                $detergen = Detergen::select('*')->selectRaw("'detergen' as tabel_asal")->latest()->first();
                $obat = Obat::select('*')->selectRaw("'obat' as tabel_asal")->latest()->first();
                
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