<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug',
        'price',
        'image',
        'description',
        'status',
        'quantity',
        'category_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsto(User::class);
    }
}
