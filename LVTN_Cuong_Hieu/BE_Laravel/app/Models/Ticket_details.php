<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_details extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'seat_number', 'price'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}