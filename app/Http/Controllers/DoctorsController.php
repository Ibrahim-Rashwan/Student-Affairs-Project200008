<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Doctor;
use App\Models\User;
use App\Shared\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorsController extends Controller
{

    private const ROUTE = '/doctors/';


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'doctors' => Doctor::with('user')->get()
        ];

        return view('doctors.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Shared::isAdmin()) {
            return redirect('/doctors');
        }

        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Shared::USER_RULES);

        $user = User::create($request->all(['email', 'name', 'national_number', 'phone', 'age', 'gender']) + [
            'password' => Hash::make($request->password)
        ]);
        $user->email_verified_at = now();
        $user->save();

        $doctor = $user->doctor()->create();

        $msg = 'Doctor created successfully';
        return redirect(DoctorsController::ROUTE . $doctor->id)->
            with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'doctor' => Doctor::with('user')->findOrFail($id)
        ];

        return view('doctors.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = Doctor::findOrFail($id);

        if (!Shared::isAdmin() && !(Shared::isDoctor() && Shared::getActiveUserTypedId() == $doctor->id)) {
            return redirect('/doctors');
        }

        $data = [
            'doctor' => $doctor
        ];

        return view('doctors.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $doctorId)
    {
        $this->validate($request, Shared::USER_RULES);

        $doctor = Doctor::find($doctorId);


=======
        $doctor->user->fill($request->all(['email', 'name', 'national_number', 'phone', 'age', 'gender']));
        $doctor->user->password = Hash::make($request->password);

        $doctor->user->save();

        $msg = 'Doctor updated successfully';
        return redirect(DoctorsController::ROUTE . $doctor->id)->
            with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $doctor->delete();
        $doctor->user->delete();

        $msg = 'Doctor deleted successfully';
        return redirect(DoctorsController::ROUTE)->
            with('delete', $msg);
    }
}
