<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends BaseRepository
{
    public function __construct(protected Student $student)
    {
        parent::__construct($student);
    }
}
