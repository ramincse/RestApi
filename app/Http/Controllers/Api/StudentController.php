<?php

namespace App\Http\Controllers\Api;

use App\Model\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = DB::table('students')->get();
        return response()->json($student);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'      => 'required',
            'section_id'    => 'required',
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'password'      => 'required',
            'photo'         => 'required',
            'address'       => 'required',
            'gender'        => 'required',
        ]);

        Student::create([
            'class_id'      => $request->class_id,
            'section_id'    => $request->section_id,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'photo'         => $request->photo,
            'address'       => $request->address,
            'gender'        => $request->gender,
        ]);

        return response('Student Data Inserted Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Student::findOrFail($id);
        return response()->json($show);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'class_id'      => 'required',
            'section_id'    => 'required',
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'password'      => 'required',
            'photo'         => 'required',
            'address'       => 'required',
            'gender'        => 'required',
        ]);

        $student->class_id      = $request->class_id;
        $student->section_id    = $request->section_id;
        $student->name          = $request->name;
        $student->phone         = $request->phone;
        $student->email         = $request->email;
        $student->password      = Hash::make($request->password);
        $student->photo         = $request->photo;
        $student->address       = $request->address;
        $student->gender        = $request->gender;
        $student->update();

        return response('Student Data Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $img = DB::table('students')->where('id', $id)->first();
        $image_path = $img->photo;

        unlink($image_path);

        DB::table('students')->where('id', $id)->delete();

        return response('Student Data Deleted Successfully!');
    }
}
