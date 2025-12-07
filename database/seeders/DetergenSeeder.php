<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Detergen;

class DetergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Detergen::FirstOrCreate([
            'nama_produk' => 'Rinso',
            'merek' => 'Rinso',
            'harga_produk' => 5000,
            'stok' => 69,
            'terjual' => 76,
            'foto_produk' => 'rinso.jpg',
            'deskripsi' => '- Bentuk: Bubuk- Warna: Putih- Komposisi utama: Deterjen, bahan penghilang noda, pelembut pakaian- Manfaat: Membersihkan pakaian dari noda dan kotoran, Membuat pakaian lebih harum dan lembut, Bisa digunakan untuk mesin cuci atau cucian tangan',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Molto 1 Rencang',
            'merek' => 'Molto',
            'harga_produk' => 5500,
            'stok' => 73,
            'terjual' => 90,
            'foto_produk' => 'molto.jpg',
            'deskripsi' => '- Bentuk: Cair- Warna: Biru, Pink, Hijau (tergantung varian)- Komposisi utama: Pewangi dan pelembut pakaian- Manfaat: Memberikan aroma segar dan tahan lama pada pakaian, Melembutkan kain setelah dicuci, Membantu menjaga kelembutan pakaian sepanjang hari',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Ekonomi',
            'merek' => 'Ekonomi',
            'harga_produk' => 5500,
            'stok' => 66,
            'terjual' => 87,
            'foto_produk' => 'ekonomi.jpg',
            'deskripsi' => '- Bentuk: Cream- Warna: Tergantung varian- Komposisi utama: Sodium tallowate, Sodium cocoate, Glycerin- Manfaat: Membersihkan kulit secara efektif, Menghidrasi dan melembutkan kulit',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Soklin Softergent',
            'merek' => 'Soklin',
            'harga_produk' => 5500,
            'stok' => 54,
            'terjual' => 101,
            'foto_produk' => 'soklin_softerjen.jpg',
            'deskripsi' => '- Bentuk: Bubuk- Warna: Putih (umumnya)- Komposisi utama: Pelembut pakaian, pewangi- Manfaat: Melembutkan pakaian setelah dicuci, Memberikan aroma segar dan tahan lama pada pakaian, Membantu mengurangi kerutan pada pakaian',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Soklin Liquid',
            'merek' => 'Soklin',
            'harga_produk' => 5500,
            'stok' => 57,
            'terjual' => 260,
            'foto_produk' => 'soklin.jpg',
            'deskripsi' => '- Isi: 700ml- Bentuk: Cair- Warna: Biru, Hijau, atau Pink (tergantung varian)- Komposisi utama: Deterjen cair, bahan penghilang noda, pelembut- Manfaat: Membersihkan pakaian secara efektif dari noda, Membantu menjaga kelembutan dan keharuman pakaian, Menghasilkan busa yang melimpah untuk pencucian tangan atau mesin cuci',
        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Deterjen BOOM',
            'merek' => 'Wings',
            'harga_produk' => 5000,
            'stok' => 57,
            'terjual' => 79,
            'foto_produk' => 'boom.jpg',
            'deskripsi' => '- Isi: 500g- Bentuk: Bubuk- Warna: Putih- Komposisi utama: Deterjen, bahan penghilang noda- Manfaat: Membersihkan pakaian dari noda dan kotoran dengan efektif, Membantu menjaga warna pakaian tetap cerah, Menghasilkan busa melimpah yang cocok untuk pencucian tangan atau mesin cuci',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Daia Softener',
            'merek' => 'Wings',
            'harga_produk' => 5000,
            'stok' => 78,
            'terjual' => 67,
            'foto_produk' => 'daya.jpg',
            'deskripsi' => '- Bentuk: Bubuk- Warna: Biru, Pink, Hijau (tergantung varian)- Komposisi utama: Pelembut pakaian, pewangi- Manfaat: Melembutkan pakaian setelah dicuci, Memberikan aroma segar dan tahan lama pada pakaian, Membantu menjaga kelembutan kain, bahkan setelah dijemur',

        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Wipol',
            'merek' => 'Unilever',
            'harga_produk' => 5500,
            'stok' => 42,
            'terjual' => 50,
            'foto_produk' => 'wipol.jpg',
            'deskripsi' => '- Isi: 800ml- Bentuk: Cair- Warna: Hijau- Komposisi utama: Bahan pembersih, antibakteri, dan pewangi- Manfaat: Membersihkan dan mengharumkan lantai dan permukaan rumah, Membunuh kuman dan bakteri untuk kebersihan yang lebih maksimal, Menyediakan aroma segar yang tahan lama',
        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Soklin Lantai',
            'merek' => 'Soklin',
            'harga_produk' => 15000,
            'stok' => 27,
            'terjual' => 66,
            'foto_produk' => 'soklin_lantai.jpg',
            'deskripsi' => '- Bentuk: Cair- Warna: Biru, Hijau, atau Putih (tergantung varian)- Komposisi utama: Bahan pembersih, antibakteri, dan pewangi- Manfaat: Membersihkan lantai dari kotoran dan debu, Mengharumkan ruangan dengan aroma segar, Membunuh kuman dan bakteri untuk kebersihan maksimal- Cara penggunaan: Campurkan dengan air, lalu pel lantai sesuai kebutuhan',
        ]);
        Detergen::FirstOrCreate([
            'nama_produk' => 'Gentle Gen',
            'merek' => 'DG',
            'harga_produk' => 11000,
            'stok' => 65,
            'terjual' => 63,
            'foto_produk' => 'gentle_gen.jpg',
            'deskripsi' => '- Bentuk: Cair- Warna: Biru atau Hijau (tergantung varian)- Komposisi utama: Bahan pembersih, antibakteri, pewangi- Manfaat: Membersihkan lantai dan permukaan rumah dengan efektif, Membunuh kuman dan bakteri, menjaga kebersihan dan kesehatan, Memberikan aroma segar yang tahan lama',
        ]);
    }
}