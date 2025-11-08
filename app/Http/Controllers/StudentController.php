<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title' => 'Student Dashboard',
        ];
        return view('student.dashboard', $data);
    }
}
