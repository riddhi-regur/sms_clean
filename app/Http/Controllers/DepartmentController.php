<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $department = $this->departmentService->getAllDepartments();

        return view('department.index', compact('department'));
    }

    public function create()
    {
        return view('department.form');
    }

    public function data(Request $request)
    {
        $query = $this->departmentService->getAllDepartments();

        return DataTables::of($query)->addColumn('action', function ($row) {
            return '
        <a href="'.route('department.edit', $row->id).'" 
           class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</a>

        <form action="'.route('department.destroy', $row->id).'" 
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

    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->createDepartment($request->validated());

        return redirect('/department')->with('success', 'department added successfully!');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('department.form', compact('department'));
    }

    public function update(StoreDepartmentRequest $request, $id)
    {
        $this->departmentService->updateDepartment($id, $request->all());

        return redirect()
            ->route('department.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->departmentService->deleteDepartment($id);

            return redirect()
                ->route('department.index')
                ->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('department.index')
                ->with('error', $e->getMessage());
        }
    }
}
