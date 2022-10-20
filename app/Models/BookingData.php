<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingData extends Model
{
    use HasFactory;
    protected $fillable = ['department_id','contact_id','date','booking_id'];
    protected $casts = [
        'new_date' => 'array',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
}
