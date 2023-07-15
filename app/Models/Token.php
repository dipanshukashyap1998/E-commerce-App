<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $casts = [
        'expiry' => 'date'
    ];

    protected $fillable = [
        'name', 'token', 'expiry'
    ];
}
