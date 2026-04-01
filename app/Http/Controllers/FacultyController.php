<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacultyRequest;
use App\Models\Faculty;
use App\Services\DepartmentService;
use App\Services\FacultyService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FacultyController extends Controller
{
    protected $facultyService;

    protected $departmentService;

    public function __construct(FacultyService $facultyService, DepartmentService $departmentService)
    {
        $this->facultyService = $facultyService;
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $faculty = $this->facultyService->getAllFaculty();

        return view('faculty.faculty-list', compact('faculty'));
    }

    public function data(Request $request)
    {
        $query = $this->facultyService->getAllFaculty();

        return DataTables::of($query)->addColumn('email', function ($row) {
            return $row->user ? $row->user->email : '-';
        })
            ->addColumn('department', function ($row) {
                return $row->department ? $row->department->name : '-';
            })->addColumn('action', function ($row) {
                return '
       <a href="'.route('faculty.edit', $row->id).'" 
           class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>

        <form action="'.route('faculty.destroy', $row->id).'" 
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

    public function create()
    {
        $departments = $this->departmentService->getAllDepartments();

        return view('faculty.form', compact('departments'));
    }

    public function store(StoreFacultyRequest $request)
    {
        $this->facultyService->createFaculty($request->validated());

        return redirect('/faculty')->with('success', 'faculty added successfully!');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);
        $departments = $this->departmentService->getAllDepartments();

        return view('faculty.form', compact('faculty', 'departments'));
    }

    public function update(StoreFacultyRequest $request, $id)
    {
        $this->facultyService->updateFaculty($id, $request->all());

        return redirect()
            ->route('faculty.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->facultyService->deleteFaculty($id);

            return redirect()
                ->route('faculty.index')
                ->with('success', 'Deleted successfully');
        } catch (\Exception $e) {
            return redirect()
                ->route('faculty.index')
                ->with('error', $e->getMessage());
        }
    }
}
