<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dapur;

class DapurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dapur::FirstOrCreate([
            'nama_produk' => 'Beras Super Rajolele',
            'merek' => 'Rajolele',
            'harga_produk' => 1400,
            'stok' => 57,
            'terjual' => 59,
            'foto_produk' => 'beras.jpg',
            'deskripsi' => '- Isi: 1kg - Bentuk: Butiran beras putih - Manfaat: Sumber utama karbohidrat yang memberikan energi, Digunakan untuk membuat nasi dan berbagai masakan lainnya - Cara penggunaan: Cuci beras hingga bersih, masak dengan air sesuai perbandingan yang disarankan',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Minyak Rizki 1 Liter',
            'merek' => 'BKP',
            'harga_produk' => 18000,
            'stok' => 25,
            'terjual' => 175,
            'foto_produk' => 'minyak.jpg',
            'deskripsi' => '- Isi: 1L- Bentuk: Cair- Warna: Kuning keemasan atau transparan- Komposisi utama: Minyak kelapa sawit, minyak jagung, minyak kedelai (tergantung merek)- Manfaat: Digunakan untuk menggoreng, menumis, dan memasak berbagai jenis masakan, Memberikan tekstur renyah pada makanan, Tahan panas untuk memasak dalam suhu tinggi- Cara penggunaan: Panaskan sesuai kebutuhan untuk menggoreng atau menumis',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Telur Ayam',
            'merek' => '-',
            'harga_produk' => 7500-30000,
            'stok' => 12,
            'terjual' => 84,
            'foto_produk' => 'telur.jpg',
            'deskripsi' => '- Bentuk: Telur bulat atau oval dengan kulit berwarna coklat atau putih- Komposisi utama: Putih telur, kuning telur- Manfaat: Sumber protein, vitamin, dan mineral, Digunakan dalam berbagai masakan seperti telur dadar, omelet, rebus, dan bahan untuk kue atau masakan lainnya- Cara penggunaan: Cuci bersih, kemudian masak sesuai dengan kebutuhan (rebus, goreng, orak-arik)',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Garam Meja Cap Daun',
            'merek' => 'Daun',
            'harga_produk' => 2500,
            'stok' => 86,
            'terjual' => 104,
            'foto_produk' => 'garam.jpg',
            'deskripsi' => '- Bentuk: Kristal halus atau kasar- Komposisi utama: Natrium klorida (NaCl)- Manfaat: Digunakan untuk memberi rasa pada makanan, Sebagai pengawet alami untuk bahan makanan, Membantu meningkatkan rasa dan keseimbangan dalam masakan- Cara penggunaan: Taburkan pada makanan sesuai kebutuhan atau larutkan dalam air untuk keperluan memasak',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Mie Instan',
            'merek' => 'Indomie',
            'harga_produk' => 3000,
            'stok' => 45,
            'terjual' => 255,
            'foto_produk' => 'indomie.jpg',
            'deskripsi' => '- Merek: Indomie- Bentuk: Mie kering dalam kemasan plastik atau cup- Warna: Kuning atau sesuai dengan varian rasa- Komposisi utama: Tepung terigu, minyak nabati, bumbu penyedap- Tersedia dalam berbagai varian rasa (misalnya: Ayam Bawang, Soto Mie, Rendang, dll)- Cocok untuk sarapan, makan malam, atau cemilan cepat- Cara penggunaan: Rebus mie dalam air mendidih selama 3-5 menit, lalu tambahkan bumbu sesuai petunjuk pada kemasan',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Kecap Bango',
            'merek' => 'Bango',
            'harga_produk' => 3000,
            'stok' => 25,
            'terjual' => 73,
            'foto_produk' => 'kecap.jpg',
            'deskripsi' => '- Bentuk: Cair- Warna: Coklat pekat- Komposisi utama: Gula kelapa, kedelai fermentasi, air, dan bumbu alami- Manfaat: Menambah rasa manis, gurih, dan warna pada masakan, Cocok untuk bumbu masakan, seperti nasi goreng, sate, atau tumisan, Memberikan cita rasa khas Indonesia pada berbagai hidangan- Cara penggunaan: Tambahkan ke dalam masakan sesuai selera atau gunakan sebagai bahan marinasi',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Sardines ABC Ekstra Pedas',
            'merek' => 'ABC',
            'harga_produk' => 11000,
            'stok' => 12,
            'terjual' => 62,
            'foto_produk' => 'sarden.jpg',
            'deskripsi' => '- Bentuk: Ikan sarden dalam kaleng dengan saus tomat atau saus pedas- Komposisi utama: Ikan sarden, minyak, saus tomat, garam, bumbu tambahan- Manfaat: Makanan praktis dan siap saji, Sumber protein dan omega-3, Cocok sebagai lauk atau campuran dalam nasi, mie, atau roti- Cara penggunaan: Cukup dipanaskan atau dimakan langsung setelah dibuka dari kaleng',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Susu Kental Manis Frisian Flag',
            'merek' => 'Bendera',
            'harga_produk' => 12500,
            'stok' => 13,
            'terjual' => 57,
            'foto_produk' => 'susu.jpg',
            'deskripsi' => '- Bentuk: Cair, kental manis dalam kaleng- Warna: Putih kental- Komposisi utama: Susu sapi, gula, dan bahan pengental- Manfaat: Sebagai bahan pemanis untuk teh, kopi, dan minuman lainnya, Bisa digunakan dalam pembuatan kue, pudding, atau makanan penutup lainnya, Memberikan rasa manis dan tekstur kental pada berbagai masakan- Cara penggunaan: Tambahkan sesuai kebutuhan pada minuman atau makanan',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Tepung Terigu Segitiga Biru',
            'merek' => 'Bogasari',
            'harga_produk' => 12000,
            'stok' => 52,
            'terjual' => 64,
            'foto_produk' => 'terigu.jpg',
            'deskripsi' => '- Isi: 1kg- Bentuk: Bubuk halus- Warna: Putih bersih- Komposisi utama: Tepung terigu berkualitas tinggi- Manfaat: Tepung serbaguna yang dapat digunakan untuk membuat kue, roti, mie, atau berbagai olahan lainnya, Membantu memberikan tekstur lembut pada adonan- Cara penggunaan: Gunakan sesuai dengan resep atau kebutuhan memasak',

        ]);
        Dapur::FirstOrCreate([
            'nama_produk' => 'Gula Pasir Kemasan',
            'merek' => '-',
            'harga_produk' => 10000,
            'stok' => 56,
            'terjual' => 64,
            'foto_produk' => 'gula.jpg',
            'deskripsi' => '- Bentuk: Kristal halus berwarna putih- Komposisi utama: Gula tebu- Manfaat: Digunakan untuk pemanis pada minuman, kue, makanan, dan masakan, Menambah rasa manis pada berbagai olahan makanan- Cara penggunaan: Tambahkan pada masakan atau minuman sesuai kebutuhan',

        ]);
    }
}