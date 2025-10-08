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
            'terjual' => 79,
            'foto_produk' => 'rinso.jpg',
            'deskripsi' => '- Bentuk: Bubuk- Warna: Putih- Komposisi utama: Deterjen, bahan penghilang noda, pelembut pakaian- Manfaat: Membersihkan pakaian dari noda dan kotoran, Membuat pakaian lebih harum dan lembut, Bisa digunakan untuk mesin cuci atau cucian tangan',

        ]);Detergen::FirstOrCreate([
            'nama_produk' => 'Molto 1 Rencang',
            'merek' => 'Molto',
            'harga_produk' => 5000,
            'stok' => 72,
            'terjual' => 91,
            'foto_produk' => 'molto.jpg',
            'deskripsi' => '- Bentuk: Cair- Warna: Biru, Pink, Hijau (tergantung varian)- Komposisi utama: Pewangi dan pelembut pakaian- Manfaat: Memberikan aroma segar dan tahan lama pada pakaian, Melembutkan kain setelah dicuci, Membantu menjaga kelembutan pakaian sepanjang hari',

        ]);
    }
}
