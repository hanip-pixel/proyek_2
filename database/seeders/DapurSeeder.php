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
        Dapur::create([
            'nama_produk' => 'Beras Super Rajoele',
            'merek' => 'Rajoele',
            'harga_produk' => 1400,
            'stok' => 57,
            'terjual' => 59,
            'foto_produk' => 'beras.jpg',
            'deskripsi' => '- Isi: 1kg - Bentuk: Butiran beras putih - Manfaat: Sumber utama karbohidrat yang memberikan energi, Digunakan untuk membuat nasi dan berbagai masakan lainnya - Cara penggunaan: Cuci beras hingga bersih, masak dengan air sesuai perbandingan yang disarankan',

        ]);
    }
}
