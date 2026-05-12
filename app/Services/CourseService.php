<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CourseService
{
    protected Course $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function getAllCourses()
    {
        return $this->course->select(['id', 'name', 'code', 'department_id', 'fees', 'duration', 'description'])
            ->with('department:id,name')
            ->get();
    }

    public function createCourse(array $data)
    {
        try {
            $course = $this->course->newInstance();

            $course->name = $data['name'];
            $course->code = $data['code'];
            $course->description = $data['description'] ?? null;
            $course->fees = $data['fees'] ?? null;
            $course->duration = $data['duration'];
            $course->department_id = $data['department_id'];

            $course->save();

            return $course;
        } catch (QueryException $e) {

            throw new Exception('Course code already exists.');
        } catch (Exception $e) {
            throw new Exception('Something went wrong while creating course.');
        }
    }

    public function updateCourse($id, $data)
    {
        try {
            $course = $this->course->findOrFail($id);

            $course->update($data);

            return $course;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Course not found.');
        } catch (QueryException $e) {
            throw new Exception('Course code already exists.');
        } catch (Exception $e) {
            throw new Exception('Something went wrong while updating course.');
        }
    }

    public function deleteCourse($id)
    {
        try {
            $course = $this->course->findOrFail($id);

            $course->delete();
        } catch (ModelNotFoundException $e) {
            throw new Exception('Course not found.');
        } catch (QueryException $e) {

            $errorCode = $e->errorInfo[0] ?? null;

            // Foreign key constraint (course is being used somewhere)
            if ($errorCode === '23503' || $errorCode === '23000') {
                throw new Exception('Cannot delete this course because it has assigned records.');
            }

            throw new Exception('Failed to delete course due to database error.');
        } catch (Exception $e) {
            throw new Exception('Something went wrong while deleting course.');
        }
    }
}
