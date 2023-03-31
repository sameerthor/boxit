<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCheckboxStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'status'
    ];
    protected $casts = [
        'status' => 'array',
    ];
}
