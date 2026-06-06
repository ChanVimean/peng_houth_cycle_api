<?php

namespace App\Models;

use Database\Factories\StationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    /** @use HasFactory<StationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'capacity',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }

    public function pickupRentals()
    {
        return $this->hasMany(Rental::class, 'pickup_station_id');
    }

    public function returnRentals()
    {
        return $this->hasMany(Rental::class, 'return_station_id');
    }
}
