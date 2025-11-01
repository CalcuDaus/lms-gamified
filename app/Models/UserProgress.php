<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    /** @use HasFactory<\Database\Factories\UserProgressFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'xp_earned',
    ];
}
