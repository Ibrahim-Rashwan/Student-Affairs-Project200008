<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Shared\Shared;
use File;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $course = Course::findOrFail($id);
        return view('courses.materials.create')->with('course', $course);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $courseId)
    {
        $file = $request->file('file');

        $course = Course::findOrFail($courseId);

        $name = $file->getClientOriginalName();
        $uploadName = time() . '_' . $name;
        $file->move($this->getMaterialDirectory($course), $uploadName);

        $materials = json_decode($course->materials);
        array_push($materials, $uploadName);
        $course->materials = json_encode($materials);

        $course->save();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $courseId, string $materialId)
    {
        $course = Course::findOrFail($courseId);

        $materials = json_decode($course->materials);

        $path = MaterialsController::getDisplayName($materials[$materialId]);
        $data = [
            'course' => $course,
            'materialName' => Shared::getBaseName($path),
            'materialId' => $materialId,
        ];

        return view('courses.materials.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $courseId, string $materialId)
    {
        $this->validate($request, ['name' => 'required']);

        $course = Course::findOrFail($courseId);

        $materials = json_decode($course->materials);
        $material = $materials[$materialId];
        $materials[$materialId] = Shared::replaceBaseName($material, $request->name);

        $oldPath = MaterialsController::getMaterialPath($course, $material);
        $newPath = MaterialsController::getMaterialPath($course, $materials[$materialId]);
        $result = File::move($oldPath, $newPath);

        if ($result) {
            $course->materials = json_encode($materials);
            $course->save();
        }

        $msg = $result ? 'Material updated successfully' : 'Material update failed';
        $code = $result ? 'success' : 'error';
        return redirect('/courses/'.$course->id)->with($code, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $courseId, string $materialId)
    {
        $course = Course::findOrFail($courseId);
        $materials = json_decode($course->materials);

        $material = $materials[$materialId];
        $path = MaterialsController::getMaterialPath($course, $material);
        unlink($path);
        array_splice($materials, (int)$materialId, 1);
        $course->materials = json_encode($materials);

        $course->save();
        $msg = 'Material deleted successfully';

        return redirect(route('courses.show', [$courseId]))->
            with('delete', $msg);
    }

    public static function getDisplayName(string $material)
    {
        $index = strpos($material, '_');
        return substr($material, $index+1);
    }

    public static function getMaterialPath($course, $material)
    {
        return MaterialsController::getMaterialDirectory($course) . $material;
    }

    private static function getMaterialDirectory($course)
    {
        return 'materials/' . $course->name . ' (' . $course->code . ')/';
    }

}
