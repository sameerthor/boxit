<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foremanNote extends Model
{
    use HasFactory;
    protected $fillable=['foreman_id','notes','date','given_by'];
}
