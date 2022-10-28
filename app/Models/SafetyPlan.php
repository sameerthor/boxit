<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyPlan extends Model
{
    protected $guarded = [];  
    protected $casts = [
        'induction_date' => 'array',
        'induction_name' => 'array',
        'sign' => 'array',
];
    use HasFactory;

    public function getInductionNameAttribute($details)
{
    return json_decode($details, true);
}

public function getInductionDateAttribute($details)
{
    return json_decode($details, true);
}

public function getSignAttribute($details)
{
    return json_decode($details, true);
}
}
