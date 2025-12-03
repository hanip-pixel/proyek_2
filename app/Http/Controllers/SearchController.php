<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->get('query', '');

        // Jika query kosong, redirect ke halaman utama
        if (empty($searchQuery)) {
            return redirect('/');
        }

        $tables = ['dapur', 'detergen', 'obat', 'rekomendasi'];
        $results = collect();

        foreach ($tables as $table) {
            $tableResults = DB::table($table)
                ->select('*', DB::raw("'$table' as tabel_asal"))
                ->where('nama_produk', 'LIKE', "%{$searchQuery}%")
                ->get();
            
            $results = $results->merge($tableResults);
        }

        $totalResults = $results->count();

        return view('pages.search', [
            'searchQuery' => $searchQuery,
            'results' => $results,
            'totalResults' => $totalResults
        ]);
    }
}