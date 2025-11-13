<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;
    protected $fillable = [
        'material_id',
        'title',
        'xp_reward',
        'time_limit',
        'passing_score',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
