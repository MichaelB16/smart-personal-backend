<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(protected UserRepository $userRepository, protected User $user) {}

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function create($data)
    {
        return $this->userRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function updateOrCreate(array $data)
    {
        return $this->userRepository->updateOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'is_google' => $data['is_google'],
                'google_access_token' => $data['google_access_token'],
                'picture' => $data['picture'],
                'sub' => $data['sub'],
            ]
        );
    }

    public function getBySub($sub)
    {
        return $this->user->where(['sub' => $sub])->first();
    }

    public function getByEmail($email)
    {
        return $this->user->where(['email' => $email])->first();
    }
}
