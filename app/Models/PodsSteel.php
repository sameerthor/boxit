<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PodsSteel extends Model
{
    use HasFactory;
    protected $fillable = [
        'label'
    ];
    
    protected $table = 'pods_steel_label';

    public function PodsSteelValue($id)
    {
        return $this->hasMany(PodsSteelValue::class,'pods_steel_label_id','id')->where('pods_steel_value.project_id','=', $id);
    }

}
