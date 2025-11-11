<?php

namespace App\Repositories;

use App\Models\Badge;

class BadgeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllBadges()
    {
        return Badge::all();
    }
    public function getBadgeById($id)
    {
        return Badge::find($id);
    }
    public function createBadge($data)
    {
        return Badge::create($data);
    }
    public function updateBadge($id,$data)
    {
        $badge = Badge::find($id);
        $badge->update($data);
        return $badge;
    }
    public function deleteBadge($id)
    {
        $badge = Badge::find($id);
        return $badge->delete();
    }
}
