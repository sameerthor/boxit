<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QaSign extends Model
{
    use HasFactory;
    protected $fillable = ['qa_id','foreman_sign'];

    protected $table = 'qasign';


}
