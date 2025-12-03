<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total pesanan dan pengguna
        $total_pesanan = DB::table('riwayat_transaksi')->count();
        $total_pengguna = DB::table('pengguna')->count();

        // Data penjualan per minggu
        $data_penjualan = DB::table('riwayat_transaksi')
            ->select(
                DB::raw('YEARWEEK(tanggal_transaksi) as minggu'),
                'nama_produk',
                DB::raw('SUM(quantity) as total_terjual')
            )
            ->where('status', 'selesai')
            ->groupBy('minggu', 'nama_produk')
            ->orderBy('minggu', 'DESC')
            ->orderBy('total_terjual', 'DESC')
            ->get();

        // Format data untuk chart
        $chart_data = $this->formatChartData($data_penjualan);

        return view('admin.dashboard.index', compact(
            'total_pesanan',
            'total_pengguna',
            'chart_data'
        ));
    }

    private function formatChartData($data_penjualan)
    {
        $labels = [];
        $datasets = [];

        foreach ($data_penjualan as $item) {
            $minggu = $item->minggu;
            $tahun = substr($minggu, 0, 4);
            $minggu_angka = substr($minggu, 4);
            $label = "Minggu $minggu_angka, $tahun";

            if (!in_array($label, $labels)) {
                $labels[] = $label;
            }

            if (!isset($datasets[$item->nama_produk])) {
                $datasets[$item->nama_produk] = [];
            }

            $datasets[$item->nama_produk][$minggu] = $item->total_terjual;
        }

        // Ambil 5 produk terlaris
        $top_produk = collect($datasets)
            ->map(function($data) {
                return array_sum($data);
            })
            ->sortDesc()
            ->take(5)
            ->keys()
            ->toArray();

        // Siapkan data untuk chart
        $chart_data = [];
        foreach ($top_produk as $produk) {
            $data_series = [];
            foreach ($labels as $label) {
                $minggu = array_search($label, $labels);
                $data_series[] = $datasets[$produk][$minggu] ?? 0;
            }
            $chart_data[] = [
                'label' => $produk,
                'data' => $data_series
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $chart_data
        ];
    }
}