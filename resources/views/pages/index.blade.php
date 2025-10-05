<?php
// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Detail koneksi database untuk db_barang
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_barang";

// Buat koneksi ke db_barang
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Periksa koneksi db_barang
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Buat koneksi ke database 'user' untuk riwayat transaksi
$conn_user = mysqli_connect($db_server, $db_user, $db_pass, "user");

// Inisialisasi array all_products untuk menyimpan data dari semua tabel produk
$all_products = [];

/**
 * Fungsi untuk menambahkan produk dari tabel tertentu ke array all_products.
 *
 * @param mysqli $conn Objek koneksi database.
 * @param string $table Nama tabel untuk mengambil produk.
 * @param array $all_products Referensi ke array untuk menyimpan semua produk.
 */
function addProductsFromTable($conn, $table, &$all_products) {
    $query = "SELECT *, '$table' as tabel_asal FROM $table";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $all_products[] = $row;
    }
}

// Ambil produk dari tabel 'dapur', 'detergen', dan 'obat'
addProductsFromTable($conn, 'dapur', $all_products);
addProductsFromTable($conn, 'detergen', $all_products);
addProductsFromTable($conn, 'obat', $all_products);

// Tentukan filter saat ini, default ke 'rekomendasi'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'rekomendasi';
$products_rekomendasi = []; // Inisialisasi array untuk produk rekomendasi yang difilter

// Terapkan pemfilteran berdasarkan parameter 'filter'
switch ($filter) {
    case 'rekomendasi':
        // Ambil produk dari tabel 'rekomendasi'
        $query_rekomendasi = "SELECT *, 'rekomendasi' as tabel_asal FROM rekomendasi";
        $result_rekomendasi = mysqli_query($conn, $query_rekomendasi);
        $products_rekomendasi = mysqli_fetch_all($result_rekomendasi, MYSQLI_ASSOC);
        break;

    case 'terbaru':
        $query_terbaru = "(SELECT *, 'rekomendasi' as tabel_asal FROM rekomendasi ORDER BY id DESC LIMIT 1)
                         UNION
                         (SELECT *, 'dapur' as tabel_asal FROM dapur ORDER BY id DESC LIMIT 1)
                         UNION
                         (SELECT *, 'detergen' as tabel_asal FROM detergen ORDER BY id DESC LIMIT 1)
                         UNION
                         (SELECT *, 'obat' as tabel_asal FROM obat ORDER BY id DESC LIMIT 1)
                         ORDER BY id DESC LIMIT 6";
        $result_terbaru = mysqli_query($conn, $query_terbaru);
        $products_rekomendasi = mysqli_fetch_all($result_terbaru, MYSQLI_ASSOC);
        break;

    case 'stok_menipis':
        $query_stok_menipis = "(SELECT *, 'rekomendasi' as tabel_asal FROM rekomendasi WHERE stok_produk < 5 ORDER BY stok_produk ASC LIMIT 6)
                              UNION
                              (SELECT *, 'dapur' as tabel_asal FROM dapur WHERE stok_produk < 5 ORDER BY stok_produk ASC LIMIT 6)
                              UNION
                              (SELECT *, 'detergen' as tabel_asal FROM detergen WHERE stok_produk < 5 ORDER BY stok_produk ASC LIMIT 6)
                              UNION
                              (SELECT *, 'obat' as tabel_asal FROM obat WHERE stok_produk < 5 ORDER BY stok_produk ASC LIMIT 6)
                              ORDER BY stok_produk ASC LIMIT 6";
        $result_stok = mysqli_query($conn, $query_stok_menipis);
        $products_rekomendasi = mysqli_fetch_all($result_stok, MYSQLI_ASSOC);
        
        if (empty($products_rekomendasi)) {
            $products_rekomendasi = [];
        }
        break;

    case 'terlaris':
        $query_terlaris = "(SELECT *, 'rekomendasi' as tabel_asal FROM rekomendasi WHERE terjual > 150 ORDER BY terjual DESC LIMIT 6)
                          UNION
                          (SELECT *, 'dapur' as tabel_asal FROM dapur WHERE terjual > 150 ORDER BY terjual DESC LIMIT 6)
                          UNION
                          (SELECT *, 'detergen' as tabel_asal FROM detergen WHERE terjual > 150 ORDER BY terjual DESC LIMIT 6)
                          UNION
                          (SELECT *, 'obat' as tabel_asal FROM obat WHERE terjual > 150 ORDER BY terjual DESC LIMIT 6)
                          ORDER BY terjual DESC LIMIT 6";
        $result_terlaris = mysqli_query($conn, $query_terlaris);
        $products_rekomendasi = mysqli_fetch_all($result_terlaris, MYSQLI_ASSOC);
        
        if (empty($products_rekomendasi)) {
            $query_fallback = "(SELECT *, 'dapur' as tabel_asal FROM dapur ORDER BY terjual DESC LIMIT 6)
                              UNION
                              (SELECT *, 'detergen' as tabel_asal FROM detergen ORDER BY terjual DESC LIMIT 6)
                              UNION
                              (SELECT *, 'obat' as tabel_asal FROM obat ORDER BY terjual DESC LIMIT 6)
                              ORDER BY terjual DESC LIMIT 6";
            $result_fallback = mysqli_query($conn, $query_fallback);
            $products_rekomendasi = mysqli_fetch_all($result_fallback, MYSQLI_ASSOC);
        }
        break;
}

