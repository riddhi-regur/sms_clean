<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\QueryException;

class CourseService
{
    public function getAllCourses()
    {
        $course = Course::select(['id', 'name', 'code', 'department_id', 'fees', 'duration', 'description'])
            ->with('department:id,name')
            ->get();

        return $course;
    }
     public function createCourse(array $data)
    {
        $course = new Course;

        $course->name = $data['name'];
        $course->code = $data['code'];
        $course->description = $data['description'];
         $course->fees = $data['fees'] ?? null;
          $course->duration = $data['duration'];
           $course->department_id = $data['department_id'];

        $course->save();

        return $course;
    }
     public function updateCourse($id, $data)
    {
        $course = Course::findOrFail($id);

        $course->update($data);

        return $course;
    }

    public function deleteCourse($id)
    {
        try{ $course = Course::findOrFail($id);

        $course->delete();}catch(QueryException $e){
            // Foreign key restrict error
            throw new \Exception("Cannot delete this course because it has assigned.");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
