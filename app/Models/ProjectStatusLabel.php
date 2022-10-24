<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectStatusLabel extends Model
{
    use HasFactory;
    
    protected $table = 'project_status_label';

    public function ProjectStatus($id)
    {
        return $this->hasMany(ProjectStatus::class,'status_label_id','id')->where('project_status.project_id','=', $id);
    }

}
