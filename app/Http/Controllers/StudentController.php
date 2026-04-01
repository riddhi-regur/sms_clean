<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Services\ClassroomService;
use App\Services\CourseService;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    protected $studentService;

    protected $courseService;

    protected $classroomService;

    public function __construct(StudentService $studentService, CourseService $courseService, ClassroomService $classroomService)
    {
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->classroomService = $classroomService;
    }

    public function index(Request $request)
    {
        $students = $this->studentService->getAllStudents();

        return view('student.student-list', compact('students'));
    }

    public function create()
    {
        $courses = $this->courseService->getAllCourses();
        $classrooms = $this->classroomService->getAllClassrooms();

        return view('student.form', compact('courses', 'classrooms'));
    }

    public function store(StoreStudentRequest $request)
    {
        $this->studentService->createStudent($request->validated());

        return redirect('/student')->with('success', 'student added successfully!');
    }

    public function data(Request $request)
    {
        $query = $this->studentService->getAllStudents();

        return DataTables::of($query)->addColumn('email', function ($row) {
            return $row->user ? $row->user->email : '-';
        })
            ->addColumn('course', function ($row) {
                return $row->course ? $row->course->name : '-';
            })->addColumn('classroom', function ($row) {
                return $row->classroom ? $row->classroom->name : '-';
            })->addColumn('action', function ($row) {
                return '
       <a href="'.route('student.edit', $row->id).'" 
           class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>

        <form action="'.route('student.destroy', $row->id).'" 
              method="POST" style="display:inline;">
            '.csrf_field().'
            '.method_field('DELETE').'
            <button type="submit" 
                onclick="return confirm(\'Are you sure?\')" 
                class="bg-red-400 px-3 py-1 rounded text-sm">
                Delete
            </button>
        </form>
    ';
            })->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="'.asset('storage/'.$row->image).'" width="40" height="40" style="border-radius:100%;">';
                }

                return '<img src="'.asset('images/user.png').'" width="40">';
            })
            ->rawColumns(['action', 'image'])
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courses = $this->courseService->getAllCourses();
        $classrooms = $this->classroomService->getAllClassrooms();

        return view('student.form', compact('student', 'courses', 'classrooms'));
    }

    public function update(StoreStudentRequest $request, $id)
    {
        $this->studentService->updateStudent($id, $request->all());

        return redirect()
            ->route('student.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->studentService->deleteStudent($id);

            return redirect()
                ->route('student.index')
                ->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('student.index')
                ->with('error', $e->getMessage());
        }
    }
}
