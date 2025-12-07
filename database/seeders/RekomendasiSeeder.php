<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rekomendasi;

class RekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Sweety Silver Pants',
            'merek' => 'Sweety',
            'harga_produk' => 2500,
            'stok' => 17,
            'terjual' => 73,
            'foto_produk' => 'sweety.jpg',
            'deskripsi' => '- Merek: Sweety- Bentuk: Popok celana sekali pakai- Warna: Putih dengan motif warna-warni- Komposisi utama: Bahan lembut dan elastis, lapisan penyerap, pelindung anti bocor- Manfaat: Daya serap tinggi untuk menjaga kulit bayi tetap kering, Bahan lembut dan nyaman untuk bayi aktif, Desain elastis yang pas di tubuh bayi tanpa meninggalkan bekas merah',

        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Susu Bear Brand',
            'merek' => 'Nestle',
            'harga_produk' => 10000,
            'stok' => 55,
            'terjual' => 161,
            'foto_produk' => 'bear_brand.jpg',
            'deskripsi' => '- Isi: 189ml per kaleng- Bentuk: Cair, susu steril siap minum- Warna: Putih susu- Komposisi utama: 100% susu sapi murni yang telah disterilisasi- Manfaat: Membantu menjaga daya tahan tubuh, Sumber nutrisi untuk mendukung kesehatan tubuh',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Gas Elpiji 3kg',
            'merek' => 'Pertamina',
            'harga_produk' => 23000,
            'stok' => 47,
            'terjual' => 41,
            'foto_produk' => 'gas.jpg',
            'deskripsi' => '- Merek: Pertamina- Isi: 3 kg gas LPG (Liquefied Petroleum Gas)- Bentuk: Tabung bulat berwarna hijau dengan katup pengaman- Komposisi utama: Campuran propana dan butana- Manfaat: Digunakan sebagai bahan bakar untuk memasak di rumah tangga, Hemat dan efisien untuk kebutuhan dapur sehari hari, Mudah digunakan dengan regulator khusus- Cara penggunaan: Pasangkan dengan regulator gas dan selang, gunakan sesuai petunjuk keamanan',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Lampu LUBY',
            'merek' => 'LUBY',
            'harga_produk' => 25000,
            'stok' => 13,
            'terjual' => 34,
            'foto_produk' => 'luby.jpeg',
            'deskripsi' => '- Merek: LUBY- Daya: Tersedia 18W- Bentuk: Bohlam LED atau lampu emergency- Warna Cahaya: Putih terang (cool white), kuning hangat (warm white), atau putih natural (daylight)- Komposisi utama: Bahan plastik dan aluminium dengan teknologi LED hemat energi',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Cotton Bud',
            'merek' => 'Cussons baby',
            'harga_produk' => 2000-8000,
            'stok' => 34,
            'terjual' => 34,
            'foto_produk' => 'cotton_bud.jpg',
            'deskripsi' => '- Merek: Cussons Baby- Isi: 50 batang, 100 batang (tergantung varian)- Bentuk: Batang kecil dengan ujung kapas lembut- Warna: Putih dengan batang plastik atau kertas- Komposisi utama: Kapas lembut 100% dan batang plastik/kertas ramah lingkungan- Manfaat: Membersihkan telinga, hidung, dan area sensitif bayi dengan aman, Ujung kapas lembut dan tidak mudah lepas, Didesain khusus agar aman untuk bayi',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Kapas Selection',
            'merek' => 'Selection',
            'harga_produk' => 5500,
            'stok' => 23,
            'terjual' => 42,
            'foto_produk' => 'selection.jpg',
            'deskripsi' => '- Merek: Selection- Bentuk: Lembut, berbentuk gulungan atau lembaran kapas- Warna: Putih bersih- Komposisi utama: 100% kapas alami- Manfaat: Digunakan untuk membersihkan wajah dan mengaplikasikan skincare, Cocok untuk perawatan bayi dan keperluan medis, Lembut, tidak mengandung bahan kimia berbahaya, dan aman untuk kulit, Cara penggunaan: Gunakan sesuai kebutuhan, baik untuk perawatan wajah, kebersihan, atau kebutuhan medis',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Pasta Gigi Pepsodent',
            'merek' => 'Pepsodent',
            'harga_produk' => 5000-13500,
            'stok' => 22,
            'terjual' => 34,
            'foto_produk' => 'pepsodent.jpg',
            'deskripsi' => '- Merek: Pepsodent- Bentuk: Pasta kental dalam kemasan tube- Warna: Putih atau kombinasi dengan garis warna (tergantung varian)- Komposisi utama: Fluoride, kalsium, bahan pembersih gigi- Manfaat: Membersihkan gigi dan mulut dari kotoran dan plak, Membantu mencegah gigi berlubang dengan fluoride aktif, Menjaga nafas tetap segar sepanjang hari, Tersedia dalam berbagai varian seperti Whitening, Herbal, Sensitive, dan Complete Care',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Plastik 10x25',
            'merek' => 'Rajolele',
            'harga_produk' => 9000,
            'stok' => 57,
            'terjual' => 59,
            'foto_produk' => 'plastik.jpg',
            'deskripsi' => '- Merek: UI WANG- Bahan: Plastik berkualitas tinggi, lentur, dan tidak mudah robek.- Ukuran: 10 cm x 25 cm- Warna: Transparan- Kegunaan: Ideal untuk keperluan rumah tangga, bisnis, dan industri ringan- Keunggulan: Food grade, tahan air, dan mudah digunakan- Jumlah: 1 pack berisi 100 pcs plastik',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Spidol Snowman',
            'merek' => 'Snowman',
            'harga_produk' => 7000,
            'stok' => 11,
            'terjual' => 31,
            'foto_produk' => 'snow.jpg',
            'deskripsi' => '- Merek: Snowman- Tipe: Spidol permanen, spidol whiteboard- Isi: 1 pcs- Bentuk: Tabung dengan ujung runcing- Warna: Hitam, biru, merah, hijau, dan warna lainnya- Komposisi utama: Tinta berbasis alkohol (permanen) atau tinta berbasis air (whiteboard)',
            
        ]);
        Rekomendasi::FirstOrCreate([
            'nama_produk' => 'Tissue Jolly',
            'merek' => 'Jolly',
            'harga_produk' => 8000,
            'stok' => 25,
            'terjual' => 41,
            'foto_produk' => 'tisu.jpg',
            'deskripsi' => '- Merek: Jolly- Isi: 200 lembar, 250 lembar, atau dalam kemasan travel pack (tergantung varian)- Bentuk: Lembaran tisu halus dalam kemasan plastik atau kotak- Warna: Putih bersih- Komposisi utama: 100% serat alami, bebas pewangi dan bahan kimia berbahaya- Manfaat: Lembut dan higienis untuk penggunaan sehari-hari, Cocok untuk keperluan wajah, tangan, atau membersihkan area tertentu, Tersedia dalam berbagai ukuran, praktis untuk dibawa ke mana saja',
            
        ]);
    }
}