<?php

namespace App\Http\Controllers;

use App\Services\ClassroomService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassroomController extends Controller
{
    protected $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }
    public function index(Request $request)
    {
         $classroom = $this->classroomService->getAllClassrooms();

        return view('classroom.index', compact('classroom'));
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
        <button  class="bg-yellow-400 px-3 py-1 rounded text-sm">Edit</button>
        <button  class="bg-red-400 px-3 py-1 rounded text-sm">Delete</button>
    ';
})
->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
