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
                    <p>Tanggal: {{ \Carbon\Carbon::parse($transaksi_terakhir->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</p>
                    <p class="riwayat-harga">Total: Rp {{ number_format($transaksi_terakhir->total_harga, 0, ',', '.') }}</p>
                    <!-- Tampilkan detail biaya jika ada -->
                    @php
                        $harga_barang = $transaksi_terakhir->harga_produk * $transaksi_terakhir->quantity;
                        $biaya_tambahan = $transaksi_terakhir->total_harga - $harga_barang;
                    @endphp
                    @if($biaya_tambahan > 0)
                        <p class="small text-muted mb-0">
                            (Termasuk ongkir, layanan, dan jasa)
                        </p>
                    @endif
                </div>
              </div>
            </div>
            <!-- Bagian Status Pembelian Terakhir -->

            <div class="right-section">
            <div class="right-box">
                <h3>Status Pembelian Terakhir</h3>
            </div>
            
            <!-- Status 1: Dikemas -->
            <div class="informasi">
                <div class="info">
                    <div class="circle {{ $transaksi_terakhir->status == 'dikemas' || $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                    <div class="line {{ $transaksi_terakhir->status == 'dikemas' || $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}" style="width: 3px; height: 150px;"></div>
                </div>
                <div class="keterangan">
                    <div class="information">
                        <h3>Barang sedang di kemas</h3>
                        <p>Kami sedang mengemas pesanan anda, mohon menunggu beberapa saat!</p>
                    </div>
                </div>
            </div>
            
            <!-- Status 2: Dikirim -->
            <div class="informasi">
                <div class="info-2">
                    <div class="circle-2 {{ $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                    <div class="line-2 {{ $transaksi_terakhir->status == 'dikirim' || $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}" style="width: 3px; height: 150px;"></div>
                </div>
                <div class="keterangan">
                    <div class="information-2">
                        <h3>Barang di hantarkan</h3>
                        <p>Kurir kami sedang mengantarkan pesanan anda, mohon menunggu sebentar!</p>
                    </div>
                </div>
            </div>
            
            <!-- Status 3: Selesai -->
            <div class="informasi">
                <div class="info-3">
                    <div class="circle-3 {{ $transaksi_terakhir->status == 'selesai' ? 'active' : '' }}"></div>
                    <!-- Tidak ada garis di status terakhir -->
                </div>
                <div class="keterangan">
                    <div class="information-3">
                        <h3>Barang telah di terima</h3>
                        <p>Barang telah di terima, terimakasih telah berbelanja.</p>
                    </div>
                </div>
            </div>
            </div>        </div>
    </section>
    @endif

    <section class="riwayat-container">
        <h3>Semua Riwayat Pembelian</h3>

        @if(count($transaksi_dikelompokkan) > 0)
            @foreach($transaksi_dikelompokkan as $tanggal => $kelompok_transaksi)
                @php
                    // Hitung total untuk grup tanggal ini
                    $total_grup = 0;
                    foreach ($kelompok_transaksi as $transaksi) {
                        $total_grup += $transaksi->total_harga;
                    }
                @endphp
                
                <div class="transaction-group">
                    <div class="transaction-date">
                        <h4>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h4>
                        <!-- Tampilkan total per grup -->
                        <div class="group-total">
                            <strong>Total Pesanan: Rp {{ number_format($total_grup, 0, ',', '.') }}</strong>
                        </div>
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
                            <p>Tanggal: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</p>
                            <!-- Tampilkan harga asli dan total -->
                            <p class="text-muted mb-1">
                                Harga Barang: Rp {{ number_format($transaksi->harga_produk, 0, ',', '.') }} × {{ $transaksi->quantity }}
                            </p>
                            @php
                                $harga_barang = $transaksi->harga_produk * $transaksi->quantity;
                                $biaya_tambahan = $transaksi->total_harga - $harga_barang;
                            @endphp
                            @if($biaya_tambahan > 0)
                                <p class="text-muted mb-1">
                                    Biaya Tambahan: Rp {{ number_format($biaya_tambahan, 0, ',', '.') }}
                                    @if($transaksi->ongkir > 0 || $transaksi->layanan > 0 || $transaksi->jasa > 0)
                                        (Ongkir: {{ number_format($transaksi->ongkir, 0, ',', '.') }}, 
                                         Layanan: {{ number_format($transaksi->layanan, 0, ',', '.') }}, 
                                         Jasa: {{ number_format($transaksi->jasa, 0, ',', '.') }})
                                    @endif
                                </p>
                            @endif
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