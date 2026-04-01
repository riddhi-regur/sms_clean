<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'role:'.Role::ADMIN])->group(function () {
    Route::get('/dashboard', [LayoutController::class, 'index'])->name('dashboard');

    Route::get('/classroom/data', [ClassroomController::class, 'data'])->name('classroom.data');
    Route::resource('classroom', ClassroomController::class);

    Route::get('/department/data', [DepartmentController::class, 'data'])->name('department.data');
    Route::resource('department', DepartmentController::class);

    Route::get('/course/data', [CourseController::class, 'data'])->name('course.data');
    Route::resource('course', CourseController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
