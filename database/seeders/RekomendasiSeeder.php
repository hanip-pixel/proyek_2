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
        Rekomendasi::create([
            'nama_produk' => 'Sweety Silver Pants',
            'merek' => 'Sweety',
            'harga_produk' => 2500,
            'stok' => 17,
            'terjual' => 73,
            'foto_produk' => 'sweety.jpg',
            'deskripsi' => '- Merek: Sweety - Bentuk: Popok celana sekali pakai - Warna: Putih dengan motif warna-warni - Komposisi utama: Bahan lembut dan elastis, lapisan penyerap, pelindung anti bocor - Manfaat: Daya serap tinggi untuk menjaga kulit bayi tetap kering, Bahan lembut dan nyaman untuk bayi aktif, Desain elastis yang pas di tubuh bayi tanpa meninggalkan bekas merah',
        ]);
    }
}
