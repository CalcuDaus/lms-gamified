<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'First Steps',
                'icon' => '🌟',
                'description' => 'Welcome to the learning journey!',
                'min_xp' => 0,
            ],
            [
                'name' => 'Getting Started',
                'icon' => '🔥',
                'description' => 'Earned 100 XP - You\'re on fire!',
                'min_xp' => 100,
            ],
            [
                'name' => 'Rising Star',
                'icon' => '⭐',
                'description' => 'Earned 500 XP - You\'re a rising star!',
                'min_xp' => 500,
            ],
            [
                'name' => 'Quiz Master',
                'icon' => '🏆',
                'description' => 'Earned 1000 XP - Master of quizzes!',
                'min_xp' => 1000,
            ],
            [
                'name' => 'Diamond Learner',
                'icon' => '💎',
                'description' => 'Earned 2500 XP - Rare and brilliant!',
                'min_xp' => 2500,
            ],
            [
                'name' => 'Champion',
                'icon' => '👑',
                'description' => 'Earned 5000 XP - Legendary learner!',
                'min_xp' => 5000,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['name' => $badge['name']],
                $badge
            );
        }
    }
}
