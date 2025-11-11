<?php

namespace App\Services;

use App\Repositories\BadgeRepository;

class BadgeService
{
    /**
     * Create a new class instance.
     */
    protected $badgeRepository;
    public function __construct(BadgeRepository $badgeRepository)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function getAllBadges()
    {
        return $this->badgeRepository->getAllBadges();
    }
    public function getBadgeById($id)
    {
        return $this->badgeRepository->getBadgeById($id);
    }
    public function createBadge($data)
    {
        return $this->badgeRepository->createBadge($data);
    }

    public function updateBadge($id, $data)
    {
        return $this->badgeRepository->updateBadge($id, $data);
    }
    public function deleteBadge($id)
    {
        return $this->badgeRepository->deleteBadge($id);
    }
}
