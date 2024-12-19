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
        'date_of_birth'
    ];
}
