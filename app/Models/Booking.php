<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

 
    public function BookingData()
    {
        return $this->hasMany(BookingData::class);
    }

    public function foreman()
    {
        return $this->belongsTo(User::class);
    }
}
