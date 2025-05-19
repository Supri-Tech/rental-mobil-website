<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand',
        'model',
        'license_plate',
        'year',
        'transmission',
        'fuel_type',
        'passenger_capacity',
        'base_price_per_day',
        'status',
        'image_primary',
        'images_additional',
    ];

    public function category()
    {
        return $this->belongsTo(CarCategory::class);
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class);
    }
}
