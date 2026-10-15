<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;


class SchoolAdminStudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classroom'])
            ->orderBy('name')
            ->get();

        return view('school.students.index', compact('students'));
    }
    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();

        return view('school.students.create', compact('classrooms'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'classroom_id' => 'required|exists:classrooms,id',
        ]);
        $classroom = Classroom::findOrFail($data['classroom_id']);

        if ($classroom->students()->count() >= $classroom->capacity) {
            return back()
                ->withErrors(['classroom_id' => 'This classroom is full.'])
                ->withInput();
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'student',
        ]);

        $student = Student::create([
            'name' => $data['name'],
            'classroom_id' => $data['classroom_id'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('school.students.index');
    }
    public function show($id)
    {
        $student = Student::with(['user', 'classroom.courses'])->findOrFail($id);
        $teachers = Teacher::pluck('name', 'id');

        return view('school.students.show', compact('student', 'teachers'));
    }
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $student->courses()->detach();
        $student->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->route('school.students.index');
    }
}
