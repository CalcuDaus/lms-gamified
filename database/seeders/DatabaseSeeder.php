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

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        UserFactory::new()->count(10)->create();
        CourseFactory::new()->count(5)->create();
        MaterialFactory::new()->count(15)->create();
        QuizFactory::new()->count(5)->create();
        QuestionFactory::new()->count(20)->create();
        BadgeFactory::new()->count(10)->create();
    }
}
