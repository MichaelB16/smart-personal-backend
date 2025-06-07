<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasByUserScope;

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
