<?php

namespace App\Services;

use App\Models\Student;
use App\Repositories\StudentRepository;
use Carbon\Carbon;

class StudentService
{
    public function __construct(protected  Student $student, protected StudentRepository $studentRepository) {}

    public function getAll($search = '')
    {
        return $this->student->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(limit_pagination());
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

    public function create($data)
    {
        return $this->studentRepository->create($data);
    }

    public function update($id, $data)
    {
        return $this->studentRepository->update($id, [
            ...$data,
            'date_of_birth' => Carbon::parse($data['date_of_birth'])->format('Y-m-d')
        ]);
    }

    public function delete($id)
    {
        return $this->studentRepository->delete($id);
    }
}
