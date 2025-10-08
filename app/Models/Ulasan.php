<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';
    
    protected $fillable = [
        'user_id',
        'produk_id',
        'tabel',
        'email',
        'nama',
        'komentar',
        'rating',
        'tanggal',
    ];
    
    protected $casts = [
        'tanggal'    => 'datetime',
    ];
}