@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<h2 class="text-white mb-4">Manajemen Pesanan</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->nama_produk }}</td>
                        <td>Rp{{ number_format($order->harga_produk, 0, ',', '.') }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $order->metode_pembayaran }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->tanggal_transaksi)->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge 
                                {{ $order->status == 'dikemas' ? 'bg-warning' : 
                                   ($order->status == 'dikirim' ? 'bg-info' : 
                                   ($order->status == 'selesai' ? 'bg-success' : 'bg-secondary')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="dikemas" {{ $order->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                        <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" 
                                      onsubmit="return confirm('Hapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection