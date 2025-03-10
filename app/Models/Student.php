<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'weight',
        'height',
        'price',
        'access',
        'active',
        'date_of_birth'
    ];

    public function training()
    {
        return $this->hasOne(Training::class, 'student_id', 'id')->select(['training', 'student_id']);
    }

    public function diet()
    {
        return $this->hasOne(Diet::class, 'student_id', 'id')->select(['diet', 'student_id']);
    }

    public function scopeByUser($query)
    {
        $id = optional(auth()->user())->id || null;

        return $query->where('user_id', $id);
    }
}
