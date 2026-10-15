<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', auth()->id())->first();
        $courses = $student?->classroom?->courses ?? collect();

        foreach ($courses as $course) {
            $teacher = Teacher::find($course->pivot->teacher_id);
            $course->teacher_name = $teacher?->name ?? 'Not assigned';
        }
        return view('school.students.dashboard', compact('student', 'courses'));
    }
}
