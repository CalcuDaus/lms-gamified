<?php

namespace App\Services;

use App\Repositories\XpLogRepository;

class XpLogService
{
    /**
     * Create a new class instance.
     */
    protected $xpLogRepository;

    public function __construct(XpLogRepository $xpLogRepository)
    {
        $this->xpLogRepository = $xpLogRepository;
    }

    /**
     * Log XP gain for a user.
     */
    public function logXp($userId, $amount, $source, $description = null)
    {
        return $this->xpLogRepository->createLog([
            'user_id' => $userId,
            'amount' => $amount,
            'source' => $source,
            'description' => $description,
        ]);
    }

    /**
     * Get user's XP logs.
     */
    public function getUserLogs($userId)
    {
        return $this->xpLogRepository->getUserLogs($userId);
    }
}
