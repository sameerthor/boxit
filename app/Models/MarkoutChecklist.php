<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkoutChecklist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date', 'address', 'housing_company', 'power', 'site_fenced', 'toilet', 'water', 'boundary_pegs', 'draw_in', 'boundary_dimension', 'ffl_set', 'ffl_height_min', 'ffl_height_max', 'project_id'
    ];
    
    protected $table = 'markout_checklist';

    


}
