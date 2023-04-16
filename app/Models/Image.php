<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

   public function scopeForm($query,$form_name,$field_id)
   {
    return $query->where(array('form_name'=>$form_name,'field_id'=>$field_id));
   }
}
