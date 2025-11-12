<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'file',
        'xp_reward',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
