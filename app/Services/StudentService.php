<?php

namespace App\Services;


use App\Models\Student;

class StudentService
{
    public function __construct(protected  Student $student)
    {
    }

    public function getAll($search = '')
    {
        return $this->student->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->paginate(limit_pagination());
    }
    public function getById($id) {
        return $this->student->find($id);
    }

    public function create($data) {
        return $this->student->create($data);
    }

    public function update($id, $data) {
        return $this->student->where(['id' => $id])->update($data);
    }

    public function delete($id) {
        return $this->student->where(['id' => $id])->delete();
    }
}
