<?php

namespace App\Models;

use Database\Factories\BikeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    /** @use HasFactory<BikeFactory> */
    use HasFactory;

    protected $fillable = [
        'station_id',
        'code',
        'name',
        'type',
        'status',
        'battery_level',
        'base_price',
        'base_minute',
        'extra_price',
        'extra_minute',
        'description',
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
