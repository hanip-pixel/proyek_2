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
    <style>
        /* Alert positioning */
        .alert-container {
            position: fixed;
            top: 80px; /* Di bawah navbar */
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 500px;
            animation: slideDown 0.5s ease-out;
        }
        
        @keyframes slideDown {
            from {
                transform: translateX(-50%) translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }
        
        .alert {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Rating Stars Styling */
        .rating-input {
            margin-bottom: 15px;
        }
        
        .stars-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }
        
        .stars-input input[type="radio"] {
            display: none;
        }
        
        .stars-input label {
            cursor: pointer;
            font-size: 24px;
            color: #ddd;
            transition: color 0.2s;
            margin: 0;
            padding: 0;
        }
        
        .stars-input label:hover,
        .stars-input label:hover ~ label {
            color: #ffc107 !important;
        }
        
        .stars-input input[type="radio"]:checked ~ label {
            color: #ffc107 !important;
        }
        
        .stars-input label i {
            color: inherit;
        }
        
        .stars-input input[type="radio"]:checked + label i {
            color: #ffc107 !important;
        }
        
        /* Ulasan Item Styling */
        .ulasan-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        
        .review-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .no-reviews {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }
        
        /* Product share icons */
        .icon-share ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .icon-share li {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .icon-share li.whatsapp {
            background-color: #25D366;
        }
        
        .icon-share li.facebook {
            background-color: #3b5998;
        }
        
        .icon-share li.message {
            background-color: #EA4335;
        }
        
        .icon-share li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        
        /* Product info styling */
        .info-barang {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        
        .stok {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        
        .validasi {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }

        .beli {
            background-color: #32de32;
            padding: 12px 30px;
            border-radius: 50px;
            display: inline-block;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            min-width: 600px;
            text-align: center;
        }

        .troli {
            background-color: #f4e66b;
            color: var(--text-2);
            font-size: 20px;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 50px;
            display: inline-block;
            text-decoration: none;
            min-width: 600px;
            text-align: center;
            transition: background-color 0.3s;
        }        
        .barang {
            margin-top: 20px;
        }
        
        /* BALASAN ADMIN STYLING - BARU */
        .balasan-admin {
            margin-top: 15px;
            padding: 12px 15px;
            background-color: #e8f4fd;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            position: relative;
        }
        
        .balasan-admin:before {
            content: '';
            position: absolute;
            top: -8px;
            left: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #e8f4fd;
        }
        
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background-color: #007bff;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .admin-badge i {
            font-size: 0.9rem;
        }
        
        .balasan-text {
            margin-top: 8px;
            color: #2c3e50;
            line-height: 1.5;
        }
        
        .balasan-date {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .reply-indicator {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #007bff;
            font-size: 0.9rem;
            margin-top: 10px;
        }
        
        .reply-indicator i {
            font-size: 1rem;
        }
    </style>
</head>
<body>

    @include('layouts.header')
    
    <!-- ALERT CONTAINER DI BAWAH HEADER -->
    @if(session('success') || session('error') || $errors->any())
    <div class="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div class="flex-grow-1">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div class="flex-grow-1">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
    @endif

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
                        <h4>Merek: {{ $produk->merek ?? 'Tidak ada merek' }}</h4>
                        <h3>|</h3>
                        <p>Terjual: {{ $produk->terjual ?? 0 }}</p>
                    </div>
                    <p>Harga: Rp{{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                    <div class="stok">
                        <h4>Stok:</h4>
                        <p>{{ $produk->stok ?? 0 }}</p>
                    </div>
                    <div class="validasi">
                        <div class="beli" onclick="window.location.href='{{ route('transaksi.lanjut') }}?id={{ $produk->id }}&tabel={{ $tabel }}';">
                            <h3>Beli Sekarang</h3>
                        </div>
                        <a class="troli" href="{{ route('keranjang.tambah', [$tabel . '-' . $produk->id]) }}">Tambah ke Keranjang</a>
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
                                    <i class="bi bi-star-fill text-warning"></i>
                                @endfor
                                
                                @if ($half_star)
                                    <i class="bi bi-star-half text-warning"></i>
                                @endif
                                
                                @for ($i = 0; $i < $empty_stars; $i++)
                                    <i class="bi bi-star text-warning"></i>
                                @endfor
                            </div>
                            <span class="total-reviews">{{ $total_ulasan }} ulasan</span>
                        </div>
                    </div>

                    @if(Session::get('loggedin'))
                    <div class="ulasan-form mt-4">
                        <h4>Tulis Ulasan Anda</h4>
                        
                        <form action="{{ route('transaksi.ulasan.store', ['id' => $id, 'tabel' => $tabel]) }}" method="POST">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama Anda</label>
                                <input type="text" 
                                       name="nama" 
                                       id="nama" 
                                       class="form-control" 
                                       placeholder="Masukkan nama Anda" 
                                       value="{{ Session::get('username') ? Session::get('username') : '' }}"
                                       required>
                                <small class="text-muted">Nama akan ditampilkan di ulasan</small>
                            </div>
                            
                            <div class="rating-input mb-3">
                                <label class="form-label d-block">Rating</label>
                                <div class="stars-input">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" 
                                               id="star{{ $i }}" 
                                               name="rating" 
                                               value="{{ $i }}"
                                               class="rating-star"
                                               required>
                                        <label for="star{{ $i }}" title="{{ $i }} bintang">
                                            <i class="bi bi-star-fill"></i>
                                        </label>
                                    @endfor
                                </div>
                                <small class="text-muted">Pilih rating 1-5 bintang</small>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="komentar" class="form-label">Komentar</label>
                                <textarea name="komentar" 
                                          id="komentar" 
                                          class="form-control" 
                                          rows="4" 
                                          placeholder="Bagaimana pengalaman Anda dengan produk ini? (maks. 500 karakter)"
                                          maxlength="500"
                                          required></textarea>
                                <small class="text-muted">Maksimal 500 karakter</small>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-send"></i> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info mt-4">
                        <p class="mb-0">
                            <i class="bi bi-info-circle"></i> 
                            Anda harus <a href="{{ url('/login') }}" class="alert-link">login</a> terlebih dahulu untuk menulis ulasan.
                        </p>
                    </div>
                    @endif

                    <hr class="my-4">

                    <div class="ulasan-list">
                        @if ($total_ulasan > 0)
                            @foreach ($ulasan as $row)
                                <div class="ulasan-item">
                                    <div class="user-info d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <i class="bi bi-person-circle fs-3"></i>
                                            </div>
                                            <div class="user-details">
                                                <strong class="d-block">{{ htmlspecialchars($row->nama) }}</strong>
                                                <div class="rating text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $row->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="text-muted ms-2">{{ $row->rating }}/5</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="review-date small">
                                            {{ date('d M Y, H:i', strtotime($row->tanggal)) }}
                                        </div>
                                    </div>
                                    <div class="review-content mt-2">
                                        <p class="mb-0">{{ nl2br(htmlspecialchars($row->komentar)) }}</p>
                                    </div>
                                    
                                    <!-- BALASAN ADMIN - BARU -->
                                    @php
                                        // Ambil balasan admin untuk ulasan ini
                                        $balasan = DB::table('balasan_ulasan')
                                            ->where('ulasan_id', $row->id)
                                            ->first();
                                    @endphp
                                    
                                    @if($balasan)
                                    <div class="balasan-admin mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="admin-badge">
                                                <i class="bi bi-shield-check"></i>
                                                Admin
                                            </span>
                                            <span class="balasan-date ms-3">
                                                <i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($balasan->tanggal)->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                        <div class="balasan-text">
                                            <p class="mb-0">{{ nl2br(htmlspecialchars($balasan->pesan)) }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Indikator bahwa admin sudah membalas -->
                                    @if($balasan)
                                    <div class="reply-indicator">
                                        <i class="bi bi-reply-fill"></i>
                                        <span>Admin telah membalas ulasan ini</span>
                                    </div>
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        @else
                            <div class="no-reviews">
                                <i class="bi bi-chat-text fs-1 text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                                <p class="text-muted small">Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-container .alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Remove alert container when all alerts are closed
        const alertContainer = document.querySelector('.alert-container');
        if (alertContainer) {
            alertContainer.addEventListener('closed.bs.alert', function() {
                const remainingAlerts = this.querySelectorAll('.alert');
                if (remainingAlerts.length === 0) {
                    setTimeout(() => {
                        this.remove();
                    }, 300);
                }
            });
        }
        
        // Rating stars functionality
        const starInputs = document.querySelectorAll('.stars-input input[type="radio"]');
        const starLabels = document.querySelectorAll('.stars-input label');
        
        // Initialize stars color
        starLabels.forEach(label => {
            const icon = label.querySelector('i');
            icon.style.color = '#ddd';
        });
        
        // Add click event to labels
        starLabels.forEach(label => {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                const inputId = this.getAttribute('for');
                const input = document.getElementById(inputId);
                
                input.checked = true;
                updateStarsDisplay(input.value);
            });
        });
        
        // Function to update stars display
        function updateStarsDisplay(rating) {
            starLabels.forEach((label, index) => {
                const starNumber = 5 - index;
                const icon = label.querySelector('i');
                
                if (starNumber <= rating) {
                    icon.style.color = '#ffc107';
                    icon.classList.remove('text-muted');
                    icon.classList.add('text-warning');
                } else {
                    icon.style.color = '#ddd';
                    icon.classList.remove('text-warning');
                    icon.classList.add('text-muted');
                }
            });
        }
        
        // Add change event to inputs
        starInputs.forEach(input => {
            input.addEventListener('change', function() {
                updateStarsDisplay(this.value);
            });
        });
        
        // Character counter for comment
        const commentTextarea = document.getElementById('komentar');
        if (commentTextarea) {
            const charCount = document.createElement('small');
            charCount.className = 'text-muted float-end';
            charCount.id = 'char-count';
            charCount.textContent = '0/500';
            commentTextarea.parentNode.appendChild(charCount);
            
            commentTextarea.addEventListener('input', function() {
                const length = this.value.length;
                charCount.textContent = length + '/500';
                
                if (length > 500) {
                    charCount.classList.remove('text-muted');
                    charCount.classList.add('text-danger');
                } else {
                    charCount.classList.remove('text-danger');
                    charCount.classList.add('text-muted');
                }
            });
            
            commentTextarea.dispatchEvent(new Event('input'));
        }
        
        // Form validation
        const reviewForm = document.querySelector('form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                const rating = document.querySelector('input[name="rating"]:checked');
                const komentar = document.getElementById('komentar');
                
                if (!rating) {
                    e.preventDefault();
                    alert('Silakan pilih rating terlebih dahulu!');
                    return false;
                }
                
                if (komentar && komentar.value.length > 500) {
                    e.preventDefault();
                    alert('Komentar terlalu panjang! Maksimal 500 karakter.');
                    komentar.focus();
                    return false;
                }
                
                return true;
            });
        }
        
        // Highlight admin replies - BARU
        const adminReplies = document.querySelectorAll('.balasan-admin');
        adminReplies.forEach(reply => {
            // Tambahkan efek hover
            reply.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 4px 8px rgba(0, 123, 255, 0.2)';
                this.style.transform = 'translateY(-2px)';
            });
            
            reply.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>

</body>
</html>