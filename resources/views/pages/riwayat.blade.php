<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian - Warung Tita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>
<body>

    @include('layouts.header')

    <section class="hero">
        <div class="hero-title">
            <h3>Riwayat Pembelian</h3>
        </div>
        <div class="alamat-hp">
            <div class="informasi">
                <i class="bi bi-geo-alt-fill"></i>
                <div class="alamat">
                    @if($profil_pengguna)
                        <h4>{{ $profil_pengguna->nama }} ({{ $profil_pengguna->telepon }})</h4>
                        <p>{{ $profil_pengguna->rt_rw }}, Kec. {{ $profil_pengguna->kecamatan }}, Kab. {{ $profil_pengguna->kabupaten }}</p>
                    @else
                        <h4>Data alamat tidak ditemukan.</h4>
                        <p>Silakan lengkapi profil Anda.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($transaksi_terakhir)
    <section class="barang">
        <div class="barang-container">
            <div class="barang-section">
              <div class="riwayat-item last-transaction-summary">
                <img src="{{ asset('menu/' . $transaksi_terakhir->foto_produk) }}" alt="{{ $transaksi_terakhir->nama_produk }}" class="riwayat-img">
                <div class="riwayat-detail">
                    <div class="riwayat-header">
                        <h4>{{ $transaksi_terakhir->nama_produk }}</h4>
                        <span class="riwayat-status status-{{ $transaksi_terakhir->status }}">
                            {{ strtoupper($transaksi_terakhir->status) }}
                        </span>
                    </div>
                    <p>Jumlah: {{ $transaksi_terakhir->quantity }}</p>
                    <p>Metode Pembayaran: {{ $transaksi_terakhir->metode_pembayaran }}</p>
                    <p>Tanggal: {{ date('d M Y H:i', strtotime($transaksi_terakhir->tanggal_transaksi)) }}</p>
                    <p class="riwayat-harga">Total: Rp {{ number_format($transaksi_terakhir->total_harga, 0, ',', '.') }}</p>
                </div>
              </div>
            </div>
            <div class="right-section">
              <div class="right-box">
                <h3>Status Pembelian Terakhir</h3>
              </div>
              <div class="informasi">
                  <div class="info">
                      <div class="circle {{ $transaksi_terakhir->status == 'dikemas' || $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                      <div class="line" style="width: 3px; height: 150px;"></div>
                  </div>
                  <div class="keterangan">
                    <div class="information">
                        <h3>Barang sedang di kemas</h3>
                        <p>Kami sedang mengemas pesanan anda, mohon menunggu beberapa saat!</p>
                    </div>
                  </div>
              </div>
              <div class="informasi">
                  <div class="info-2">
                      <div class="circle-2 {{ $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                      <div class="line-2" style="width: 3px; height: 150px;"></div>
                  </div>
                  <div class="keterangan">
                    <div class="information-2">
                        <h3>Barang di hantarkan</h3>
                        <p>Kurir kami sedang mengantarkan pesanan anda, mohon menunggu sebentar!</p>
                    </div>
                  </div>
              </div>
              <div class="informasi">
                  <div class="info-3">
                      <div class="circle-3 {{ $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                  </div>
                  <div class="keterangan">
                    <div class="information-3">
                        <h3>Barang telah di terima</h3>
                        <p>Barang telah di terima, terimakasih telah berbelanja.</p>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </section>
    @endif

    <section class="riwayat-container">
        <h3>Semua Riwayat Pembelian</h3>

        @if(count($transaksi_dikelompokkan) > 0)
            @foreach($transaksi_dikelompokkan as $tanggal => $kelompok_transaksi)
                <div class="transaction-group">
                    <div class="transaction-date">
                        <h4>{{ date('d M Y H:i', strtotime($tanggal)) }}</h4>
                    </div>
                    
                    @foreach($kelompok_transaksi as $transaksi)
                    <div class="riwayat-item">
                        <img src="{{ asset('menu/' . $transaksi->foto_produk) }}" alt="{{ $transaksi->nama_produk }}" class="riwayat-img">
                        <div class="riwayat-detail">
                            <div class="riwayat-header">
                                <h4>{{ $transaksi->nama_produk }}</h4>
                                <span class="riwayat-status status-{{ $transaksi->status }}">
                                    {{ strtoupper($transaksi->status) }}
                                </span>
                            </div>
                            <p>Jumlah: {{ $transaksi->quantity }}</p>
                            <p>Metode Pembayaran: {{ $transaksi->metode_pembayaran }}</p>
                            <p class="riwayat-harga">Total: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <h3>Belum ada riwayat transaksi</h3>
                <p>Silakan melakukan pembelian terlebih dahulu</p>
            </div>
        @endif
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>