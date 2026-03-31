<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function getAllCourses()
    {
        $course = Course::with('department')->get();
         return $course;
    }
}