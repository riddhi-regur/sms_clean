<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function getAllDepartments()
    {
        return Department::select(['id', 'name', 'code', 'description']);
    }

    public function createDepartment(array $data)
    {
        $department = new Department;

        $department->name = $data['name'];
        $department->code = $data['code'];
        $department->description = $data['description'] ?? null;

        $department->save();

        return $department;
    }

    public function updateDepartment($id, $data)
    {
        $department = Department::findOrFail($id);

        $department->update($data);

        return $department;
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();

        return true;
    }
}
