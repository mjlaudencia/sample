<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id', // This is the vendor ID (foreign key)
    ];

    /**
     * Get the vendor (seller) who owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for vendor() so you can use $product->seller as well.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class); // adjust if using pivot
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
