<?php

namespace App\Models;

use App\Models\Traits\HasByUserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
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
        'date_of_birth',
        'user_id'
    ];

    public function training()
    {
        return $this->hasOne(Training::class, 'student_id', 'id')->select(['training', 'student_id']);
    }

    public function diet()
    {
        return $this->hasOne(Diet::class, 'student_id', 'id')->select(['diet', 'student_id']);
    }

    public function evaluations_months()
    {
        return $this->hasMany(Evaluation::class, 'student_id', 'id')
            ->whereDate('created_at', '<', Carbon::now()->startOfMonth());
    }

    public function evaluations_actual()
    {
        return $this->hasOne(Evaluation::class, 'student_id', 'id')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeByUser($query)
    {
        $id = get_user_id() || null;

        return $query->where('user_id', $id);
    }
}
