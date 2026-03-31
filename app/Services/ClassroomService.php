<?php

namespace App\Services;

use App\Models\Classroom;

class ClassroomService
{
    public function getAllClassrooms()
    {
        $classroom = Classroom::select(['id','name', 'section', 'department_id' ,'year','course_id'])  ->with('department:id,name','course:id,name')
    ->get();
         return $classroom;
    }
}