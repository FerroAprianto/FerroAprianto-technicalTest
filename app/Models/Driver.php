<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_number',
        'license_type',
        'license_expiry',
        'phone',
        'employee_id',
        'location',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'license_expiry' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isLicenseExpired(): bool
    {
        return $this->license_expiry->isPast();
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'on_duty' => 'Bertugas',
            'off' => 'Off Duty',
            'inactive' => 'Tidak Aktif',
            default => $this->status,
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'available' => 'success',
            'on_duty' => 'warning',
            'off' => 'secondary',
            'inactive' => 'danger',
            default => 'secondary',
        };
    }
}
