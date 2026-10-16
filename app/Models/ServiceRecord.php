<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'service_date',
        'service_type',
        'description',
        'odometer_km',
        'cost',
        'workshop',
        'next_service_date',
        'next_service_km',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'next_service_date' => 'date',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
