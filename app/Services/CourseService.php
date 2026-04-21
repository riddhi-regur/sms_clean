<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $course = new Course;

            $course->name = $data['name'];
            $course->code = $data['code'];
            $course->description = $data['description'] ?? null;
            $course->fees = $data['fees'] ?? null;
            $course->duration = $data['duration'];
            $course->department_id = $data['department_id'];

            $course->save();

            return $course;

        } catch (QueryException $e) {

            // PostgreSQL / MySQL duplicate entry error codes
            $errorCode = $e->errorInfo[0] ?? null;

            if ($errorCode === '23505' || $errorCode === '23000') {
                throw new Exception('Course code already exists.');
            }

            // Foreign key constraint (invalid department_id)
            if ($errorCode === '23503') {
                throw new Exception('Invalid department selected.');
            }

            throw new Exception('Failed to create course due to database error.');
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception('Something went wrong while creating course.');
        }
    }

    public function updateCourse($id, $data)
    {
        try {
            $course = Course::findOrFail($id);

            $course->update($data);

            return $course;

        } catch (ModelNotFoundException $e) {
            throw new Exception('Course not found.');
        } catch (QueryException $e) {

            $errorCode = $e->errorInfo[0] ?? null;

            // Duplicate course code
            if ($errorCode === '23505' || $errorCode === '23000') {
                throw new Exception('Course code already exists.');
            }

            // Invalid foreign key (e.g., department_id)
            if ($errorCode === '23503') {
                throw new Exception('Invalid department selected.');
            }

            throw new Exception('Failed to update course due to database error.');
        } catch (Exception $e) {
            throw new Exception('Something went wrong while updating course.');
        }
    }

    public function deleteCourse($id)
    {
        try {
            $course = Course::findOrFail($id);

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
