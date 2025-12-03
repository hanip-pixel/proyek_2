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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('produk_id');
            $table->string('tabel', 50);
            $table->string('email', 100)->nullable()->unique();
            $table->string('nama', 100);
            $table->text('komentar');
            $table->integer('rating')->default(0);
            $table->dateTime('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
