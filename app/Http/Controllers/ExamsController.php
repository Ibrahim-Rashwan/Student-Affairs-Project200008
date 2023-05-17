<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExamsController extends Controller
{

    private const ROUTE = '/courses/';

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $courseId)
    {
        $data = [
            'course' => Course::findOrFail($courseId)
        ];

        return view('courses.exams.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $courseId)
    {
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $course = Course::findOrFail($courseId);

        $file = $request->file('file');
        $uploadName = time() . '_' . $file->getClientOriginalName();
        $file->move(ExamsController::getExamDirectory($course), $uploadName);

        $exam = Exam::create($request->all() + [
            'course_id' => $course->id,
            'name' => $uploadName
        ]);

        $exam->can_display_score = isset($request->can_display_score) ? true : false;
        $exam->save();

        $msg = 'Exam created successfully';

        return redirect(ExamsController::ROUTE . $course->id)->
            with('success', $msg);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $courseId, string $examId)
    {
        $data = [
            'course' => Course::findOrFail($courseId),
            'exam' => Exam::findOrFail($examId)
        ];

        return view('courses.exams.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, string $examId)
    {
        $this->validate($request, [
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $course = Course::findOrFail($courseId);
        $exam = Exam::findOrFail($examId);

        $oldPath = ExamsController::getExamPath($course, $exam->name);

        $index = strpos($exam->name, '_');
        $prefix = substr($exam->name, 0, $index+1);
        $extension = pathinfo($exam->name, PATHINFO_EXTENSION);
        $newName = $prefix . $request->name . '.' . $extension;
        $newPath = ExamsController::getExamPath($course, $newName);

        $result = File::move($oldPath, $newPath);

        if ($result) {
            $exam->fill($request->all());
            $exam->name = $newName;
            $exam->can_display_score = isset($request->can_display_score) ? true : false;
            $exam->save();
        }

        $msg = $result ? 'Exam updated successfully' : 'Exam update failed';
        $code = $result ? 'success' : 'error';
        return redirect(ExamsController::ROUTE . $course->id)->
            with($code, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $courseId, string $examId)
    {
        $course = Course::findOrFail($courseId);
        $exam = Exam::findOrFail($examId);

        $path = ExamsController::getExamPath($course, $exam->name);
        unlink($path);

        $exam->delete();
        $msg = 'Exam deleted successfully';

        return redirect(ExamsController::ROUTE . $course->id)->
            with('delete', $msg);
    }

    public static function getDisplayName(string $material)
    {
        $index = strpos($material, '_');
        return substr($material, $index+1);
    }

    public static function getExamPath($course, $exam)
    {
        return ExamsController::getExamDirectory($course) . $exam;
    }

    private static function getExamDirectory($course)
    {
        return 'exams/' . $course->name . ' (' . $course->code . ')/';
    }

}
