<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <section class="search-results">
        <div class="container">
            <h2>Hasil Pencarian untuk "{{ htmlspecialchars($searchQuery) }}"</h2>
            
            @if($totalResults > 0)
                <p class="result-count">Ditemukan {{ $totalResults }} produk</p>
                
                <div class="tampilan">
                    @foreach($results as $product)
                        <div class="col" onclick="window.location.href='{{ route('transaksi', ['id' => $product->id, 'tabel' => $product->tabel_asal]) }}'">
                            <div class="menu">
                                <div class="barang">
                                    <div class="box-img">
                                        <img src="{{ asset('menu/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}">
                                        <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='{{ route('keranjang.tambah', ['type' => $product->tabel_asal, 'id' => $product->id]) }}'">
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
                <div class="no-results">
                    <img src="{{ asset('images/no-results.png') }}" alt="Tidak ada hasil" class="no-results-img">
                    <h3>Produk tidak ditemukan</h3>
                    <p>Maaf, kami tidak menemukan produk dengan kata kunci "{{ htmlspecialchars($searchQuery) }}"</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Beranda</a>
                </div>
            @endif
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>