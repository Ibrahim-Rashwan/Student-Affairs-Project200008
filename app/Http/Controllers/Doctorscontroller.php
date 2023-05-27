<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class Doctorscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course=Course::all();
        return view('Doctors.doctorpage')->with('course',$course);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('pdf')->store('pdfs');

        $pdf = new Pdf();
        $pdf->info = json_encode([
            'filename' => $request->file('pdf')->getClientOriginalName(),
            'path' => $path
        ]);
        $pdf->save();

        return 'File uploaded successfully.';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course=Course::findOrfail($id);
        return view('Doctors.coursematrial')->with('course',$course);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
