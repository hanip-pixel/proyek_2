<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('riwayat_transaksi')
            ->orderBy('tanggal_transaksi', 'DESC')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikemas,dikirim,selesai',
        ]);

        DB::table('riwayat_transaksi')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function destroy($id)
    {
        DB::table('riwayat_transaksi')
            ->where('id', $id)
            ->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }
}