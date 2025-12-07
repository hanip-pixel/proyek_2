<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Obat::FirstOrCreate([
            'nama_produk' => 'Tolak Angin',
            'merek' => 'Sido Muncul',
            'harga_produk' => 4000,
            'stok' => 72,
            'terjual' => 80,
            'foto_produk' => 'tolak_angin.jpg',
            'deskripsi' => '- Isi: 1 sachet (15ml)- Bentuk: Cair- Warna: Coklat pekat- Rasa: Manis dengan aroma herbal khas- Komposisi utama: Madu, jahe, daun mint, adas, kayu ules, daun cengkeh- Kemasan: Sachet praktis, mudah dibawa- Kategori: Herbal kesehatan- Manfaat: Membantu meredakan masuk angin, pusing, kembung, dan mual- Cara konsumsi: Langsung diminum atau dicampur air hangat',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Laserin',
            'merek' => 'Mecosin',
            'harga_produk' => 8000,
            'stok' => 12,
            'terjual' => 43,
            'foto_produk' => 'laserin.jpg',
            'deskripsi' => '- Isi: 1 botol (60ml)- Bentuk: Sirup cair- Warna: Coklat pekat- Rasa: Manis dengan aroma herbal khas- Komposisi utama: Daun lagundi, jahe, madu, adas, dan minyak kayu putih- Kemasan: Botol plastik dengan tutup ulir- Kategori: Obat herbal untuk batuk- Manfaat: Membantu meredakan batuk berdahak, batuk kering, dan melegakan tenggorokan',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Paramex',
            'merek' => 'Konimex',
            'harga_produk' => 2500,
            'stok' => 35,
            'terjual' => 52,
            'foto_produk' => 'paramex.jpg',
            'deskripsi' => '- Isi: 1 strip (4 kaplet)- Bentuk: Kaplet- Warna: Putih- Komposisi utama: Paracetamol, Propyphenazone, Caffeine, Dextromethorphan HBr- Kemasan: Strip plastik dengan segel aluminium- Kategori: Obat sakit kepala dan flu- Manfaat: Meredakan sakit kepala, nyeri ringan, demam, dan gejala flu ringan',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Neorheumacyl',
            'merek' => 'Bode',
            'harga_produk' => 9000,
            'stok' => 47,
            'terjual' => 104,
            'foto_produk' => 'neorhemacyle.jpg',
            'deskripsi' => '- Isi: 1 strip (4-10 kaplet)- Bentuk: Kaplet & Cairan gosok- Warna: Kaplet putih / Cairan bening kekuningan- Komposisi utama: Paracetamol, Ibuprofen, Vitamin B1, B6, B12 (untuk varian Neurobion)- Kemasan: Botol plastik untuk cairan, strip aluminium untuk kaplet- Kategori: Obat pereda nyeri otot & pegal linu',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Bodrex',
            'merek' => 'Bode',
            'harga_produk' => 4500,
            'stok' => 87,
            'terjual' => 187,
            'foto_produk' => 'bodrex.jpg',
            'deskripsi' => '- Isi: 1 strip (4 kaplet)- Bentuk: Kaplet- Warna: Putih- Komposisi utama: Paracetamol, Caffeine- Kemasan: Strip aluminium dengan segel plastik- Kategori: Obat pereda sakit kepala dan demam',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Bodrexin',
            'merek' => 'Bode',
            'harga_produk' => 4000,
            'stok' => 51,
            'terjual' => 98,
            'foto_produk' => 'bodrexin.jpg',
            'deskripsi' => '- Isi: 1 strip tablet kunyah (4-10 tablet)- Bentuk: Sirup & Tablet kunyah- Rasa: Jeruk / Stroberi- Komposisi utama: Paracetamol- Manfaat: Menurunkan demam & meredakan nyeri ringan pada anak',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Ultraflu',
            'merek' => 'Ultraflu',
            'harga_produk' => 3500,
            'stok' => 67,
            'terjual' => 63,
            'foto_produk' => 'ultraflu.jpg',
            'deskripsi' => '- Isi: 1 strip (4 kaplet)- Bentuk: Kaplet- Komposisi utama: Paracetamol, Pseudoephedrine, Chlorpheniramine Maleate- Manfaat: Meredakan gejala flu seperti hidung tersumbat, bersin, sakit kepala, dan demam- Cara konsumsi: 1 kaplet, 3x sehari setelah makan',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Betadine',
            'merek' => 'Betadine',
            'harga_produk' => 8000,
            'stok' => 45,
            'terjual' => 69,
            'foto_produk' => 'betadine.jpg',
            'deskripsi' => '- Bentuk: Cairan antiseptik- Komposisi utama: Povidone-Iodine- Manfaat: Membantu mencegah infeksi pada luka',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Promag',
            'merek' => 'Promag',
            'harga_produk' => 9000,
            'stok' => 33,
            'terjual' => 78,
            'foto_produk' => 'promag.jpeg',
            'deskripsi' => '- Isi: 1 strip (4 tablet)- Bentuk: Tablet- Rasa: Mint- Komposisi utama: Magnesium hidroksida, Aluminium hidroksida- Manfaat: Meredakan maag, sakit perut, dan gangguan pencernaan, Menetralisir asam lambung- Cara konsumsi: Tablet: 1-2 tablet, 3x sehari setelah makan',

        ]);
        Obat::FirstOrCreate([
            'nama_produk' => 'Oskadon',
            'merek' => 'Oskadon',
            'harga_produk' => 2500,
            'stok' => 77,
            'terjual' => 76,
            'foto_produk' => 'oskadon.jpeg',
            'deskripsi' => '- Isi: 1 strip (4 kaplet)- Bentuk: Kaplet- Komposisi utama: Paracetamol, Kafein- Manfaat: Meredakan sakit kepala ringan hingga sedang, Mengurangi nyeri otot dan demam',

        ]);
    }
}