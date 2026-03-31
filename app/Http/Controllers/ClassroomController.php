<?php

namespace App\Http\Controllers;

use App\Services\ClassroomService;
use Illuminate\Http\Request;

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
}
