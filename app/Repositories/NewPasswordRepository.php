<?php

namespace App\Repositories;

use App\Contracts\Repositories\NewPasswordRepositoryInterface;
use App\Models\NewPassword;

class NewPasswordRepository implements NewPasswordRepositoryInterface
{
    public function __construct(protected NewPassword $newPassword) {}

    public function checkToken($token)
    {
        return $this->newPassword
            ->with(['user', 'student'])
            ->where('token', $token)
            ->first();
    }

    public function create(array $data)
    {
        return $this->newPassword->create([
            ...$data,
            'token' => get_uuid()
        ]);
    }

    public function delete(int $user_id)
    {
        return $this->newPassword->where('user_id', $user_id)->delete();
    }
}
