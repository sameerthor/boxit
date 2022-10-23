<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectQaChecklist extends Model
{
    use HasFactory;
    
    protected $table = 'project_qa_checklist';


}
