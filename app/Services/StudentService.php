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
            'total_students' => $this->getCounts(),
            'total_price' => $this->getTotalPrice()
        ];
    }

    protected function getCounts()
    {
        return $this->student->count();
    }

    protected function getTotalPrice()
    {
        return $this->student->sum('price');
    }

    public function getById($id)
    {
        return $this->studentRepository->find($id);
    }

    public function create(array $data)
    {
        $student = $this->studentRepository->create($data);

        $this->sendEmailStudentCreatedService->send([
            'user_id' => $student->id,
            'email' => $data['email'],
            'username' => $data['name'],
        ]);

        return $student;
    }

    public function update(int $id, array $data)
    {
        return $this->studentRepository->update($id, [
            ...$data,
            'date_of_birth' => Carbon::parse($data['date_of_birth'])->format('Y-m-d')
        ]);
    }

    public function delete(int $id)
    {
        return $this->studentRepository->delete($id);
    }
}
