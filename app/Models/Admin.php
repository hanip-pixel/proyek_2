<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    
    protected $primaryKey = 'username'; 
    public $incrementing = false;

    public $timestamps = false; 

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }
}