// Tentukan kategori saat ini, default ke 'dapur'
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'dapur';

// Ambil produk berdasarkan kategori yang dipilih
switch ($kategori) {
    case 'detergen':
        $query_kategori = "SELECT * FROM detergen";
        break;
    case 'obat':
        $query_kategori = "SELECT * FROM obat";
        break;
    default: // 'dapur'
        $query_kategori = "SELECT * FROM dapur";
}

$result_kategori = mysqli_query($conn, $query_kategori);
$products_kategori = mysqli_fetch_all($result_kategori, MYSQLI_ASSOC);
?>

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
    <link rel="stylesheet" href="../style/style.css">
    <style>
        /* Mencegah perilaku scroll pada link filter */
        .subtitle a {
            scroll-behavior: unset !important;
        }

        /* Transisi halus untuk pembaruan konten */
        .tampilan {
            transition: opacity 0.3s ease;
        }

        .tampilan.loading {
            opacity: 0.5;
        }
    </style>
</head>
<body>

<script>
    // Fungsi untuk menyimpan posisi scroll
    function saveScrollPosition() {
        const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        sessionStorage.setItem('scrollPosition', scrollPosition);
    }

    // Fungsi untuk memulihkan posisi scroll
    function restoreScrollPosition() {
        const scrollPosition = sessionStorage.getItem('scrollPosition');
        if (scrollPosition !== null) {
            window.scrollTo(0, parseInt(scrollPosition));
            sessionStorage.removeItem('scrollPosition');
        }
    }

    // Simpan posisi scroll sebelum unload
    window.addEventListener('beforeunload', saveScrollPosition);

    // Pulihkan posisi scroll saat halaman dimuat
    window.addEventListener('load', function() {

        setTimeout(restoreScrollPosition, 100);
    });


    function addToCart(productId, event) {
        event.stopPropagation();
        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produk berhasil ditambahkan ke keranjang!');
                updateCartCounter();
            } else {
                alert('Gagal menambahkan produk: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateCartCounter() {
        fetch('get_cart_count.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-counter').innerText = data.count;
                }
            });
    }

    function changeFilter(filter, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        const urlParams = new URLSearchParams(window.location.search);
        const kategori = urlParams.get('kategori') || 'dapur';

        const newUrl = `?kategori=${kategori}&filter=${filter}`;
        window.history.replaceState({scrollPosition: currentScrollPosition}, '', newUrl);

        fetch(`get_filtered_products.php?kategori=${kategori}&filter=${filter}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateProductDisplay(data.products, filter);
                    updateActiveFilter(filter);
                    setTimeout(() => {
                        window.scrollTo(0, currentScrollPosition);
                    }, 50);
                } else {
                    console.error('Error fetching products:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

        return false;
    }

    function updateProductDisplay(products, filter) {
        const container = document.querySelector('.tampilan');
        container.classList.add('loading');
        container.innerHTML = '';

        products.forEach(product => {
            let additionalInfo = '';
            if (filter === 'stok_menipis') {
                additionalInfo = `<small class="text-danger">Stok: ${product.stok_produk}</small>`;
            } else if (filter === 'terlaris' && product.total_terjual) {
                additionalInfo = `<small class="text-success">Terjual: ${product.total_terjual}</small>`;
            }

            const productHTML = `
                <div class="col" onclick="window.location.href='/proyek_1/pages/transaksi.php?id=${product.id}&tabel=${product.tabel_asal}';">
                    <div class="menu">
                        <div class="barang">
                            <div class="box-img">
                                <img src="../menu/${product.foto_produk}" alt="${product.nama_produk}">
                                <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='keranjang.php?tambah=${product.tabel_asal}-${product.id}';">
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

        setTimeout(() => {
            container.classList.remove('loading');
        }, 100);
    }

    function updateActiveFilter(activeFilter) {
        document.querySelectorAll('.subtitle a').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelector(`.subtitle a[data-filter="${activeFilter}"]`).classList.add('active');
    }

    function changeCategory(category) {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'terlaris';
        window.location.href = `?kategori=${category}&filter=${filter}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const kategori = urlParams.get('kategori') || 'dapur';
        document.querySelector(`.navigation-${kategori}`).classList.add('active');

        const currentFilter = urlParams.get('filter') || 'rekomendasi';
        updateActiveFilter(currentFilter);
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('scroll-locked');
        if (localStorage.getItem('scrollUnlocked') === 'true') {
            unlockScroll();
        }
    });

    function unlockScroll() {
        document.body.classList.remove('scroll-locked');
        localStorage.setItem('scrollUnlocked', 'true');
    }

    function handleNavClick(event) {
        if (document.body.classList.contains('scroll-locked')) {
            event.preventDefault();
            document.getElementById('alertModal').style.display = 'flex';
            return false;
        }
        return true;
    }
</script>

<div class="alert-modal" id="alertModal">
    <div class="alert-content">
        <h4>Peringatan!</h4>
        <p>Anda harus menekan tombol "Klik untuk masuk" terlebih dahulu sebelum dapat mengakses halaman ini.</p>
        <button class="btn btn-primary" onclick="document.getElementById('alertModal').style.display = 'none'">Mengerti</button>
    </div>
</div>

<?php include "../include/header.php" ?>

<section class="container-fluid hero-container">
    <div class="row">
        <div class="col-md-6 left">
            <div class="content">
                <h4 class="hero-title">
                    E-commerce sembako
                </h4>
                <p class="hero-description">
                    Temukan beras, minyak, gula, dan bahan pokok lainnya dengan
                    kualitas terbaik. Belanja mudah, harga terjangkau, dan pengiriman
                    cepat. Lengkapi kebutuhan dapur Anda tanpa repot. Ayo, mulai
                    belanja sekarang!
                </p>
                <div class="hero-buttons">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="unlockScroll()">Klik untuk masuk</a>
                    <p class="small-text">Untuk berbagai kebutuhan.</p>
                </div>
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
            <img src="../images/dapur.jpg" alt="Mi Sedap" class="menu-img" />
            <p>Hadirkan cita rasa terbaik dengan bahan segar dan berkualitas. Masak dengan cinta, nikmati kelezatannya!</p>
        </div>
        <div class="cul">
            <h1>Detergen</h1>
            <img src="../images/detergen.jpg" alt="Mi Sedap" class="menu-img" />
            <p>Nikmati kesegaran maksimal dengan perlengkapan mandi terbaik. Mulai hari dengan penuh energi!</p>
        </div>
        <div class="cul">
            <h1>Obat-obatan</h1>
            <img src="../images/obat.jpg" alt="Mi Sedap" class="menu-img" />
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
        <li><a href="javascript:void(0)" data-filter="rekomendasi" onclick="return changeFilter('rekomendasi', event)" class="<?= ($filter == 'rekomendasi' || !isset($_GET['filter'])) ? 'active' : '' ?>">Rekomendasi</a></li>
        <li><a href="javascript:void(0)" data-filter="terlaris" onclick="return changeFilter('terlaris', event)" class="<?= $filter == 'terlaris' ? 'active' : '' ?>">Terlaris</a></li>
        <li><a href="javascript:void(0)" data-filter="terbaru" onclick="return changeFilter('terbaru', event)" class="<?= $filter == 'terbaru' ? 'active' : '' ?>">Terbaru</a></li>
        <li><a href="javascript:void(0)" data-filter="stok_menipis" onclick="return changeFilter('stok_menipis', event)" class="<?= $filter == 'stok_menipis' ? 'active' : '' ?>">Stok Menipis</a></li>
    </ul>

    <div class="tampilan">
        <?php foreach ($products_rekomendasi as $product): ?>
            <div class="col" onclick="window.location.href='/proyek_1/pages/transaksi.php?id=<?= $product['id'] ?>&tabel=<?= $product['tabel_asal'] ?>';">
                <div class="menu">
                    <div class="barang">
                        <div class="box-img">
                            <img src="../menu/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>">
                            <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='keranjang.php?tambah=<?= htmlspecialchars($product['tabel_asal']) ?>-<?= htmlspecialchars($product['id']) ?>';">
                                <i class="bi bi-cart3"></i>
                            </div>
                        </div>
                        <div class="title">
                            <h3><?= htmlspecialchars($product['nama_produk']) ?></h3>
                            <p>Rp<?= number_format($product['harga_produk'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="deskripsi">
    <div class="descript">
        <div class="text">
            <h2>Malas untuk datang dan bayar secara langsung?</h2>
            <img src="../images/mager.png" alt="foto" />
            <p>
                Warung Tita menyediakan fitur bayar menggunakan e-wallet untuk mempermudah transaksi anda!
            </p>
        </div>
        <div class="foto">
            <img src="../images/payments.png" alt="foto" />
        </div>
    </div>
</section>

<section id="dapur" class="barang-kategori scroll-offset">
    <div class="kategori-barang">
        <div class="navigation">
            <a href="?kategori=dapur&filter=<?= htmlspecialchars($filter) ?>" class="navigation-dapur <?= $kategori == 'dapur' ? 'active' : '' ?>">Kebutuhan Dapur</a>
            <a href="?kategori=detergen&filter=<?= htmlspecialchars($filter) ?>" class="navigation-detergen <?= $kategori == 'detergen' ? 'active' : '' ?>">Detergen</a>
            <a href="?kategori=obat&filter=<?= htmlspecialchars($filter) ?>" class="navigation-obat <?= $kategori == 'obat' ? 'active' : '' ?>">Obat-obatan</a>
        </div>
        <div class="tampilan-2">
            <?php foreach ($products_kategori as $product): ?>
                <div class="col" onclick="window.location.href='/proyek_1/pages/transaksi.php?id=<?= htmlspecialchars($product['id']) ?>&tabel=<?= htmlspecialchars($kategori) ?>';">
                    <div class="menu">
                        <div class="barang">
                            <div class="box-img">
                                <img src="../menu/<?= htmlspecialchars($product['foto_produk']) ?>" alt="<?= htmlspecialchars($product['nama_produk']) ?>">
                                <div class="box-keranjang" onclick="event.stopPropagation(); window.location.href='keranjang.php?tambah=<?= htmlspecialchars($kategori) ?>-<?= htmlspecialchars($product['id']) ?>';">
                                    <i class="bi bi-cart3"></i>
                                </div>
                            </div>
                            <div class="title">
                                <h3><?= htmlspecialchars($product['nama_produk']) ?></h3>
                                <p>Rp<?= number_format($product['harga_produk'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                <img src="../images/shoping.png" alt="">
                <div class="deskripsi-konten">
                    <h5>Belanja dengan simpel</h5>
                    <p>Berbelanja tanpa perlu keluar rumah dengan fitur yang simpel memudahkan anda untuk berbelanja</p>
                </div>
            </div>
            <div class="konten">
                <img src="../images/transit.png" alt="">
                <div class="deskripsi-konten">
                    <h5>Pengiriman aman</h5>
                    <p>Kami menyediakan jasa pengiriman dari pintu ke pintu untuk memberikan fasilitas waktu yang fleksibel</p>
                </div>
            </div>
            <div class="konten">
                <img src="../images/receipt.png" alt="">
                <div class="deskripsi-konten">
                    <h5>Jaminan barang sesuai</h5>
                    <p>Warung kami menjamin ketepatan pesanan anda dan memberikan garansi uang kembali jika barang rusak</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "../include/footer.html" ?>

<script src="../script/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>
</html>