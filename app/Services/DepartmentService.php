<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DepartmentService
{
    public function getAllDepartments()
    {
        return Department::select(['id', 'name', 'code', 'description'])->get();
    }

    public function createDepartment(array $data)
    {
        DB::beginTransaction();

        try {
            $department = new Department;

            $department->name = $data['name'];
            $department->code = $data['code'];
            $department->description = $data['description'] ?? null;

            $department->save();

            DB::commit();

            return $department;

        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Department DB error: '.$e->getMessage());

            throw new \Exception('Department code already exists.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Department creation failed: '.$e->getMessage());

            throw new \Exception('Failed to create department.');
        }
    }

    public function updateDepartment($id, $data)
    {
        DB::beginTransaction();

        try {
            $department = Department::findOrFail($id);

            $department->update($data);

            DB::commit();

            return $department;

        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            throw new \Exception('Department not found.');
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Department update DB error: '.$e->getMessage());

            throw new \Exception('Department code already exists.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Department update failed: '.$e->getMessage());

            throw new \Exception('Failed to update department.');
        }
    }

    public function deleteDepartment($id)
    {
        DB::beginTransaction();

        try {
            $department = Department::findOrFail($id);

            $department->delete();

            DB::commit();

        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            throw new \Exception('Department not found.');
        } catch (QueryException $e) {
            DB::rollBack();

            Log::error('Department delete DB error: '.$e->getMessage());

            throw new \Exception('Cannot delete this department because it has assigned courses.');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Department delete failed: '.$e->getMessage());

            throw new \Exception('Failed to delete department.');
        }
    }
}
