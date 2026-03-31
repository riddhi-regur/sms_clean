<?php

namespace App\Http\Controllers;

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
     public function data(Request $request)
    {
        $query = $this->departmentService->getAllDepartments();

        return DataTables::of($query)
       ->addColumn('action', function ($row) {
    return '
        <button  class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</button>
        <button  class="bg-red-400 px-3 py-1 rounded text-sm">Delete</button>
    ';
})
->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
