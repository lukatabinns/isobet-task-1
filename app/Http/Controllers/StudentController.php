<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): View|Application
    {
        return view("index");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->dataValidate($request);
        $student = Student::create(request()->all());
        return response()->json(['success' => "student created", 'student' => $student], 201);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->dataValidate($request);
        $student =  Student::where('id', $id)->update(request()->all());
        return response()->json(['success' => "student updated", 'student' => $student], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getStudents() : JsonResponse
    {
        $student = Student::orderByDesc("id")->get();
        return response()->json(['success' => 'received data', 'students' => $student], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getStudent($id) : JsonResponse
    {
        $student = Student::where('id',$id)->first();;
        return response()->json(['success' => 'received data', 'student' => $student], 200);
    }

    public function dataValidate($request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'identification_no' => 'required',
            'country' => 'required',
            'date_of_birth' => 'required',
            'registered_on' => 'required',
        ]);
    }
}
