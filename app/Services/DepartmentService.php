<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\QueryException;

class DepartmentService
{
    public function getAllDepartments()
    {
        return Department::select(['id', 'name', 'code', 'description'])->get();
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
       try {
            $department = Department::findOrFail($id);
            $department->delete();
        } catch (QueryException $e) {
            // Foreign key restrict error
            throw new \Exception("Cannot delete this department because it has assigned courses.");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
