<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'Michael.B',
            'email' => 'michaelbatistasousa@gmail.com',
            'type' => 'personal',
            'password' => Hash::make('123')
        ]);
    }
}
