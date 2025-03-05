<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'training';

    protected $fillable = [
        'training',
        'user_id',
        'student_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }
}
