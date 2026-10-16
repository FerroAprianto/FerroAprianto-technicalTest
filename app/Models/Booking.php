<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'vehicle_id',
        'driver_id',
        'purpose',
        'description',
        'destination',
        'departure_datetime',
        'return_datetime',
        'passenger_count',
        'status',
        'approver1_id',
        'approved_at_l1',
        'approval_note_l1',
        'approver2_id',
        'approved_at_l2',
        'approval_note_l2',
        'rejection_note',
        'rejected_at',
        'rejected_by',
        'start_km',
        'end_km',
        'fuel_used',
        'usage_notes',
        'actual_departure',
        'actual_return',
    ];

    protected function casts(): array
    {
        return [
            'departure_datetime' => 'datetime',
            'return_datetime' => 'datetime',
            'approved_at_l1' => 'datetime',
            'approved_at_l2' => 'datetime',
            'rejected_at' => 'datetime',
            'actual_departure' => 'datetime',
            'actual_return' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            if (!$booking->booking_number) {
                $booking->booking_number = 'BK-' . date('Ymd') . '-' . str_pad(
                    static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT
                );
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approver1()
    {
        return $this->belongsTo(User::class, 'approver1_id');
    }

    public function approver2()
    {
        return $this->belongsTo(User::class, 'approver2_id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function fuelRecords()
    {
        return $this->hasMany(FuelRecord::class);
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan L1',
            'approved_l1' => 'Menunggu Persetujuan L2',
            'approved_l2' => 'Disetujui',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
            'in_use' => 'Sedang Digunakan',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved_l1' => 'info',
            'approved_l2' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            'in_use' => 'primary',
            'completed' => 'success',
            default => 'secondary',
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'approved_l1' => 'badge-info',
            'approved_l2' => 'badge-success',
            'rejected' => 'badge-danger',
            'cancelled' => 'badge-secondary',
            'in_use' => 'badge-primary',
            'completed' => 'badge-completed',
            default => 'badge-secondary',
        };
    }

    public function getDistanceKm(): ?int
    {
        if ($this->start_km && $this->end_km) {
            return $this->end_km - $this->start_km;
        }
        return null;
    }
}
