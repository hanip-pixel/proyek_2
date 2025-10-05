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
        Schema::create('obat', function (Blueprint $table) {
            $table->id(); // otomatis primary & auto increment
            $table->string('nama_produk', 50);
            $table->string('merek', 50);
            $table->integer('harga_produk');
            $table->integer('stok');
            $table->integer('terjual');
            $table->string('foto_produk', 25);
            $table->text('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
