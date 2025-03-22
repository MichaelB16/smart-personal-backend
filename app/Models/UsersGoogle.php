<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGoogle extends Model
{
    protected $table = 'users_google';

    protected $fillable = [
        'google_access_token',
        'picture',
        'sub',
        'user_id',
    ];
}
