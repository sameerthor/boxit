<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPerDate extends Model
{
    use HasFactory;

   protected $table='forms_per_date';

   public function qasign()
   {
       return $this->hasOne(QaSign::class,'qa_id','id');
   }

   public function incident()
   {
       return $this->hasOne(Incident::class,'form_id','id');
   }

   public function SafetyPlan()
   {
       return $this->hasOne(SafetyPlan::class,'form_id','id');
   }

   public function images()
   {
       return $this->hasMany(Image::class,'form_id','id');
   }

   public function creator()
    {
        return $this->belongsTo(User::class,'creator_id');
    }
}
