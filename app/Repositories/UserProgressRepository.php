<?php

namespace App\Repositories;

use App\Models\UserProgress;

class UserProgressRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getCoursesTaken($id)
    {
        return UserProgress::where('user_id', $id)->count();
    }

    public function takeACourse($userId, $courseId)
    {
        return UserProgress::firstOrCreate([
            'user_id' => $userId,
            'course_id' => $courseId,
        ], [
            'status' => 'in_progress',
            'xp_earned' => 0
        ]);
    }
}
