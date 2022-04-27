<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Nette\Utils\Validators;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'email' => 'required|max:191',
                'phone' => 'required|max:191',
                'course' => 'required|max:191',
                'photo' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'erros' => $validator->messages()
            ]);
        } else {

            $student = new Student;
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            if ($request->hasfile('photo')) {
                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();
                $filephoto = time() . '.' . $ext;
                $file->move('upload', $filephoto);
                $student->photo = $filephoto;
            }
            $student->save();
            return response()->json([
                'status' => 200,
                'message' => 'Student Added Successfully'
            ]);
        }
    }
    public function show()
    {
        $student = Student::all();
        $student->photo= asset('admin/images/$student->photo');
        return response()->json(['students' => $student], 200);
    }
    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ]);
    }
    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,

            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student Id is not found'
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:191',
                'email' => 'required|max:191',
                'phone' => 'required|max:191',
                'course' => 'required|max:191',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'erros' => $validator->messages(),
            ]);
        } else {

            $student = Student::find($id);
            if ($student) {
                $student->name = $request->input('name');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->course = $request->input('course');
                $student->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student Id is not found'
                ]);
            }
        }
    }
}
