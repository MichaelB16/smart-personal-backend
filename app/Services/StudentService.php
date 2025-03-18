<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Services\Mails\SendEmailStudentCreatedService;
use Carbon\Carbon;

class StudentService
{
    public function __construct(
        protected  Student $student,
        protected StudentRepository $studentRepository,
        protected NewPasswordService $newPasswordService,
        protected SendEmailStudentCreatedService $sendEmailStudentCreatedService,
    ) {}

    public function getAll(string $search = '')
    {
        return $this->student
            ->with(['training', 'diet'])
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(limit_pagination());
    }

    public function getSummary()
    {
        return [
            'total_students' => $this->student->count(),
            'total_price' => $this->student->sum('price')
        ];
    }

    public function getById(int $id)
    {
        return $this->studentRepository->find($id);
    }

    public function getByEmail(string $email)
    {
        return $this->studentRepository->findByEmail($email);
    }

    public function create(array $data)
    {
        $student = $this->studentRepository->create([
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

        return $this->studentRepository->update($id, [
            ...$data,
            'user_id' => get_user_id(),
        ]);
    }

    public function updateWithoutScope(int $id, array $data)
    {
        return $this->studentRepository->updateWithoutScope($id, $data);
    }

    public function delete(int $id)
    {
        return $this->studentRepository->delete($id);
    }
}
