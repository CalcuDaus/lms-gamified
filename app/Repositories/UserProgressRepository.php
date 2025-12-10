<?php

namespace App\Repositories;

use App\Models\UserProgress;
use Illuminate\Database\Eloquent\Collection;

class UserProgressRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getCoursesTaken($id): int
    {
        return UserProgress::where('user_id', $id)->count();
    }

    public function takeACourse($userId, $courseId): UserProgress
    {
        return UserProgress::firstOrCreate([
            'user_id' => $userId,
            'course_id' => $courseId,
        ], [
            'status' => 'in_progress',
            'xp_earned' => 0
        ]);
    }

    public function getStudentCountByTeacher($teacherId): int
    {
        return UserProgress::whereHas('course', function($query) use ($teacherId) {
            $query->where('created_by', $teacherId);
        })->distinct('user_id')->count('user_id');
    }

    public function getStudentsByCourse($courseId): Collection
    {
        return UserProgress::where('course_id', $courseId)
            ->with('user')
            ->get();
    }

    public function getStudentProgressInTeacherCourses($userId, $teacherId): Collection
    {
        return UserProgress::where('user_id', $userId)
            ->whereHas('course', function($query) use ($teacherId) {
                $query->where('created_by', $teacherId);
            })
            ->with('course')
            ->get();
    }
}
