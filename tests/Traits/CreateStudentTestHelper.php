<?php

namespace Tests\Traits;

use App\Models\Student;
use Faker;

trait CreateStudentTestHelper
{
    protected function executeCreateStudent(int $userId)
    {
        $faker = Faker\Factory::create();
        return new Student([
            'id' => 1,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->phoneNumber,
            'password' => '123456',
            'height' => 1.80,
            'weight' => 80,
            'price' => 100,
            'date_of_birth' => $faker->date(),
            'access' => 1,
            'user_id' => $userId,
        ]);
    }
}
