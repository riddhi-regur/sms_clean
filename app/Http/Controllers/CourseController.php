<?php

namespace App\Http\Controllers;

use App\Services\CourseService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        $course = $this->courseService->getAllCourses();

        return view('course.index', compact('course'));
    }

    public function data(Request $request)
    {
        $query = $this->courseService->getAllCourses();

        return DataTables::of($query)
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
