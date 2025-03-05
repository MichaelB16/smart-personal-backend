<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    protected $table = 'diet';

    protected $fillable = [
        'diet',
        'user_id',
        'student_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'id']);
    }
}
