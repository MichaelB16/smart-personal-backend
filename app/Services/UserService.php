<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

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
                'is_google' => $data['is_google']
            ]
        );
    }

    public function getBySub($sub)
    {
        return $this->userRepository->getBySub($sub);
    }

    public function getByEmail($email)
    {
        return $this->userRepository->getByEmail($email);
    }
}
