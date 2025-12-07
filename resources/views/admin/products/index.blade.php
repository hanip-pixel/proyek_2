@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-white">Daftar Produk</h2>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
        <i class="bi bi-plus"></i> Tambah Produk
    </button>
</div>

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
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_products as $produk)
                    <tr>
                        <td>{{ $produk->id }}</td>
                        <td>
                            <img src="{{ asset('menu/' . $produk->foto_produk) }}" 
                                alt="{{ $produk->nama_produk }}" width="50" class="rounded">
                        </td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ ucfirst($produk->kategori) }}</td>
                        <td>Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.products.update-stock') }}" class="d-flex">
                                @csrf
                                <input type="hidden" name="tabel" value="{{ $produk->kategori }}">
                                <input type="hidden" name="id" value="{{ $produk->id }}">
                                <input type="number" name="stok" value="{{ $produk->stok }}" 
                                       class="form-control form-control-sm" style="width: 80px;">
                                <button type="submit" class="btn btn-sm btn-success ms-2">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $produk->terjual }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.products.destroy', $produk->id) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="tabel" value="{{ $produk->kategori }}">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahProdukModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="tabel" class="form-select" required>
                            <option value="dapur">Dapur</option>
                            <option value="detergen">Detergen</option>
                            <option value="obat">Obat</option>
                            <option value="rekomendasi">Rekomendasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga_produk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Ongkir</label>
                        <input type="number" name="ongkir" class="form-control" value="1500" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Layanan</label>
                        <input type="number" name="layanan" class="form-control" value="1000" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Biaya Jasa</label>
                        <input type="number" name="jasa" class="form-control" value="500" required>
                    </div> --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="foto_produk" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Tambah di index.blade.php -->

<script>
function openModal() {
    console.log('Opening modal manually');
    const modal = new bootstrap.Modal(document.getElementById('tambahProdukModal'));
    modal.show();
}
</script>
@endsection