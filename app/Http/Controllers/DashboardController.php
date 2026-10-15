<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
   {
      if (!auth()->check()) {
         return redirect()->route('login');
      }
      if (auth()->user()->role === 'school_admin') {
         return redirect()->route('school.dashboard');
      }
      if (auth()->user()->role === 'student') {
         return redirect()->route('student.dashboard');
      }
      if (auth()->user()->role === 'teacher') {
         return redirect()->route('teacher.dashboard');
      }

      return view('dashboard.index');
   }
}
