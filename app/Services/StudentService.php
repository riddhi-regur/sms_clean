<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    public function getAllStudents()
    {
        return Student::select(['id', 'name', 'image', 'phone', 'address', 'roll_no', 'user_id',  'classroom_id', 'course_id'])->with('user:id,email')
            ->with('classroom:id,name')->with('course:id,name')->get();
    }

    public function createStudent(array $data)
    {
        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = Role::STUDENT;
        $user->save();

        if (isset($data['image'])) {
            $image = $data['image']->store('admins', 'public');
        }

        $student = new Student;

        $student->name = $data['name'];
        $student->user_id = $user->id;
        $student->phone = $data['phone'] ?? null;
        $student->image = $image ?? null;
        $student->address = $data['address'] ?? null;
        $student->roll_no = $data['roll_no'] ?? null;
        $student->course_id = $data['course_id'];
        $student->classroom_id = $data['classroom_id'];

        $student->save();

        return $student;
    }

    public function updateStudent($id, $data)
    {
        $student = Student::findOrFail($id);
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('admins', 'public');
        }

        $student->update($data);

        if (isset($data['email']) && $student->user) {
            $student->user->update([
                'email' => $data['email'],
            ]);
        }

        return $student;
    }

    public function deleteStudent($id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            if ($student->user) {
                $student->user->delete();
            }

            $student->delete();
        } catch (QueryException $e) {
            // Foreign key restrict error
            throw new \Exception('Cannot delete this student because it has assigned.');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
