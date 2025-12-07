{{-- resources/views/pages/search.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Warung Tita</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Custom CSS dari file native Anda -->
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
    
    <style>
    /* Tambahan style khusus untuk halaman pencarian */
    .search-results-page {
        margin-top: 80px; /* Agar tidak tertutup navbar */
        min-height: 70vh;
    }
    </style>
</head>
<body>

<!-- Include Header -->
@include('layouts.header')

<section class="search-results-page">
    <div class="container">
        <h2>Hasil Pencarian untuk "{{ htmlspecialchars($query) }}"</h2>
        
        @if ($total_results > 0)
            <p class="result-count">Ditemukan {{ $total_results }} produk</p>
            
            <div class="tampilan">
                @foreach ($results as $product)
                    <div class="col" onclick="window.location.href='{{ url('/transaksi/' . $product->id . '/' . $product->tabel_asal) }}';">
                        <div class="menu">
                            <div class="barang">
                                <div class="box-img">
                                    <img src="{{ asset('menu/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}">
                                    <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='{{ url('/keranjang/tambah/' . $product->tabel_asal . '-' . $product->id) }}';">
                                        <i class="bi bi-cart3"></i>
                                    </div>
                                </div>
                                <div class="title">
                                    <h3>{{ $product->nama_produk }}</h3>
                                    <p>Rp{{ number_format($product->harga_produk, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results text-center py-5">
                <img src="{{ asset('images/no-results.png') }}" alt="Tidak ada hasil" class="no-results-img mb-4">
                <h3>Produk tidak ditemukan</h3>
                <p class="mb-4">Maaf, kami tidak menemukan produk dengan kata kunci "{{ htmlspecialchars($query) }}"</p>
                <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</section>

<!-- Include Footer -->
@include('layouts.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>