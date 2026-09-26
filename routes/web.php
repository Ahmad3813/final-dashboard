<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;

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

Route::delete('/delete/{blog}', [BlogController::class, 'destroy'])->name('delete');

Route::get('/view-blog/{blog}', [BlogController::class, 'show'])->name('view-blog');

Route::get('/edit-blog/{blog}', [BlogController::class, 'edit'])->name('edit-blog');

Route::put('/update-blog/{blog}', [BlogController::class,   'update'])->name('update');
