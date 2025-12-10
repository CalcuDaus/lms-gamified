<?php

namespace App\Services;

use App\Repositories\BadgeRepository;

class BadgeService
{
    /**
     * Create a new class instance.
     */
    protected $badgeRepository;
    protected $imageService;

    public function __construct(BadgeRepository $badgeRepository, ImageService $imageService)
    {
        $this->badgeRepository = $badgeRepository;
        $this->imageService = $imageService;
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
        if (request()->hasFile('icon')) {
            $data['icon'] = $this->imageService->convertAndStore(request()->file('icon'), 'badges');
        }
        return $this->badgeRepository->createBadge($data);
    }

    public function updateBadge($id, $data)
    {
        if (request()->hasFile('icon')) {
            // Delete old icon if exists
            $badge = $this->badgeRepository->getBadgeById($id);
            if ($badge->icon) {
                $this->imageService->delete($badge->icon);
            }
            $data['icon'] = $this->imageService->convertAndStore(request()->file('icon'), 'badges');
        } else {
            $badge = $this->badgeRepository->getBadgeById($id);
            $data['icon'] = $badge->icon;
        }
        return $this->badgeRepository->updateBadge($id, $data);
    }
    public function deleteBadge($id)
    {
        $badge = $this->badgeRepository->getBadgeById($id);
        if ($badge->icon) {
            $this->imageService->delete($badge->icon);
        }
        return $this->badgeRepository->deleteBadge($id);
    }
}
