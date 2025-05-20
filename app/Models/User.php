<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'contact_number',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * A vendor (user) can have many products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * A user can have many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * A user can have many cart items.
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get all ratings for the products sold by this vendor.
     */
    public function receivedRatings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Product::class,
            'user_id',   // Foreign key on products table
            'product_id', // Foreign key on ratings table
            'id',         // Local key on users table
            'id'          // Local key on products table
        );
    }

    /**
     * Average rating of all products sold by this vendor.
     */
    public function averageRating()
    {
        return $this->receivedRatings()->avg('rating');
    }
    public function ratings()
{
    // All ratings where ratings.user_id = this user (vendor) id
    return $this->hasMany(Rating::class, 'user_id');
}
}
