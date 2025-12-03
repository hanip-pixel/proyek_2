<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .subtitle a { scroll-behavior: unset !important; }
        .tampilan { transition: opacity 0.3s ease; }
        .tampilan.loading { opacity: 0.5; }
    </style>
</head>
<body>

<div class="alert-modal" id="alertModal">
    <div class="alert-content">
        <h4>Peringatan!</h4>
        <p>Anda harus menekan tombol "Klik untuk masuk" terlebih dahulu sebelum dapat mengakses halaman ini.</p>
        <button class="btn btn-primary" onclick="document.getElementById('alertModal').style.display = 'none'">Mengerti</button>
    </div>
</div>

@include('layouts.header')

<section class="container-fluid hero-container">
    <div class="row">
        <div class="col-md-6 left">
            <div class="content">
                <h4 class="hero-title">E-commerce sembako</h4>
                <p class="hero-description">
                    Temukan beras, minyak, gula, dan bahan pokok lainnya dengan
                    kualitas terbaik. Belanja mudah, harga terjangkau, dan pengiriman
                    cepat. Lengkapi kebutuhan dapur Anda tanpa repot. Ayo, mulai
                    belanja sekarang!
                </p>
                <p class="small-text">Untuk berbagai kebutuhan.</p>
            </div>
        </div>
        <div class="col-md-6 right"></div>
    </div>
</section>

<section class="belanja">
    <div class="belanja-content">
        <h4>Belanja Kebutuhan Anda Di Sini.</h4>
        <p>
            Dengan kemudahan berbelanja secara online, Anda bisa mendapatkan produk favorit tanpa repot. Nikmati penawaran menarik dan pelayanan terbaik hanya di sini!
        </p>
    </div>
</section>

<section class="recomen-container">
    <div class="recomen">
        <div class="cul">
            <h1>Bahan Dapur</h1>
            <img src="{{ asset('images/dapur.jpg') }}" alt="Mi Sedap" class="menu-img" />
            <p>Hadirkan cita rasa terbaik dengan bahan segar dan berkualitas. Masak dengan cinta, nikmati kelezatannya!</p>
        </div>
        <div class="cul">
            <h1>Detergen</h1>
            <img src="{{ asset('images/detergen.jpg') }}" alt="Mi Sedap" class="menu-img" />
            <p>Nikmati kesegaran maksimal dengan perlengkapan mandi terbaik. Mulai hari dengan penuh energi!</p>
        </div>
        <div class="cul">
            <h1>Obat-obatan</h1>
            <img src="{{ asset('images/obat.jpg') }}" alt="Mi Sedap" class="menu-img" />
            <p>Atasi keluhan dan pulihkan tubuh dengan obat yang aman dan terpercaya. Sehat setiap hari, hidup lebih nyaman!</p>
        </div>
    </div>
</section>

