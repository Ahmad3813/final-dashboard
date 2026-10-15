<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;

class SchoolAdminTeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with(['user', 'course', 'classrooms'])
            ->orderBy('name')
            ->get();

        return view('school.teachers.index', compact('teachers'));
    }
    public function create()
    {
        $courses = \App\Models\Course::orderBy('name')->get();

        return view('school.teachers.create', compact('courses'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'teacher',
        ]);

        Teacher::create([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('school.teachers.index');
    }

    public function show($id)
    {
        $teacher = Teacher::with(['user', 'course', 'classrooms'])->findOrFail($id);

        return view('school.teachers.show', compact('teacher'));
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = $teacher->user;

        $teacher->classrooms()->detach();
        $teacher->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->route('school.teachers.index');
    }
}
