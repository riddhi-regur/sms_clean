<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function getAllDepartments()
    {
        $department = Department::get();
         return $department;
    }
}