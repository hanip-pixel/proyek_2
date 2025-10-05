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
        Schema::create('riwayat_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('produk_id');
            $table->string('tabel_produk', 20);
            $table->string('nama_produk', 50);
            $table->integer('harga_produk');
            $table->integer('ongkir');
            $table->integer('layanan');
            $table->integer('jasa');
            $table->integer('quantity');
            $table->integer('total_harga');
            $table->string('metode_pembayaran', 20);
            $table->string('foto_produk', 25);
            $table->enum('status', ['dikemas', 'dikirim', 'selesai'])->default('dikemas')->nullable();
            $table->timestamp('tanggal_transaksi')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksi');
    }
};
