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

    public function MarkoutChecklist()
    {
        return $this->hasOne(MarkoutChecklist::class,'project_id','id');
    }

    public function ProjectStatus()
    {
        return $this->hasOne(ProjectStatus::class,'project_id','id');
    }
}
