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
        Schema::create('balasan_ulasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ulasan_id')
                  ->constrained('ulasan')
                  ->onDelete('cascade');
            $table->string('admin_id')->nullable(); // ID admin yang membalas
            $table->text('pesan');
            $table->dateTime('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balasan_ulasan');
    }
};