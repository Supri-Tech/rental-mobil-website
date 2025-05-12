<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    use HasFactory;

    // Menonaktifkan timestamp
    public $timestamps = false;

    protected $table = 'car_categories';
    protected $fillable = ['name', 'description'];

    // Relasi dengan model Car
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
