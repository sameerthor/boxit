<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectStatus extends Model
{
    use HasFactory;
    
    protected $table = 'project_status';

    protected $fillable = [
        'project_id', 'status_label_id', 'status','reason','notes'
    ];

}
