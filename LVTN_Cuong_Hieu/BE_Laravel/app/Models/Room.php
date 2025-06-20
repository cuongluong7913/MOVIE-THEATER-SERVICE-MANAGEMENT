<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'type',
        'seat_count',
        'status'
    ];

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            0 => 'available',
            1 => 'unavailable',
            2 => 'under_maintenance',
            default => 'unknown',
        };
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}