<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detergen extends Model
{
    use HasFactory;

    public $timestamps = false; 

    protected $table = 'detergen';
    
    protected $fillable = [
            'nama_produk',
            'merek',
            'harga_produk',
            'stok',
            'terjual',
            'foto_produk',
            'deskripsi'
    ];
}