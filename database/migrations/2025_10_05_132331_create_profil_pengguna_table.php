<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_pengguna', function (Blueprint $table) {
            $table->string('username', 15)->primary(); // ✅ UBAH: string sebagai primary key
            $table->string('nama', 50)->nullable();
            $table->string('kelamin', 10)->nullable();
            $table->string('email', 50);
            $table->date('tanggal_lahir')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('kabupaten', 20)->nullable();
            $table->string('kecamatan', 25)->nullable();
            $table->string('desa', 25)->nullable();
            $table->integer('rt_rw')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            
            // Foreign key ke tabel pengguna
            $table->foreign('username')->references('username')->on('pengguna');
            $table->foreign('email')->references('email')->on('pengguna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_pengguna');
    }
};