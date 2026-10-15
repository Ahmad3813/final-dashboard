<?php

namespace App\Http\Controllers\school;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Contracts\View\View;


class SchoolDashboardController extends Controller
{
    public function index(): View
    {
        $counts = [
            'classrooms' => Classroom::count(),
            'courses' => Course::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
        ];

        
        $classrooms = Classroom::withCount('students')
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('school.dashboard', compact('counts', 'classrooms'));
    }
    
}
