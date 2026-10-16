<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'booking_id',
        'user_id',
        'refuel_date',
        'liters',
        'cost_per_liter',
        'total_cost',
        'odometer_km',
        'fuel_station',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'refuel_date' => 'date',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