<section id="belanja" class="menu-container scroll-offset">
    <div class="penanda1">
        <h5>Rekomendasi untuk anda.</h5>
        <a href="#" id="toggle-view">Lihat semua</a>
    </div>
    <ul class="subtitle">
        <li><a href="javascript:void(0)" data-filter="rekomendasi" onclick="return changeFilter('rekomendasi', event)" class="{{ ($filter == 'rekomendasi') ? 'active' : '' }}">Rekomendasi</a></li>
        <li><a href="javascript:void(0)" data-filter="terlaris" onclick="return changeFilter('terlaris', event)" class="{{ $filter == 'terlaris' ? 'active' : '' }}">Terlaris</a></li>
        <li><a href="javascript:void(0)" data-filter="terbaru" onclick="return changeFilter('terbaru', event)" class="{{ $filter == 'terbaru' ? 'active' : '' }}">Terbaru</a></li>
        <li><a href="javascript:void(0)" data-filter="stok_menipis" onclick="return changeFilter('stok_menipis', event)" class="{{ $filter == 'stok_menipis' ? 'active' : '' }}">Stok Menipis</a></li>
    </ul>

    <div class="tampilan">
        @foreach($products_rekomendasi as $product)
            <div class="col" onclick="window.location.href='{{ url('/transaksi') }}?id={{ $product->id }}&tabel={{ $product->tabel_asal }}';">
                <div class="menu">
                    <div class="barang">
                        <div class="box-img">
                            <img src="{{ asset('menu/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}">
                            <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='{{ route('keranjang.tambah', [$product->tabel_asal . '-' . $product->id]) }}';">
                                <i class="bi bi-cart3"></i>
                            </div>
                        </div>
                        <div class="title">
                            <h3>{{ $product->nama_produk }}</h3>
                            <p>Rp{{ number_format($product->harga_produk, 0, ',', '.') }}</p>
                            @if($filter == 'stok_menipis')
                                <small class="text-danger">Stok: {{ $product->stok }}</small>
                            @elseif($filter == 'terlaris' && $product->terjual)
                                <small class="text-success">Terjual: {{ $product->terjual }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="deskripsi">
    <div class="descript">
        <div class="text">
            <h2>Malas untuk datang dan bayar secara langsung?</h2>
            <img src="{{ asset('images/mager.png') }}" alt="foto" />
            <p>Warung Tita menyediakan fitur bayar menggunakan e-wallet untuk mempermudah transaksi anda!</p>
        </div>
        <div class="foto">
            <img src="{{ asset('images/payments.png') }}" alt="foto" />
        </div>
    </div>
</section>

<section id="dapur" class="barang-kategori scroll-offset">
    <div class="kategori-barang">
        <div class="navigation">
            <a href="?kategori=dapur&filter={{ $filter }}" class="navigation-dapur {{ $kategori == 'dapur' ? 'active' : '' }}">Kebutuhan Dapur</a>
            <a href="?kategori=detergen&filter={{ $filter }}" class="navigation-detergen {{ $kategori == 'detergen' ? 'active' : '' }}">Detergen</a>
            <a href="?kategori=obat&filter={{ $filter }}" class="navigation-obat {{ $kategori == 'obat' ? 'active' : '' }}">Obat-obatan</a>
        </div>
        <div class="tampilan-2">
            @foreach($products_kategori as $product)
                <div class="col" onclick="window.location.href='{{ url('/transaksi') }}?id={{ $product->id }}&tabel={{ $kategori }}';">
                    <div class="menu">
                        <div class="barang">
                            <div class="box-img">
                                <img src="{{ asset('menu/' . $product->foto_produk) }}" alt="{{ $product->nama_produk }}">
                                <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='{{ url('/keranjang') }}?tambah={{ $kategori }}-{{ $product->id }}';">
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
    </div>
</section>

<section class="last-section">
    <div class="last-content">
        <div class="text-content">
            <div class="last-title">
                <h3>Belanja Kebutuhan Harian Lebih Mudah & Hemat!</h3>
            </div>
            <div class="last-paragraft">
                <p>Belanja kebutuhan sehari-hari kini lebih praktis dan hemat di Warung Tita! Temukan berbagai bahan dapur segar, alat mandi, dan obat-obatan dengan harga terbaik. Tanpa antre, tanpa repot cukup pesan dari rumah dan kami antar langsung ke pintu Anda! <br>
                    Nikmati kemudahan belanja online dengan sistem pembayaran aman dan pengiriman cepat. Dari beras, minyak, gula, bumbu dapur, hingga sabun, sampo, pasta gigi, serta berbagai obat-obatan umum semua tersedia lengkap dalam satu tempat. <br>
                    Dapatkan promo eksklusif, diskon spesial, dan cashback menarik setiap hari! Warung Tita siap memenuhi kebutuhan rumah tangga Anda dengan kualitas terbaik dan layanan terpercaya. Belanja sekarang, lebih mudah dan hemat di Warung Tita!</p>
            </div>
        </div>
        <div class="konten-informatif">
            <div class="konten">
                <img src="{{ asset('images/shoping.png') }}" alt="">
                <div class="deskripsi-konten">
                    <h5>Belanja dengan simpel</h5>
                    <p>Berbelanja tanpa perlu keluar rumah dengan fitur yang simpel memudahkan anda untuk berbelanja</p>
                </div>
            </div>
            <div class="konten">
                <img src="{{ asset('images/transit.png') }}" alt="">
                <div class="deskripsi-konten">
                    <h5>Pengiriman aman</h5>
                    <p>Kami menyediakan jasa pengiriman dari pintu ke pintu untuk memberikan fasilitas waktu yang fleksibel</p>
                </div>
            </div>
            <div class="konten">
                <img src="{{ asset('images/receipt.png') }}" alt="">
                <div class="deskripsi-konten">
                    <h5>Jaminan barang sesuai</h5>
                    <p>Warung kami menjamin ketepatan pesanan anda dan memberikan garansi uang kembali jika barang rusak</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')

<script src="{{ asset('js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
// JavaScript code tetap sama seperti yang Anda miliki
function saveScrollPosition() {
    const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    sessionStorage.setItem('scrollPosition', scrollPosition);
}

function restoreScrollPosition() {
    const scrollPosition = sessionStorage.getItem('scrollPosition');
    if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition));
        sessionStorage.removeItem('scrollPosition');
    }
}

