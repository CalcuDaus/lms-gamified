<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Database\Factories\QuizFactory;
use Database\Factories\UserFactory;
use Database\Factories\BadgeFactory;
use Database\Factories\CourseFactory;
use Database\Factories\MaterialFactory;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.test',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'role' => 'admin',
            'avatar' => 'https://images.unsplash.com/photo-1499714608240-22fc6ad53fb2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80',
            'bio' => 'Hello i\'m Administrator',
            'phone' => '1234567890',
            'level' => 1,
            'xp' => 0,
            'next_level_xp' => 100,
        ]);

        UserFactory::new()->count(10)->create();
        CourseFactory::new()->count(5)->create();
        MaterialFactory::new()->count(15)->create();
        QuizFactory::new()->count(5)->create();
        QuestionFactory::new()->count(20)->create();
        BadgeFactory::new()->count(10)->create();
    }
}
