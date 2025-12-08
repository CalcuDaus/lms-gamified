<?php

namespace App\Repositories;

use App\Models\XpLog;

class XpLogRepository
{
    /**
     * Create a new XP log entry.
     */
    public function createLog($data)
    {
        return XpLog::create([
            'user_id' => $data['user_id'],
            'xp_amount' => $data['amount'],
            'source' => $data['source'],
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * Get user's XP logs.
     */
    public function getUserLogs($userId)
    {
        return XpLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