function changeFilter(filter, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const container = document.querySelector('.tampilan');
    container.classList.add('loading');

    const urlParams = new URLSearchParams(window.location.search);
    const kategori = urlParams.get('kategori') || 'dapur';

    // Update URL tanpa reload
    const newUrl = `?kategori=${kategori}&filter=${filter}`;
    window.history.replaceState({}, '', newUrl);

    // AJAX request ke route Laravel
    fetch(`/filter-products?kategori=${kategori}&filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateProductDisplay(data.products, filter);
                updateActiveFilter(filter);
                container.classList.remove('loading');
            } else {
                console.error('Error fetching products:', data.message);
                container.classList.remove('loading');
                // Fallback: reload page jika AJAX gagal
                window.location.href = newUrl;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            container.classList.remove('loading');
            // Fallback: reload page jika AJAX gagal
            window.location.href = newUrl;
        });

    return false;
}

function updateProductDisplay(products, filter) {
    const container = document.querySelector('.tampilan');
    container.innerHTML = '';

    products.forEach(product => {
        let additionalInfo = '';
        if (filter === 'stok_menipis') {
            additionalInfo = `<small class="text-danger">Stok: ${product.stok}</small>`;
        } else if (filter === 'terlaris' && product.terjual) {
            additionalInfo = `<small class="text-success">Terjual: ${product.terjual}</small>`;
        }

        const productHTML = `
            <div class="col" onclick="window.location.href='/transaksi?id=${product.id}&tabel=${product.tabel_asal}';">
                <div class="menu">
                    <div class="barang">
                        <div class="box-img">
                            <img src="/menu/${product.foto_produk}" alt="${product.nama_produk}">
                            <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='/keranjang/tambah/${product.tabel_asal}-${product.id}';">
                                <i class="bi bi-cart3"></i>
                            </div>
                        </div>
                        <div class="title">
                            <h3>${product.nama_produk}</h3>
                            <p>Rp${new Intl.NumberFormat('id').format(product.harga_produk)}</p>
                            ${additionalInfo}
                        </div>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML += productHTML;
    });
}

function updateActiveFilter(activeFilter) {
    document.querySelectorAll('.subtitle a').forEach(link => {
        link.classList.remove('active');
    });
    const activeLink = document.querySelector(`.subtitle a[data-filter="${activeFilter}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const kategori = urlParams.get('kategori') || 'dapur';
    const currentFilter = urlParams.get('filter') || 'rekomendasi';
    
    updateActiveFilter(currentFilter);
    
    document.querySelectorAll('.navigation a').forEach(link => {
        link.classList.remove('active');
    });
    const activeCategory = document.querySelector(`.navigation-${kategori}`);
    if (activeCategory) {
        activeCategory.classList.add('active');
    }
});
</script>

</body>
</html>