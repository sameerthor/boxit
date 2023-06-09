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
    protected $guarded=['id'];
    

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

    public function incident()
    {
        return $this->hasOne(Incident::class,'project_id','id');
    }
    
    public function stripping()
    {
        return $this->hasOne(Stripping::class,'project_id','id');
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
        return $this->hasMany(ProjectStatus::class,'project_id','id');
    }

    public function images()
    {
        return $this->hasMany(Image::class,'project_id','id');
    }

    public function PassedProjectStatus()
    {
        return $this->ProjectStatus()->where('status','!=','0')->where('status','!=','3');
    }

    public function PassedWithCond()
    {
        return $this->ProjectStatus()->where('status','=','3');
    }

    public function SafetyPlan()
    {
        return $this->hasOne(SafetyPlan::class,'project_id','id');
    }
}
