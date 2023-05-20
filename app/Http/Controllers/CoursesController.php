<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Subscription;
use App\Shared\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CoursesController extends Controller
{

    private const ROUTE = '/courses/';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'courses' => $this->getAvaiableCourses()
        ];

        return view('courses.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Shared::isAdmin()) {
            return redirect('/courses');
        }

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
        $course = Course::with(['pre_requisite'])->findOrFail($id);
        $availableCourses = $this->getAvaiableCourses();

        $found = false;
        foreach ($availableCourses as $availableCourse) {
            if ($availableCourse->id == $course->id) {
                $found = true;
            }
        }

        if (!$found) {
            return redirect('/courses');
        }

        $data = [
            // 'course' => Course::findOrFail($id)->with('pre_requisite')
            'course' => $course
        ];

        return view('courses.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Shared::isAdmin()) {
            return redirect('/courses');
        }

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
        } else {
            $course->pre_requisite_id = null;
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

    public function subscribe(string $id)
    {
        $course = Course::find($id);

        $user = Auth::user();
        $student = $user->student;

        $student->courses()->attach($course);
        // $subscribtion = Subscription::create([
        //     'student_id' => $student->id,
        //     'course_id' => $course->id
        // ]);

        $msg = 'Subscribed to course successfully';
        return redirect(CoursesController::ROUTE)->
            with('success', $msg);
    }

    private function getAvaiableCourses() {
        $courses = Course::with(['pre_requisite'])->get();
        $availableCourses = [];

        if (Shared::isAdmin()) {
            $availableCourses = $courses;
        } else if (Shared::isDoctor()) {
            $availableCourses = Auth::user()->doctor->courses;
            // foreach (Auth::user()->doctor->courses as $course) {
            //     foreach ($course->courses as $courseStudent) {
            //         array_push($avaiableCourses, $courseStudent);
            //     }
            // }
        } else if (Shared::isStudent()) {
            $loggedInStudent = Auth::user()->student;

            $availableCourses = [];
            foreach ($loggedInStudent->courses as $course) {
                array_push($availableCourses, $course);
            }

            $courses = Course::all();

            foreach ($courses as $course) {
                if (!$course->getSubscriptionState() && $course->canSubscribe()) {
                    array_push($availableCourses, $course);
                }

                // if ($student->department_id == $loggedInStudent->department_id) {
                //     array_push($avaiableCourses, $student);
                // } else {
                //     $pushed = false;

                //     foreach ($student->courses as $course) {
                //         foreach ($loggedInStudent->courses as $loggedInStudentCourse) {
                //             if ($course->id == $loggedInStudentCourse->id) {
                //                 array_push($avaiableCourses, $student);
                //                 $pushed = true;
                //                 break;
                //             }
                //         }

                //         if ($pushed) {
                //             break;
                //         }
                //     }
                // }
            }
        }

        return $availableCourses;
    }

}
