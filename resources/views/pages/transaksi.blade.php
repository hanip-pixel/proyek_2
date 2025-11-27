<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Transaksi - Warung Tita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="{{ asset('css/transaksi.css') }}" />
</head>
<body>

    @include('layouts.header')

    <section class="barang">
        <div class="barang-container">
            <div class="barang-section">
                <div class="box-barang">
                    <div class="box-img">
                        <img src="{{ asset('menu/' . $produk->foto_produk) }}" alt="{{ $produk->nama_produk }}">
                    </div>
                </div>
                <div class="box-deskripsi">
                    <h4>Deskripsi:</h4>
                    <p>{!! nl2br(str_replace('-', '<br>-', $produk->deskripsi ?? 'Tidak ada deskripsi.')) !!}</p>
                </div>
            </div>

            <div class="right-section">
                <div class="right-box">
                    <h3>{{ $produk->nama_produk }}</h3>
                    <div class="alamat">
                        <i class="bi bi-geo-alt-fill"></i>
                        <p>Indramayu</p>
                    </div>
                    <div class="info-barang">
                        <h4>Merek: {{ $produk->merek }}</h4>
                        <h3>|</h3>
                        <p>Terjual: {{ $produk->terjual }}</p>
                    </div>
                    <p>Harga: Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                    <div class="stok">
                        <h4>Stok:</h4>
                        <p>{{ $produk->stok }}</p>
                    </div>
                    <div class="validasi">
                        <div class="beli" onclick="window.location.href='{{ route('transaksi.lanjut') }}?id={{ $produk->id }}&tabel={{ $tabel }}';" style="cursor: pointer;">
                            <h3>Beli Sekarang</h3>
                        </div>
                        <a class="troli" href="{{ url('/keranjang/tambah/' . $tabel . '-' . $produk->id) }}">Tambah ke Keranjang</a>
                    </div>

                    <h4>Bagikan</h4>
                    <div class="icon-share">
                        <ul>
                            <li class="whatsapp">
                                <a href="https://wa.me/?text={{ $pesan_share }}" target="_blank">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </li>
                            <li class="facebook">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url_produk) }}" target="_blank">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            </li>
                            <li class="message">
                                <a href="mailto:?subject={{ urlencode('Lihat Produk: ' . $produk->nama_produk) }}&body={{ $pesan_share }}">
                                    <i class="bi bi-envelope"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="box-ulasan">
                    <h3>Ulasan Pembeli</h3>

                    <div class="rating-summary">
                        <div class="avg-rating">
                            <span class="rating-number">{{ $avg_rating ?: '0' }}</span>
                            <div class="stars">
                                @php
                                    $full_stars = floor($avg_rating);
                                    $half_star = ($avg_rating - $full_stars) >= 0.5;
                                    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                                @endphp
                                
                                @for ($i = 0; $i < $full_stars; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                
                                @if ($half_star)
                                    <i class="bi bi-star-half"></i>
                                @endif
                                
                                @for ($i = 0; $i < $empty_stars; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor
                            </div>
                            <span class="total-reviews">{{ $total_ulasan }} ulasan</span>
                        </div>
                    </div>

                    <div class="ulasan-form">
                        <h4>Tulis Ulasan Anda</h4>
                        <form action="{{ url("/transaksi/{$id}/{$tabel}/ulasan") }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required>
                            </div>
                            <div class="rating-input">
                                <p>Rating:</p>
                                <div class="stars-input">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                        <label for="star{{ $i }}"><i class="bi bi-star-fill"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="komentar" class="form-control" style="height: 100px; resize: none;" placeholder="Bagaimana pengalaman Anda dengan produk ini?" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Kirim Ulasan</button>
                        </form>
                    </div>

                    <hr>

                    <div class="ulasan-list">
                        @if ($total_ulasan > 0)
                            @foreach ($ulasan as $row)
                                <div class="ulasan-item">
                                    <div class="user-info">
                                        <div class="user-avatar"><i class="bi bi-person-circle"></i></div>
                                        <div class="user-details">
                                            <strong>{{ htmlspecialchars($row->nama) }}</strong>
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $row->rating)
                                                        <i class="bi bi-star-fill"></i>
                                                    @else
                                                        <i class="bi bi-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="review-date">{{ date('d M Y', strtotime($row->tanggal)) }}</div>
                                    </div>
                                    <div class="review-content">{{ nl2br(htmlspecialchars($row->komentar)) }}</div>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <p class="no-reviews">Belum ada ulasan untuk produk ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>