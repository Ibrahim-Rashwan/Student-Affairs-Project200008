<?php
    $departments = App\Models\Department::all();
    $doctors = App\Models\Doctor::all();
    $courses = App\Models\Course::all();
?>

@extends('layouts.app')

@section('content')

    <h1>Add Course</h1>

    <form action="/courses" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <div class="my-3">

            <label class="form-label w-100">
                Name:
                <input class="form-control" type="text" name="name" value="" />
            </label>
        </div>
        <div class="my-3">

            <label class="form-label w-100">
                Code:
                <input class="form-control" type="text" name="code" value="" />
            </label>
        </div>

        <div class="my-3">

            <label class="form-label w-100">
                    Number Of Hours:
                    <input class="form-control" type="number" name="number_of_hours" value="3" />
                </label>

        </div>

        <div class="my-3">
                <label class="form-label w-100">
                    Department:
                    <select class="form-select" name="department_id">
                        @foreach ($departments as $department)
                            <option value={{$department->id}}>{{$department->name}} ({{$department->code}})</option>
                        @endforeach
                    </select>
                </label>
            </div>


        <div class="my-3">
                <label class="form-label w-100">
                    Doctor:
                    <select class="form-select" name="doctor_id">
                        @foreach ($doctors as $doctor)
                            <option value={{$doctor->id}}>{{$doctor->user->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>

        <div class="my-3">
                <label class="form-label w-100">
                    Pre-Requisite:
                    <select class="form-select" name="pre_requisite_id">
                        <option value=-1>None</option>
                        @foreach ($courses as $course)
                            <option value={{$course->id}}>{{$course->name}} ({{$course->code}})</option>
                        @endforeach
                    </select>
                </label>
            </div>

        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" id="submit-button" fform="upload-form">Create</button>
            <a class="btn btn-secondary" href="/courses/">Back</a>
        </div>
    </form>


@endsection
