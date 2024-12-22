<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NewPassword extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'new_password';

    protected $fillable = [
        'user_id',
        'token'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select(['id', 'name']);
    }
}
