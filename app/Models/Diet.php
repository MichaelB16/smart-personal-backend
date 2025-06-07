<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasByUserScope;

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
