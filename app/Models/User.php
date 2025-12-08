<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserProgress;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'level',
        'xp',
        'next_level_xp',
        'current_streak',
        'last_activity_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Update user's daily streak.
     */
    public function updateStreak()
    {
        $today = now()->toDateString();
        $lastActivity = $this->last_activity_date;

        if ($lastActivity === $today) {
            return; // Already logged in today
        }

        $yesterday = now()->subDay()->toDateString();

        if ($lastActivity === $yesterday) {
            $this->increment('current_streak');
        } elseif ($lastActivity === null || $lastActivity < $yesterday) {
            $this->current_streak = 1;
        }

        $this->last_activity_date = $today;
        $this->save();
    }

    /**
     * Calculate XP required for next level.
     * Formula: level * 100 (e.g., Level 2 needs 200 XP, Level 3 needs 300 XP)
     */
    public function calculateNextLevelXp()
    {
        return $this->level * 100;
    }

    /**
     * Add XP to user and check for level up.
     */
    public function addXp($amount)
    {
        $this->xp += $amount;
        $this->checkLevelUp();
        $this->save();
    }

    /**
     * Check if user should level up and handle level up logic.
     */
    public function checkLevelUp()
    {
        while ($this->xp >= $this->next_level_xp) {
            $this->xp -= $this->next_level_xp; // Carry over excess XP
            $this->level += 1;
            $this->next_level_xp = $this->calculateNextLevelXp();
        }
    }
}
