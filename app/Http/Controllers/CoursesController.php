<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Throwable;

class CoursesController extends Controller
{

    private const ROUTE = '/courses/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'courses' => Course::all()
        ];

        return view('courses.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'department_id' => 'required',
            'doctor_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'number_of_hours' => 'required'
        ]);

        $course = Course::create($request->all(['name', 'code', 'number_of_hours', 'department_id', 'doctor_id']) + [
            'materials' => '[]'
        ]);

        if ((int)$request->pre_requisite_id != -1) {
            $course->pre_requisite_id = $request->pre_requisite_id;
        }

        $msg = 'Course created successfully';
        return redirect(CoursesController::ROUTE.$course->id)->
            with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            // 'course' => Course::findOrFail($id)->with('pre_requisite')
            'course' => Course::with(['pre_requisite'])->findOrFail($id)
        ];

        return view('courses.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'course' => Course::findOrFail($id)
        ];

        return view('courses.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'department_id' => 'required',
            'doctor_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'number_of_hours' => 'required'
        ]);

        $course = Course::findOrFail($id);
        $course->fill($request->all());

        if ($request->pre_requisite_id != -1) {
            $course->pre_requisite_id = $request->pre_requisite_id;
        }

        $course->save();

        $msg = 'Course updated successfully';

        return redirect(CoursesController::ROUTE.$course->id)->
            with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $materials = json_decode($course->materials);
        foreach ($materials as $material) {
            $path = $this->getMaterialFolderName($course).$material;
            unlink($path);
        }
        try {
            $course->delete();
            $msg = 'Course deleted successfully';
        } catch (Throwable $th) {
            $msg = "Couldn't delete course - make sure no one is using it";
        }

        return redirect(CoursesController::ROUTE)->
            with('delete', $msg);
    }

    public function t()
    {
        return view('t');
    }

    public function tt()
    {
        return redirect('/courses')->with('success', 'This is a success message');
    }
}
