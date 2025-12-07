<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalasanUlasan extends Model
{
    protected $table = 'balasan_ulasan';
    
    protected $fillable = [
        'ulasan_id',
        'admin_id',
        'pesan',
        'tanggal'
    ];
    
    protected $casts = [
        'tanggal' => 'datetime'
    ];
    
    public function ulasan()
    {
        return $this->belongsTo(Ulasan::class);
    }
}