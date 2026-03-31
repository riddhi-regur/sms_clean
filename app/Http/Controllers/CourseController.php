<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function index(Request $request)
    {
         $course = $this->courseService->getAllCourses();

        return view('course.index', compact('course'));
    }
}
