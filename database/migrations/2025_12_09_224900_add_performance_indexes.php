<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds indexes to frequently queried fields
     * to improve database query performance.
     */
    public function up(): void
    {
        // Users table - for leaderboard and login queries
        Schema::table('users', function (Blueprint $table) {
            $table->index('email');           // Login lookups
            $table->index('xp');              // Leaderboard sorting
            $table->index('level');           // Level-based queries
            $table->index('role');            // Role-based filtering
        });

        // Courses table - for teacher's course listings
        Schema::table('courses', function (Blueprint $table) {
            $table->index('created_by');      // Teacher's courses lookup
        });

        // Materials table - for course materials lookup
        Schema::table('materials', function (Blueprint $table) {
            $table->index('course_id');       // Material by course lookup
        });

        // Quizzes table - for material quizzes lookup
        Schema::table('quizzes', function (Blueprint $table) {
            $table->index('material_id');     // Quiz by material lookup
        });

        // Questions table - for quiz questions lookup
        Schema::table('questions', function (Blueprint $table) {
            $table->index('quiz_id');         // Questions by quiz lookup
        });

        // User quiz attempts - for progress tracking
        Schema::table('user_quiz_attemps', function (Blueprint $table) {
            $table->index('user_id');                        // User's attempts lookup
            $table->index('quiz_id');                        // Quiz attempts lookup
            $table->index('passed');                         // Passed/failed filtering
            $table->index(['user_id', 'quiz_id']);           // Composite: user's attempts on specific quiz
            $table->index(['user_id', 'quiz_id', 'passed']); // Composite: check if user passed quiz
        });

        // User progress - for course enrollment tracking
        Schema::table('user_progress', function (Blueprint $table) {
            $table->index('user_id');                        // User's enrollments lookup
            $table->index('course_id');                      // Course enrollments lookup
            $table->index(['user_id', 'course_id']);         // Composite: check enrollment
        });

        // XP logs - for XP history lookup
        Schema::table('xp_logs', function (Blueprint $table) {
            $table->index('user_id');         // User's XP history lookup
            $table->index('source');          // XP source filtering
        });

        // User badges - for badge lookups
        Schema::table('user_badges', function (Blueprint $table) {
            $table->index('user_id');         // User's badges lookup
            $table->index('badge_id');        // Badge holders lookup
        });

        // Badges table - for XP-based badge queries
        Schema::table('badges', function (Blueprint $table) {
            $table->index('min_xp');          // Badge eligibility queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['email']);
            $table->dropIndex(['xp']);
            $table->dropIndex(['level']);
            $table->dropIndex(['role']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropIndex(['course_id']);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropIndex(['material_id']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['quiz_id']);
        });

        Schema::table('user_quiz_attemps', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['quiz_id']);
            $table->dropIndex(['passed']);
            $table->dropIndex(['user_id', 'quiz_id']);
            $table->dropIndex(['user_id', 'quiz_id', 'passed']);
        });

        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['course_id']);
            $table->dropIndex(['user_id', 'course_id']);
        });

        Schema::table('xp_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['source']);
        });

        Schema::table('user_badges', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['badge_id']);
        });

        Schema::table('badges', function (Blueprint $table) {
            $table->dropIndex(['min_xp']);
        });
    }
};
