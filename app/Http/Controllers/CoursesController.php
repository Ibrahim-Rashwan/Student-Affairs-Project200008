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
        return redirect(CoursesController::ROUTE.$id)->
            with('success', $msg);
    }

    public function generate_student_names($id)
    {

        $data = ['id,name,phone,national id'];
        $course = Course::find($id);
        foreach ($course->students as $student) {
            $line = "{$student->id},{$student->user->name},{$student->user->phone},{$student->user->national_number}";
            array_push($data, $line);
        }

        if (!file_exists('tmp')) {
            mkdir('tmp', 0777, true);
        }

        $file = "tmp/Student Names.csv";
        $fp = fopen($file, "w") or die("Unable to open file!");
        foreach ($data as $line) {
            $val = explode(",", $line);
            fputcsv($fp, $val);
        }
        fclose($fp);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        header("Content-Type: text/csv");
        readfile($file);

        $this->output_file($file, 'Student Names.csv');

        $msg = 'Generated Student Names successfully';
        return redirect(CoursesController::ROUTE.$id)->
            with('success', $msg);
    }

    private function output_file($file, $name, $mime_type='')
    {
        if(!is_readable($file)) die('File not found or inaccessible!');

        $size = filesize($file);
        $name = rawurldecode($name);
        $known_mime_types=array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "jpg" => "image/jpg",
            "php" => "text/plain",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html"=> "text/html",
            "png" => "image/png",
            "jpeg"=> "image/jpg"
        );

        if($mime_type==''){
            $file_extension = strtolower(substr(strrchr($file,"."),1));
            if(array_key_exists($file_extension, $known_mime_types)){
                $mime_type=$known_mime_types[$file_extension];
            } else {
                $mime_type="application/force-download";
            };
        };
        @ob_end_clean();
        if(ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        if(isset($_SERVER['HTTP_RANGE']))
        {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
            list($range) = explode(",",$range,2);
            list($range, $range_end) = explode("-", $range);
            $range=intval($range);
            if(!$range_end) {
                $range_end=$size-1;
            } else {
                $range_end=intval($range_end);
            }

            $new_length = $range_end-$range+1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length=$size;
            header("Content-Length: ".$size);
        }

        $chunksize = 1*(1024*1024);
        $bytes_send = 0;
        if ($file = fopen($file, 'r'))
        {
            if(isset($_SERVER['HTTP_RANGE']))
            fseek($file, $range);

            while(!feof($file) &&
                (!connection_aborted()) &&
                ($bytes_send<$new_length)
            )
            {
                $buffer = fread($file, $chunksize);
                echo($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
        } else
            die('Error - can not open file.');
        die();
    }

    private function getAvaiableCourses() {
        $courses = Course::with(['pre_requisite'])->get();
        $availableCourses = [];

        if (Shared::isAdmin()) {
            foreach ($courses as $course) {
                array_push($availableCourses, $course);
            }
            // $availableCourses = $courses;
        } else if (Shared::isDoctor()) {
            foreach (Auth::user()->doctor->courses as $course) {
                array_push($availableCourses, $course);
            }
            // $availableCourses = Auth::user()->doctor->courses;
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
            }
        }

        return $availableCourses;
    }

}
