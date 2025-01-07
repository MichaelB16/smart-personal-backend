<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Message extends Model
{
    use HasByUserScope, HasApiTokens, Notifiable, HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'message_pre_class',
        'message_pre_expiry',
        'user_id'
    ];
}
