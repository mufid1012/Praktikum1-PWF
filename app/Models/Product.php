<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'qty',
        'price',
    ];

    /**
     * Get the user that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the kategori that owns the product.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }

    /**
     * Accessor: $product->quantity returns the qty column.
     */
    public function getQuantityAttribute()
    {
        return $this->attributes['qty'] ?? null;
    }

    /**
     * Mutator: $product->quantity = x sets the qty column.
     */
    public function setQuantityAttribute($value)
    {
        $this->attributes['qty'] = $value;
    }
}
