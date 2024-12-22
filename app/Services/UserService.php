<?php

namespace App\Services;


use App\Models\User;

class UserService {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find($id) {
        return $this->user->find($id);
    }

    public function create($data) {
        return $this->user->create($data);
    }


    public function update($id, $data) {
        return $this->user->where(['id' => $id])->update($data);
    }

    public function delete($id) {
        return $this->user->where(['id' => $id])->delete();
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
        return $this->user->where(['sub' => $sub])->first();
    }

    public function getByEmail($email)
    {
        return $this->user->where(['email' => $email])->first();
    }

}
