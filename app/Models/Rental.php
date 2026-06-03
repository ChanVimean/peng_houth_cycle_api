<?php

namespace App\Models;

use Database\Factories\RentalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    /** @use HasFactory<RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bike_id',
        'pickup_station_id',
        'return_station_id',
        'started_at',
        'ended_at',
        'status',
        'base_price',
        'base_minute',
        'extra_price',
        'extra_minute',
        'duration_minute',
        'total_price',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'base_price' => 'decimal:2',
        'extra_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }

    public function pickupStation()
    {
        return $this->belongsTo(Station::class, 'pickup_station_id');
    }

    public function returnStation()
    {
        return $this->belongsTo(Station::class, 'return_station_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
