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
        Schema::create('keranjang_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 15); // Ubah dari integer menjadi string(15)
            $table->string('produk_key', 50);
            $table->string('nama_produk', 100);
            $table->integer('harga_produk');
            $table->string('foto_produk', 100);
            $table->integer('jumlah');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            // Index untuk performa
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_pengguna');
    }
};