<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    //

    public function index()
    {
        return view('school.teachers.dashboard');
    }
}
