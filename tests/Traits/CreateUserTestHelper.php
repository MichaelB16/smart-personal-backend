<?php

namespace Tests\Traits;

use App\Models\User;
use Faker;
use Illuminate\Support\Facades\Hash;

trait CreateUserTestHelper
{
    protected function executeCreateUser()
    {
        Hash::setRounds(4);
        $faker = Faker\Factory::create();
        return new User([
            'id' => 1,
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->phoneNumber,
            'type' => 'personal',
            'password' => bcrypt('123456'),
        ]);
    }
}
