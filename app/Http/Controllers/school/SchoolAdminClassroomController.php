<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class SchoolAdminClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::withCount('students')
            ->orderBy('name')
            ->get();

        return view('school.classrooms.index', compact('classrooms'));
    }
    public function create()
    {
        return view('school.classrooms.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'class_year' => 'required|string|max:255',
        ]);
        $school = Classroom::create([
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'class_year' => $data['class_year'],

        ]);
        return redirect()->route('school.dashboard');
    }
}
