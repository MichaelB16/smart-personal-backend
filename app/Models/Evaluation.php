<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasByUserScope;

    protected $fillable = [
        'user_id',
        'student_id',
        'height',
        'weight',
        'percent_weight',
        'arm',
        'leg',
        'waist',
        'breastplate',
        'observation',
    ];

    protected $table = 'evaluation';
}
