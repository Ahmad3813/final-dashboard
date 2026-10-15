<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class TeachingAssignmentController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $courses = \App\Models\Course::orderBy('name')->get();
        $teachers = Teacher::with('course')->orderBy('name')->get();

        return view('school.assignments.index', compact('classrooms', 'courses', 'teachers'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $teacher = Teacher::findOrFail($data['teacher_id']);

        if ($teacher->course_id !== (int) $data['course_id']) {
            throw ValidationException::withMessages([
                'teacher_id' => 'This teacher does not teach the selected course.',
            ]);
        }

        $classroom = Classroom::findOrFail($data['classroom_id']);
        if ($classroom->courses()
            ->where('courses.id', $data['course_id'])
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'course_id' => 'This course is already assigned to this classroom.',
            ]);
        }
        $classroom->courses()->attach($data['course_id'], [
            'teacher_id' => $teacher->id,
        ]);

        return back()->with('success', 'Teaching assignment created.');
    }
}
