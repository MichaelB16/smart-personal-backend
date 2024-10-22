<?php

namespace App\Services;


use App\Models\User;

class UserService {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function updateOrCreate(array $data): User {
        return $this->user->updateOrCreate([
            'email' => $data['email']
        ],[
            'name' => $data['name'],
            'email' => $data['email'],
            'is_google' => $data['is_google'],
            'picture' => $data['picture'],
            'sub' => $data['sub'],
        ]);
    }
    public function getBySub($sub)
    {
        return $this->user->where('sub', $sub)->firstOrFail();
    }

    public function getByEmail($email)
    {
        return $this->user->where('email', $email)->firstOrFail();
    }

}
