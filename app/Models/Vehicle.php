<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'brand',
        'model',
        'year',
        'type',
        'ownership',
        'rental_company',
        'location',
        'fuel_capacity',
        'fuel_consumption',
        'last_service_date',
        'last_service_km',
        'next_service_km',
        'status',
        'color',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'last_service_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function fuelRecords()
    {
        return $this->hasMany(FuelRecord::class);
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    public function getTypeLabel(): string
    {
        return $this->type === 'passenger' ? 'Angkutan Orang' : 'Angkutan Barang';
    }

    public function getOwnershipLabel(): string
    {
        return $this->ownership === 'own' ? 'Milik Perusahaan' : 'Sewa';
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'in_use' => 'Digunakan',
            'maintenance' => 'Perawatan',
            'retired' => 'Tidak Aktif',
            default => $this->status,
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'available' => 'success',
            'in_use' => 'warning',
            'maintenance' => 'danger',
            'retired' => 'secondary',
            default => 'secondary',
        };
    }
}
