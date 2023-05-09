<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Throwable;

class DepartmentsController extends Controller
{

    private const ROUTE = '/departments/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'departments' => Department::all()
        ];

        return view('departments.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
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

        $department = Department::create($request->all());
        $msg = 'Department created successfully';

        return redirect(DepartmentsController::ROUTE.$department->id)->
            with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'department' => Department::findOrFail($id)
        ];

        return view('departments.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'department' => Department::findOrFail($id)
        ];

        return view('departments.edit')->with($data);
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

        $department = Department::findOrFail($id);
        $department->fill($request->all());
        $department->save();

        $msg = 'Department updated successfully';

        return redirect(DepartmentsController::ROUTE.$department->id)->
            with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        try {
            $department->delete();
            $msg = 'Department deleted successfully';
        } catch (Throwable $th) {
            $msg = "Couldn't delete department - make sure no one is using it";
        }

        return redirect(DepartmentsController::ROUTE)->
            with('delete', $msg);
    }

}
