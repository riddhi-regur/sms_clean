<?php

namespace App\Services;

use App\Models\Department;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class DepartmentService
{
    protected Department $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function getAllDepartments()
    {
        return $this->department->select(['id', 'name', 'code', 'description'])->get();
    }

    public function createDepartment(array $data): Department
    {
        try {

            $department = $this->department->newInstance();

            $department->name = $data['name'];
            $department->code = $data['code'];
            $department->description = $data['description'] ?? null;

            $department->save();

            return $department;
        } catch (QueryException $e) {
            Log::error("Department DB error: {$e->getMessage()}");
            throw new Exception('Department code already exists.');
        } catch (Throwable $e) {
            Log::error("Department creation failed: {$e->getMessage()}");
            throw new Exception('Failed to create department.');
        }
    }

    public function updateDepartment(int $id, array $data): Department
    {
        try {
            $department = $this->department->findOrFail($id);

            $department->name = $data['name'] ?? $department->name;
            $department->code = $data['code'] ?? $department->code;
            $department->description = $data['description'] ?? $department->description;

            $department->save();

            return $department;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Department not found.');
        } catch (QueryException $e) {
            Log::error("Department update DB error: {$e->getMessage()}");
            throw new Exception('Department code already exists.');
        } catch (Throwable $e) {
            Log::error("Department update failed: {$e->getMessage()}");
            throw new Exception('Failed to update department.');
        }
    }

    public function deleteDepartment(int $id): bool
    {
        try {
            return $this->department->findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Department not found.');
        } catch (QueryException $e) {
            Log::error("Department delete DB error: {$e->getMessage()}");
            throw new Exception('Cannot delete this department because it has assigned records.');
        } catch (Throwable $e) {
            Log::error("Department delete failed: {$e->getMessage()}");
            throw new Exception('Failed to delete department.');
        }
    }
}
