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
    }
}
