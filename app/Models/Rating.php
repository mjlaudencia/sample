<?php

// app/Models/Rating.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // who gave the rating
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
{
    return $this->belongsTo(User::class, 'user_id'); // rating belongs to a vendor (user)

    
}


}
