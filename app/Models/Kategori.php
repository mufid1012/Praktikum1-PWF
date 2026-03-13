<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'product_id',
        'name',
    ];

    /**
     * Get the product that owns the kategori.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
