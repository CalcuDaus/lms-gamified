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
        // Seed demo data
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
