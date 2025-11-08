<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => 'Teacher Dashboard',
        ];
        return view('teacher.dashboard', $data);
    }
}
