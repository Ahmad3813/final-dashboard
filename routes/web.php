<?php

use App\Http\Controllers\school\SchoolAdminTeacherController;
use App\Http\Controllers\school\SchoolAdminCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\school\SchoolAdminClassroomController;
use App\Http\Controllers\school\SchoolAdminStudentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\school\TeacherDashboardController;
use App\Http\Controllers\school\TeachingAssignmentController;
use App\Http\Controllers\school\StudentDashboardController;
use App\Http\Controllers\school\SchoolDashboardController;
use App\Http\Controllers\SchoolTeacherController;
use App\Models\Teacher;

use function Laravel\Prompts\task;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetOtp'])->name('password.email');

Route::get('/reset-password/verify', [AuthController::class, 'showPasswordResetVerification'])->name('password.verify.notice');

Route::post('/reset-password/verify', [AuthController::class, 'verifyPasswordResetOtp'])->name('password.verify');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');

Route::get('/create', [BlogController::class, 'create'])->name('createblog');

Route::post('storeblog', [BlogController::class, 'store'])->name('storeblog');

Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('delete');

Route::get('/view-blog/{id}', [BlogController::class, 'show'])->name('view-blog');

Route::get('/edit-blog/{id}', [BlogController::class, 'edit'])->name('edit-blog');

Route::put('/update-blog/{id}', [BlogController::class,   'update'])->name('update');

Route::get('/view-profile', [ProfileController::class, 'index'])->name('view-profile');

Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('edit-profile');

Route::put('/update-profile/{id}', [ProfileController::class, 'update'])->name('update-profile');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])
        ->name('admin.users.index');

    Route::delete('/admin/users/{id}', [UserManagementController::class, 'destroy'])
        ->name('admin.users.destroy');

    Route::get('/admin/users/{id}/edit', [UserManagementController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/admin/users/{id}/role', [UserManagementController::class, 'updateRole'])
        ->name('admin.users.update-role');
});

Route::get('/admin/tasks', [TaskController::class, 'index'])
    ->middleware(['auth', 'role:super_admin,admin,qa,tester'])
    ->name('admin.tasks.index');



Route::get('/admin/tasks/create', [TaskController::class, 'create'])
    ->middleware(['auth', 'role:super_admin,qa'])
    ->name('admin.tasks.create');

Route::post('/admin/tasks', [TaskController::class, 'store'])
    ->middleware(['auth', 'role:super_admin,qa'])
    ->name('admin.tasks.store');

Route::delete('/admin/tasks/{id}', [TaskController::class, 'destroy'])
    ->middleware(['auth', 'role:qa'])
    ->name('admin.tasks.destroy');

Route::get('/admin/tasks/{id}/edit', [TaskController::class, 'edit'])
    ->middleware(['auth', 'role:qa,tester', 'assigned.task'])
    ->name('admin.tasks.edit');

Route::put('/admin/tasks/{id}', [TaskController::class, 'update'])
    ->middleware(['auth', 'role:qa,tester', 'assigned.task'])
    ->name('admin.tasks.update');

Route::get('/admin/tasks/{id}', [TaskController::class, 'show'])
    ->middleware(['auth', 'role:super_admin,admin,qa,tester', 'assigned.task'])
    ->name('admin.tasks.show');


Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['auth', 'role:student'])
    ->name('student.dashboard');

Route::get('/add-teacher', [SchoolAdminTeacherController::class, 'create'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.add-teacher');

Route::post('/add-teacher', [SchoolAdminTeacherController::class, 'store'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.store-teacher');

Route::get('/add-course', [SchoolAdminCourseController::class, 'create'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.create-course');

Route::post('/add-course', [SchoolAdminCourseController::class, 'store'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.store-course');

Route::get('/add-classroom', [SchoolAdminClassroomController::class, 'create'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.create-classroom');

Route::post('/add-classroom', [SchoolAdminClassroomController::class, 'store'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.store-classroom');

Route::get('/student', [SchoolAdminStudentController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.students.index');

Route::get('/addstudent', [SchoolAdminStudentController::class, 'create'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.students.create');

Route::post('/addstudent', [SchoolAdminStudentController::class, 'store'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.students.store');


Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
    ->middleware(['auth', 'role:teacher'])
    ->name('teacher.dashboard');

Route::get('/teachers', [SchoolAdminTeacherController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.teachers.index');

Route::get('/teaching-assignments', [TeachingAssignmentController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.assignments.index');

Route::post('/teaching-assignments', [TeachingAssignmentController::class, 'store'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.assignments.store');

Route::get('/school/dashboard', [SchoolDashboardController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.dashboard');

Route::delete('/student/{id}', [SchoolAdminStudentController::class, 'destroy'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.students.destroy');

Route::delete('/teacher/{id}', [SchoolAdminTeacherController::class, 'destroy'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.teachers.destroy');

Route::get('/courses', [SchoolAdminCourseController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.courses.index');

Route::delete('/courses/{id}', [SchoolAdminCourseController::class, 'destroy'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.courses.destroy');

Route::get('/classrooms', [SchoolAdminClassroomController::class, 'index'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.classrooms.index');

Route::get('/teachers/{id}', [SchoolAdminTeacherController::class, 'show'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.teachers.show');

Route::get('/students/{id}', [SchoolAdminStudentController::class, 'show'])
    ->middleware(['auth', 'role:school_admin'])
    ->name('school.students.show');
