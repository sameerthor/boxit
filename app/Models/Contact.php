<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'email', 'contact','department_id',
    ];
    public function departments()
{
    return $this->hasMany('Department');
}
}
