<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    // Di semua migration file, ubah:
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk', 50);
            $table->string('merek', 50)->nullable();  // Tambahkan nullable
            $table->integer('harga_produk');
            $table->integer('stok');  // Tetap 'stok' bukan 'stok_produk'
            $table->integer('terjual')->default(0);  // Tambahkan default
            $table->string('foto_produk', 100)->nullable();  // Perbesar ke 100 karakter
            $table->text('deskripsi');
            $table->timestamps();  // Tambahkan timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
