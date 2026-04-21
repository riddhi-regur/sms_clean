<?php

namespace App\Services;

use App\Models\Classroom;
use Exception;
use Illuminate\Database\QueryException;

class ClassroomService
{
    public function getAllClassrooms()
    {
        $classroom = Classroom::select(['id', 'name', 'section', 'department_id', 'year', 'course_id'])->with('department:id,name', 'course:id,name')
            ->with('department:id,name', 'course:id,name')
            ->get();

        return $classroom;
    }

    public function createClassroom(array $data)
    {
        try {
            $classroom = new Classroom;

            $classroom->name = $data['name'];
            $classroom->section = $data['section'];
            $classroom->year = $data['year'];
            $classroom->course_id = $data['course_id'];
            $classroom->department_id = $data['department_id'];

            $classroom->save();

            return $classroom;

        } catch (QueryException $e) {

            $errorCode = $e->errorInfo[0] ?? null;

            // Duplicate classroom (example: unique constraint on name+section+year)
            if ($errorCode === '23505' || $errorCode === '23000') {
                throw new Exception('Classroom already exists for this section and year.');
            }

            // Foreign key: invalid course_id or department_id
            if ($errorCode === '23503') {
                throw new Exception('Invalid course or department selected.');
            }

            // Generic DB error
            throw new Exception('Failed to create classroom due to database error.');
        } catch (Exception $e) {
            throw new Exception('Something went wrong while creating classroom.');
        }
    }

    public function updateClassroom($id, $data)
    {
        $classroom = Classroom::findOrFail($id);

        $classroom->update($data);

        return $classroom;
    }

    public function deleteClassroom($id)
    {
        try {
            $classroom = Classroom::findOrFail($id);

            $classroom->delete();
        } catch (QueryException $e) {
            // Foreign key restrict error
            throw new Exception('Cannot delete this classroom because it has assigned.');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
