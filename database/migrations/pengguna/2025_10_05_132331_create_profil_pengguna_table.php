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
        Schema::create('profil_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable();
            $table->string('kelamin', 10)->nullable();
            $table->string('email', 50)->unique();
            $table->date('tanggal_lahir')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('kabupaten', 20)->nullable();
            $table->string('kecamatan', 25)->nullable();
            $table->string('desa', 25)->nullable();
            $table->integer('rt_rw')->nullable();
            $table->text('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_pengguna');
    }
};
