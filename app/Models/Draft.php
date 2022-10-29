<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $guarded = [];  
    use HasFactory;
    protected $casts = [
        'file' => 'array'
    ];
    
    public function DraftData()
    {
        return $this->hasMany(DraftData::class);
    }

    public function foreman()
    {
        return $this->belongsTo(User::class);
    }
}
