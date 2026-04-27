<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the products for the kategori.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
