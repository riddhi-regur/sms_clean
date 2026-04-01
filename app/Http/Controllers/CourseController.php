<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    protected $courseService;

    protected $departmentService;

    public function __construct(CourseService $courseService, DepartmentService $departmentService)
    {
        $this->courseService = $courseService;
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $course = $this->courseService->getAllCourses();

        return view('course.index', compact('course'));
    }

    public function create()
    {
        $departments = $this->departmentService->getAllDepartments();

        return view('course.form', compact('departments'));
    }

    public function data(Request $request)
    {
        $query = $this->courseService->getAllCourses();

        return DataTables::of($query)
            ->addColumn('department', function ($row) {
                return $row->department ? $row->department->name : '-';
            })->addColumn('action', function ($row) {
                return '
       <a href="'.route('course.edit', $row->id).'" 
           class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>

        <form action="'.route('course.destroy', $row->id).'" 
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

    public function store(StoreCourseRequest $request)
    {
        $this->courseService->createCourse($request->validated());

        return redirect('/course')->with('success', 'course added successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $departments = $this->departmentService->getAllDepartments();

        return view('course.form', compact('course', 'departments'));
    }

    public function update(StoreCourseRequest $request, $id)
    {
        $this->courseService->updateCourse($id, $request->all());

        return redirect()
            ->route('course.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->courseService->deleteCourse($id);

            return redirect()
                ->route('course.index')
                ->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('course.index')
                ->with('error', $e->getMessage());
        }
    }
}
