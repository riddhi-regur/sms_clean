<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassroomRequest;
use App\Models\Classroom;
use App\Services\ClassroomService;
use App\Services\CourseService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{
    protected $classroomService;

    protected $courseService;

    protected $departmentService;

    public function __construct(ClassroomService $classroomService, CourseService $courseService, DepartmentService $departmentService)
    {
        $this->classroomService = $classroomService;
        $this->courseService = $courseService;
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $classroom = $this->classroomService->getAllClassrooms();

        return view('classroom.classroom-list', compact('classroom'));
    }

    public function create()
    {
        $courses = $this->courseService->getAllCourses();
        $departments = $this->departmentService->getAllDepartments();

        return view('classroom.form', compact('departments', 'courses'));
    }

    public function data(Request $request)
    {
        $query = $this->classroomService->getAllClassrooms();

        return DataTables::of($query)
            ->addColumn('course', function ($row) {
                return $row->course ? $row->course->name : '-';
            })
            ->addColumn('department', function ($row) {
                return $row->department ? $row->department->name : '-';
            })->addColumn('action', function ($row) {
                return '
        <a href="'.route('classroom.edit', $row->id).'" 
           class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>

        <form action="'.route('classroom.destroy', $row->id).'" 
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
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function store(StoreClassroomRequest $request)
    {
        $this->classroomService->createClassroom($request->validated());

        return redirect('/classroom')->with('success', 'classroom added successfully!');
    }

    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $departments = $this->departmentService->getAllDepartments();
        $courses = $this->courseService->getAllCourses();

        return view('classroom.form', compact('classroom', 'courses', 'departments'));
    }

    public function update(StoreClassroomRequest $request, $id)
    {
        $this->classroomService->updateClassroom($id, $request->all());

        return redirect()
            ->route('classroom.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->classroomService->deleteClassroom($id);

            return redirect()
                ->route('classroom.index')
                ->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('classroom.index')
                ->with('error', $e->getMessage());
        }
    }
}
