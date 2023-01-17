<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $casts = [
        'file' => 'array'
    ];

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
    public function qasign()
    {
        return $this->hasOne(QaSign::class,'qa_id','id');
    }
    
    public function boxing()
    {
        return $this->hasOne(Boxing::class,'project_id','id');
    }

    public function StartupChecklist()
    {
        return $this->hasOne(StartupChecklist::class,'project_id','id');
    }

    public function ProjectStatus()
    {
        return $this->hasOne(ProjectStatus::class,'project_id','id');
    }

    public function SafetyPlan()
    {
        return $this->hasOne(SafetyPlan::class,'project_id','id');
    }
}
