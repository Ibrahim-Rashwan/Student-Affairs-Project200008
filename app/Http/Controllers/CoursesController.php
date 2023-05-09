<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

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
            'name' => 'required',
            'code' => 'required'
        ]);

        $course = Course::create($request->all());
        $msg = 'Course created successfully';

        return redirect(DepartmentsController::ROUTE.$course->id)->
            with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'course' => Course::findOrFail($id)
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
            'name' => 'required',
            'code' => 'required'
        ]);

        $course = Course::findOrFail($id);
        $course->fill($request->all());
        $course->save();

        $msg = 'Course updated successfully';

        return redirect(DepartmentsController::ROUTE.$course->id)->
            with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        try {
            $course->delete();
            $msg = 'Course deleted successfully';
        } catch (Throwable $th) {
            $msg = "Couldn't delete course - make sure no one is using it";
        }

        return redirect(DepartmentsController::ROUTE)->
            with('delete', $msg);
    }

}
