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
    }
}
