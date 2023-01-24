<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookingData extends Model
{
    use HasFactory;
    protected $fillable = ['department_id','contact_id','date','booking_id','status'];
    protected $casts = [
        'new_date' => 'array',
    ];
    protected $dateFormat = 'Y-m-d H:i:s';


    public function setDateAttribute( $value ) {
        $this->attributes['date'] = (new Carbon($value))->format('Y-m-d H:i:s');
      }
    
      public function getPublishAttribute($date)
      {
          return Carbon::parse($date)->format('Y-m-d H:i:s');
      }  

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

    public function ProjectStatus()
    {
        return $this->belongsTo(Contact::class);
    }

    
    
}
