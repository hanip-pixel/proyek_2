<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Lanjut - Warung Tita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/transaksi_lanjut.css') }}">
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
                    <h4>Detail Pembelian:</h4>
                    <div class="detail-harga">
                        <div class="detail">
                            <p>Harga barang:
                            <br>Ongkos kirim:
                            <br>Biaya layanan:
                            <br>Biaya jasa website:
                            <br>Total:</p>
                        </div>
                        {{-- Di bagian detail harga --}}
                        <div class="harga">
                            <span id="harga-barang" data-harga="{{ $produk->harga_produk }}">
                                Rp. {{ number_format($produk->harga_produk, 0, ',', '.') }}
                            </span><br>
                            <span id="ongkir" data-ongkir="1500">
                                Rp. {{ number_format(1500, 0, ',', '.') }}
                            </span><br>
                            <span id="layanan" data-layanan="1000">
                                Rp. {{ number_format(1000, 0, ',', '.') }}
                            </span><br>
                            <span id="jasa" data-jasa="500">
                                Rp. {{ number_format(500, 0, ',', '.') }}
                            </span><br>
                            <span id="total-harga">
                                Rp. {{ number_format($produk->harga_produk + 1500 + 1000 + 500, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-section">
                <div class="right-box">
                    <h3>{{ $produk->nama_produk }}</h3>
                    <div class="alamat">
                        <i class="bi bi-geo-alt-fill"></i>
                        <p>Indramayu</p>
                    </div>
                    <div class="kuantitas-stok">
                        <h2>Rp. {{ number_format($produk->harga_produk, 0, ',', '.') }}</h2>
                        <div class="kuantitas">
                            <h3>Kuantitas:</h3>
                            <div class="plus-min">
                                <ul>
                                    <li><a href="#" class="min">-</a></li>
                                    <li><p>1</p></li>
                                    <li><a href="#" class="plus">+</a></li>
                                </ul>
                            </div>
                            <div class="stok">
                                <h4>Stok:</h4>
                                <p>{{ $produk->stok_produk }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-pembayaran">
                        <h3>Metode pembayaran</h3>
                        <a href="#" class="metode-pembayaran"><div class="box-metode">
                            <div class="gopay">
                                <div class="logo-g"></div>
                                <h4>Gopay</h4>
                            </div>
                        </div></a>
                        <a href="#" class="metode-pembayaran"><div class="box-metode-2">
                            <div class="dana">
                                <div class="logo-d"></div>
                                <h4>Dana</h4>
                            </div>
                        </div></a>
                        <a href="#" class="metode-pembayaran"><div class="box-metode-3">
                            <div class="ovo">
                                <div class="logo-o"></div>
                                <h4>Ovo</h4>
                            </div>
                        </div></a>
                        <a href="#" class="metode-pembayaran"><div class="box-metode-4">
                            <div class="cod">
                                <div class="logo-c"></div>
                                <h4>Cod bayar ditempat</h4>
                            </div>
                        </div></a>
                    </div>
                    <div class="box-ulasan">
                        <h3>Ulasan Penjual</h3>
                        <div class="botom-sec">
                            <p>Barang yang sudah di bayar tidak bisa di batalkan!</p>
                            <form id="form-beli" action="{{ route('transaksi.proses') }}" method="post">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $id }}">
                                <input type="hidden" name="tabel" value="{{ $tabel }}">
                                <input type="hidden" name="metode_pembayaran" id="input-metode" value="">
                                <input type="hidden" name="quantity" id="input-quantity" value="1">
                                <input type="hidden" name="total_harga" id="input-total" value="{{ $produk->harga_produk + $produk->ongkir + $produk->layanan + $produk->jasa }}">
                                <a href="#" id="btn-beli">Beli Sekarang</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const minBtn = document.querySelector('.min');
            const plusBtn = document.querySelector('.plus');
            const qtyElem = document.querySelector('.kuantitas ul li p');

            const hargaBarangElem = document.getElementById('harga-barang');
            const ongkirElem = document.getElementById('ongkir');
            const layananElem = document.getElementById('layanan');
            const jasaElem = document.getElementById('jasa');
            const totalHargaElem = document.getElementById('total-harga');

            // Di bagian JavaScript, update dengan biaya tetap
            const ongkir = 1500;
            const layanan = 1000;
            const jasa = 500;

            function updateHarga() {
                const totalHargaBarang = hargaBarang * quantity;
                const total = totalHargaBarang + ongkir + layanan + jasa;

                hargaBarangElem.textContent = "Rp. " + formatRupiah(totalHargaBarang);
                totalHargaElem.textContent = "Rp. " + formatRupiah(total);
            }

            minBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (quantity > 1) {
                    quantity--;
                    qtyElem.textContent = quantity;
                    updateHarga();
                }
            });

            plusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                quantity++;
                qtyElem.textContent = quantity;
                updateHarga();
            });

            updateHarga();

            const metodeLinks = document.querySelectorAll('.metode-pembayaran');
            const btnBeli = document.getElementById('btn-beli');
            const inputMetode = document.getElementById('input-metode');
            const inputQuantity = document.getElementById('input-quantity');
            const inputTotal = document.getElementById('input-total');
            let metodeDipilih = false;
            let metodeTerpilih = '';

            metodeLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    metodeLinks.forEach(l => l.classList.remove('selected'));
                    this.classList.add('selected');
                    metodeDipilih = true;

                    if (this.querySelector('.gopay')) {
                        metodeTerpilih = 'Gopay';
                    } else if (this.querySelector('.dana')) {
                        metodeTerpilih = 'Dana';
                    } else if (this.querySelector('.ovo')) {
                        metodeTerpilih = 'Ovo';
                    } else if (this.querySelector('.cod')) {
                        metodeTerpilih = 'COD';
                    }

                    inputMetode.value = metodeTerpilih;
                });
            });

            btnBeli.addEventListener('click', function(e) {
                if (!metodeDipilih) {
                    e.preventDefault();
                    alert('Silakan pilih metode pembayaran terlebih dahulu.');
                } else {
                    inputQuantity.value = qtyElem.textContent;
                    inputTotal.value = document.getElementById('total-harga').textContent.replace('Rp. ', '').replace(/\./g, '');
                    document.getElementById('form-beli').submit();
                }
            });
        });
    </script>

</body>
</html>