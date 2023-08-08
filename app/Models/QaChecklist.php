<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QaChecklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject'
    ];
    
    protected $table = 'qa_checklist';

    public function ProjectQaChecklist($id)
    {
        return $this->hasMany(ProjectQaChecklist::class)->where('project_qa_checklist.form_id','=', $id);
    }

}
