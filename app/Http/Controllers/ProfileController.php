<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a user's public profile.
     */
    public function show($userId)
    {
        $user = User::with('badges')->findOrFail($userId);
        
        $data = [
            'title' => $user->name . ' - Profile',
            'profileUser' => $user,
        ];
        
        return view('profile.show', $data);
    }
}
