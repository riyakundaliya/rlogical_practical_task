<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'qty',
        'status'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
