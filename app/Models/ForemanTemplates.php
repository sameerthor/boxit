<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForemanTemplates extends Model
{
    use HasFactory;

    public function ProjectStatusLabel()
    {
        return $this->belongsTo(ProjectStatusLabel::class);
    }
}
