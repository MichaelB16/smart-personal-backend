<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Services\Mails\SendEmailStudentCreatedService;
use Carbon\Carbon;

class StudentService
{
    public function __construct(
        protected StudentRepositoryInterface $repository,
        protected SendEmailStudentCreatedService $sendEmailStudentCreatedService,
    ) {}

    public function getAll(string $search = '')
    {
        return $this->repository->getAll($search);
    }

    public function getSummary()
    {
        return $this->repository->getSummary();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function getByEmail(string $email)
    {
        return $this->repository->getByEmail($email);
    }

    public function create(array $data)
    {
        $student = $this->repository->create([
            ...$data,
            'user_id' => get_user_id(),
        ]);

        $this->sendEmailStudentCreatedService->send([
            'student_id' => $student->id,
            'email' => $data['email'],
            'username' => $data['name'],
        ]);

        return $student;
    }

    public function update(int $id, array $data)
    {
        if (optional($data)['date_of_birth']) {
            $data['date_of_birth'] = Carbon::parse($data['date_of_birth'])->format('Y-m-d');
        }

        return $this->repository->update($id, [
            ...$data,
            'user_id' => get_user_id(),
        ]);
    }

    public function updateWithoutScope(int $id, array $data)
    {
        return $this->repository->updateWithoutScope($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
