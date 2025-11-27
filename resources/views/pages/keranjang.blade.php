<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/keranjang.css') }}">
</head>
<body>

    @include('layouts.header')

    <section class="hero">
      <div class="hero-title">
        <h3>Keranjang Belanja</h3>
      </div>
      
      <!-- Notifikasi -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      <div class="keranjang-section">
        <div class="keranjang">
          <div class="keranjang-hero">
            @if(empty($keranjang))
                <div class="alert alert-info">Keranjang belanja kosong</div>
            @else
                @foreach($keranjang as $key => $item)
                    <div class="box-barang">
                      <div class="box-img">
                        <img src="{{ asset('menu/' . $item['foto']) }}" alt="{{ $item['nama'] }}">
                      </div>
                      <h4>{{ $item['nama'] }}</h4>
                      <div class="right">
                        <h5>Rp{{ number_format($item['harga'], 0, ',', '.') }}</h5>
                        <div class="botom">
                          <a href="{{ route('keranjang.hapus', $key) }}"><i class="bi bi-trash3-fill"></i></a>
                          <div class="plus-min">
                            <a href="{{ route('keranjang.kurang', $key) }}" class="min">-</a>
                            <p>{{ $item['jumlah'] }}</p>
                            <a href="{{ route('keranjang.tambah', $key) }}">+</a>
                          </div>
                        </div>
                      </div>
                    </div>
                @endforeach
            @endif
          </div>
          <div class="right-bar"></div>
        </div>
        <div class="right-section">
          <div class="right-box">
            <h3>Ringkasan Belanja</h3>
          </div>
          <div class="box-ringkasan">
            <div class="total-harga">
              <h4>Total:</h4>
              <p>Rp{{ number_format($total, 0, ',', '.') }}</p>
            </div>
            <hr>
            <div class="note">
              <p>Total harga tidak termasuk dengan ongkos kirim dan biaya lainnya!</p>
            </div>
            @if(!empty($keranjang))
                <form method="post" action="{{ route('keranjang.checkout') }}" id="checkoutForm">
                  @csrf
                  <div class="box-pembayaran">
                      <h3>Metode pembayaran</h3>
                      <div class="metode-options">
                          <label class="metode-pembayaran">
                              <input type="radio" name="metode_pembayaran" value="Gopay" required>
                              <div class="box-metode">
                                <div class="gopay">
                                  <div class="logo-g"></div>
                                  <h4>Gopay</h4>
                                </div>
                              </div>
                          </label>
                          <label class="metode-pembayaran">
                              <input type="radio" name="metode_pembayaran" value="Dana">
                              <div class="box-metode-2">
                                <div class="dana">
                                  <div class="logo-d"></div>
                                  <h4>Dana</h4>
                                </div>
                              </div>
                          </label>
                          <label class="metode-pembayaran">
                              <input type="radio" name="metode_pembayaran" value="Ovo">
                              <div class="box-metode-3">
                                <div class="ovo">
                                  <div class="logo-o"></div>
                                  <h4>Ovo</h4>
                                </div>
                              </div>
                          </label>
                          <label class="metode-pembayaran">
                              <input type="radio" name="metode_pembayaran" value="COD">
                              <div class="box-metode-4">
                                <div class="cod">
                                  <div class="logo-c"></div>
                                  <h4>Cod</h4>
                                </div>
                              </div>
                          </label>
                      </div>
                  </div>
                  <button type="submit" name="checkout" class="btn btn-primary mt-3" id="checkoutButton">Beli Sekarang</button>
                </form>
            @endif
          </div>
        </div>
      </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Script untuk menampilkan metode pembayaran yang dipilih
    document.querySelectorAll('.metode-pembayaran').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.metode-pembayaran').forEach(i => {
                i.classList.remove('selected');
            });
            this.classList.add('selected');
        });
    });
    
    // Validasi metode pembayaran sebelum submit
    document.getElementById('checkoutForm')?.addEventListener('submit', function(e) {
        const metodeDipilih = document.querySelector('input[name="metode_pembayaran"]:checked');
        
        if (!metodeDipilih) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu!');
            return false;
        }
        
        return true;
    });
    </script>
</body>
</html>