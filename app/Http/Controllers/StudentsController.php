<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Shared\Shared;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{

    private const ROUTE = '/students/';


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Student::all();
        $availableStudents = $this->getAvaiableStudents($students);

        $page = $request->input('page', 1);
        $perPage = 10;
        $slice = array_slice($availableStudents, ($page-1) * $perPage, $perPage);
        // var_dump($page);

        $paginator = new LengthAwarePaginator($slice, count($availableStudents), $perPage, $page, [
            'path'  => $request->path(),
            'query' => $request->query()
        ]);

        $data = [
            'students' => $paginator,
            'links' => $paginator->links()
        ];

        return view('students.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Shared::isAdmin()) {
            return redirect('/students');
        }

        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, Shared::USER_RULES + [
            'department_id' => 'required',
            'level' => 'required'
        ]);

        $user = User::create($request->all(['email', 'name', 'national_number', 'phone', 'age', 'gender']) + [
            'password' => Hash::make($request->password)
        ]);
        $user->email_verified_at = now();
        $user->save();

        $student = $user->student()->create($request->all());

        $msg = 'Student created successfully';
        return redirect(StudentsController::ROUTE . $student->id)->
            with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $avaiableStudents = $this->getAvaiableStudents(Student::all());

        $found = false;
        foreach ($avaiableStudents as $avaiableStudent) {
            if ($avaiableStudent->id == $student->id) {
                $found = true;
            }
        }

        if (!$found) {
            return redirect('/students');
        }

        $data = [
            'student' => $student
        ];

        return view('students.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);

        if (!Shared::isAdmin() && !(Shared::isStudent() && Shared::getActiveUserTypedId() == $student->id)) {
            return redirect('/students');
        }

        $data = [
            'student' => $student
        ];

        return view('students.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $studentId)
    {
        $this->validate($request, Shared::USER_RULES + [
            'department_id' => 'required',
            'level' => 'required'
        ]);

        $student = Student::find($studentId);
        $student->user->fill($request->all(['email', 'name', 'national_number', 'phone', 'age', 'gender']));
        $student->user->password = Hash::make($request->password);
        $student->fill($request->all());
        $student->user->save();
        $student->save();

        $msg = 'Student updated successfully';
        return redirect(StudentsController::ROUTE . $student->id)->
            with('success', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $studentId)
    {
        $student = Student::find($studentId);
        $student->delete();
        $student->user->delete();

        $msg = 'Student deleted successfully';
        return redirect(StudentsController::ROUTE)->
            with('delete', $msg);
    }

    private function getAvaiableStudents($students) {

        // $students = Student::with('user')->get();
        // $students = Student::paginate(20);
        $avaiableStudents = [];

        if (Shared::isAdmin()) {
            foreach ($students as $student) {
                array_push($avaiableStudents, $student);
            }
        } else if (Shared::isDoctor()) {
            foreach (Auth::user()->doctor->courses as $course) {
                foreach ($course->students as $courseStudent) {
                    array_push($avaiableStudents, $courseStudent);
                }
            }
        } else if (Shared::isStudent()) {
            $loggedInStudent = Auth::user()->student;
            foreach ($students as $student) {
                if ($student->department_id == $loggedInStudent->department_id) {
                    array_push($avaiableStudents, $student);
                } else {
                    $pushed = false;

                    foreach ($student->courses as $course) {
                        foreach ($loggedInStudent->courses as $loggedInStudentCourse) {
                            if ($course->id == $loggedInStudentCourse->id) {
                                array_push($avaiableStudents, $student);
                                $pushed = true;
                                break;
                            }
                        }

                        if ($pushed) {
                            break;
                        }
                    }
                }
            }
        }

        return $avaiableStudents;
    }

}
