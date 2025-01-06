<?php

namespace App\Services;


use App\Models\Student;
use Carbon\Carbon;

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

    protected function getTotalPrice () {
        return $this->student->sum('price');
    }

    public function getById($id) {
        return $this->student->find($id);
    }

    public function create($data) {
        return $this->student->create($data);
    }

    public function update($id, $data) {
        return $this->student->where(['id' => $id])->update([
            ...$data,
            'date_of_birth' => Carbon::parse($data['date_of_birth'])->format('Y-m-d')
        ]);
    }

    public function delete($id) {
        return $this->student->where(['id' => $id])->delete();
    }
}
