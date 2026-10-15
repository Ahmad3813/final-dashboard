<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class SchoolAdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teachers')->orderBy('name')->get();

        return view('school.course.index', compact('courses'));
    }
    public function create()
    {

        return view("school.course.create");
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $course = Course::create([
            'name' => $data['name'],
        ]);
        return redirect()->route('school.dashboard');
    }
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if (
            $course->teachers()->exists()
            || $course->classrooms()->exists()
            || $course->students()->exists()
        ) {
            return back()->with('error', 'This course is still assigned and cannot be deleted.');
        }

        $course->delete();

        return redirect()->route('school.courses.index');
    }
}
