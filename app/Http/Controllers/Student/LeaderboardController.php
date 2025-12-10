<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $topUsers = $this->userRepository->getAllUsers()->sortByDesc('xp')->take(10);
        $data = [
            'title' => 'Leaderboard',
            'topUsers' => $topUsers,
            'currentUser' => Auth::user(),
        ];
        return view('student.leaderboard', $data);
    }
}
