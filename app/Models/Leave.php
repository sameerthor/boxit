<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Leave extends Model
{
    use HasFactory;
    protected $fillable = ['title','date','note'];

    public function setDateAttribute( $value ) {
        $this->attributes['date'] = (new Carbon($value))->format('Y-m-d H:i:s');
      }
    
      public function getDateAttribute($date)
      {
          return Carbon::parse($date)->format('Y-m-d H:i:s');
      }  

}
