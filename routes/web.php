<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [LayoutController::class, 'index'])->name('dashboard'); 
    Route::get('/classroom', [ClassroomController::class, 'index'])->name('classroom');
    Route::get('/department', [DepartmentController::class, 'index'])->name('department');
    Route::get('/department/data', [DepartmentController::class, 'data'])->name('department.data');
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/course/data', [CourseController::class, 'data'])->name('course.data');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
