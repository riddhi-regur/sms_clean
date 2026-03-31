<?php

namespace App\Services;

use App\Models\Classroom;

class ClassroomService
{
    public function getAllClassrooms()
    {
        $classroom = Classroom::with('department','course')->get();
         return $classroom;
    }
}