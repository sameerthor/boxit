<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    use HasFactory;
    protected $fillable = ['staff_id','from_date','to_date'];

    public function user()
    {
        return $this->belongsTo(User::class,'staff_id');
    }
}
