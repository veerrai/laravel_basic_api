<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
        ]);

        // Insert using validated data
        $student = Student::create($validated);

        return response()->json([
            'status' => 'success',
            'data'   => $student,
        ], 201);
    }

      public function index()
    {
        $students = Student::all();  // DB से सभी students ले आएं

        return response()->json([
            'status' => 'success',
            'data' => $students,
        ]);
    }

    public function show($id)
{
    $student = Student::find($id);

    if (!$student) {
        return response()->json([
            'status' => 'error',
            'message' => 'Student not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'data' => $student,
    ]);
}

public function update(Request $request, $id)
{
    // Find the student by id
    $student = Student::find($id);

    if (!$student) {
        return response()->json([
            'status' => 'error',
            'message' => 'Student not found'
        ], 404);
    }

    // Validate request
    $request->validate([
        'name'  => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:students,email,'.$id,
    ]);

    // Update student data
    $student->update($request->only(['name', 'email']));

    return response()->json([
        'status' => 'success',
        'data' => $student,
    ]);
}

public function destroy($id)
{
    $student = Student::find($id);

    if (!$student) {
        return response()->json([
            'status' => 'error',
            'message' => 'Student not found'
        ], 404);
    }

    $student->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Student deleted successfully'
    ]);
}



}
