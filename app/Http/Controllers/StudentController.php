<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentsResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return new StudentsResource($students, 'success', 'list of students');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new StudentsResource(null, 'failed', $validator->errors());
        };

        $student = Student::create($request->all());
        return new StudentsResource($student, 'success', 'student create successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if ($student) {
            return new StudentsResource($student, 'success', 'student found');
        } else {
            return new StudentsResource(null, 'failed', 'student not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return new StudentsResource(null, 'failed', $validator->errors());
        };

        $student = Student::find($id);
        if (!$student)
        {
            return new StudentsResource(null, 'failed', 'Student not found');
        }
        $student->update($request->all());
        return new StudentsResource($student, 'success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $student = Student::find($id);

        if (!$student)
        {
            return new StudentsResource(null, 'failed', 'Student not found');
        }
        $student->delete();

        return new StudentsResource(null, 'success', 'Student deleted successfully');
    }
}
