<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasByUserScope;

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
}
