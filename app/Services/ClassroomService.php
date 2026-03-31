<?php

namespace App\Services;

use App\Models\Classroom;
use Illuminate\Database\QueryException;

class ClassroomService
{
    public function getAllClassrooms()
    {
        $classroom = Classroom::select(['id', 'name', 'section', 'department_id', 'year', 'course_id'])->with('department:id,name', 'course:id,name')
            ->get();

        return $classroom;
    }
     public function createClassroom(array $data)
    {
        $classroom = new Classroom;

        $classroom->name = $data['name'];
        $classroom->section = $data['section'];
        $classroom->year = $data['year'];
          $classroom->course_id = $data['course_id'];
           $classroom->department_id = $data['department_id'];

        $classroom->save();

        return $classroom;
    }
     public function updateClassroom($id, $data)
    {
        $classroom = Classroom::findOrFail($id);

        $classroom->update($data);

        return $classroom;
    }
     public function deleteClassroom($id)
    {
        try{ $classroom = Classroom::findOrFail($id);

        $classroom->delete();}catch(QueryException $e){
            // Foreign key restrict error
            throw new \Exception("Cannot delete this classroom because it has assigned.");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
