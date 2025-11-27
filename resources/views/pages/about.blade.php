<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Warung Tita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>
    @include('layouts.header')

    <section class="hero">
        <div class="container">
            <div class="warung-img">
                <img src="{{ asset('images/warung.jpg') }}" alt="Warung Tita">
            </div>
            <div class="detail">
                <h3>Warung Tita</h3>
                <p>
                    Transformasi warung sembako menjadi warung e-commerce adalah langkah adaptif yang menggabungkan model tradisional dengan teknologi digital untuk menjangkau pasar yang lebih luas dan efisien. Berikut adalah deskripsi tentang transformasi tersebut dengan nama Warung Tita.
                </p>
            </div>
        </div>
        <div class="sejarah">
            <h3>Sejarah Singkat</h3>
            <p>Warung Sembako Tita – Dari Tangan Keluarga, Untuk Keluarga
               Warung Sembako Tita memiliki kisah yang bermula dari semangat berwirausaha di dalam keluarga kami. Usaha ini pertama kali dirintis oleh kakak kami, dengan harapan menjadi sumber penghidupan sekaligus pelayanan bagi masyarakat sekitar. Namun, karena keterbatasan modal dan kesulitan dalam menjalankan usaha secara konsisten, warung ini nyaris berhenti di tengah jalan. <br><br>

               Melihat potensi dan nilai yang telah dibangun, orang tua kami memutuskan untuk melanjutkan dan mengambil alih sepenuhnya usaha ini. Dengan ketekunan, kerja keras, dan komitmen tinggi, warung ini mulai berkembang sedikit demi sedikit, hingga akhirnya bertahan lebih dari 10 tahun melayani kebutuhan sembako warga sekitar. <br><br>

               Kini, seiring dengan perkembangan teknologi dan gaya hidup masyarakat yang semakin dinamis, kami memperluas layanan ke platform digital. Tujuannya sederhana: agar belanja kebutuhan pokok jadi lebih mudah, cepat, dan nyaman untuk semua.</p>
        </div>
        <div class="makna">
            <h3>Makna warna yang digunakan</h3>
            <div class="warna">
                <div class="warna-1"></div>
                <div class="warna-2"></div>
                <div class="warna-3"></div>
                <div class="warna-4"></div>
            </div>
        </div>
        <div class="makna-warna">
            <div class="warna1">
                <div class="box"></div>
                <p>Warna utama Warung Tita, hijau pekat, mencerminkan keteguhan dan kepercayaan. Sebagaimana warung kami yang hadir sejak dulu untuk memenuhi kebutuhan harian, kini kami hadir secara digital tanpa meninggalkan nilai-nilai yang kami pegang: kejujuran, kedekatan, dan kenyamanan.</p>
            </div>
            <div class="warna1">
                <div class="box2"></div>
                <p>Warna khas Warung Tita, mencerminkan kesegaran, kepercayaan, dan semangat baru dalam melayani kebutuhan pokok masyarakat. Warna ini adalah simbol dari semangat kami menghadirkan warung digital yang tetap hangat, ramah, dan jujur seperti warung di ujung jalan rumah Anda.</p>
            </div>
            <div class="warna1">
                <div class="box3"></div>
                <p>Warna hijau cerah pada Warung Tita mencerminkan kesegaran produk kami dan semangat pelayanan yang ramah. Kami percaya bahwa belanja kebutuhan pokok seharusnya tidak hanya praktis, tapi juga menyenangkan seperti warna segar yang menyambut setiap kunjungan Anda ke Warung Tita.</p>
            </div>
            <div class="warna1">
                <div class="box4"></div>
                <p>Warna biru toska cerah mewakili semangat digital Warung Tita yang segar dan terbuka. Kami ingin pelanggan merasa nyaman, tenang, dan percaya bahwa setiap transaksi bersama kami cepat, bersih, dan transparan — seperti warna ini yang membawa kesan ringan namun meyakinkan.</p>
            </div>
        </div>
    </section>

    @include('layouts.footer')
</body>
</html>