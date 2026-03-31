<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function getAllCourses()
    {
        $course = Course::select(['id','name', 'code', 'department_id' ,'fees','duration','description'])
    ->with('department:id,name')
    ->get();
         return $course;
    }
}