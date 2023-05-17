<?php
    $departments = App\Models\Department::all();
    $doctors = App\Models\Doctor::all();
    $courses = App\Models\Course::all();
?>

@extends('layouts.master')

@section('content')

    <h1>Add Course:</h1>

    <form action="/courses" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        <label>
            Name:
            <input type="text" name="name" value="" />
        </label>

        <label>
            Code:
            <input type="text" name="code" value="" />
        </label>

        <br>
        <br>

        <label>
            Number Of Hours:
            <input type="number" name="number_of_hours" value="3" />
        </label>

        <br>
        <br>

        <label>
            Department:
            <select name="department_id">
                @foreach ($departments as $department)
                    <option value={{$department->id}}>{{$department->name}} ({{$department->code}})</option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <label>
            Doctor:
            <select name="doctor_id">
                @foreach ($doctors as $doctor)
                    <option value={{$doctor->id}}>{{$doctor->user->name}}</option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <label>
            Pre-Requisite:
            <select name="pre_requisite_id">
                <option value=-1>None</option>
                @foreach ($courses as $course)
                    <option value={{$course->id}}>{{$course->name}} ({{$course->code}})</option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <button id="submit-button" type="submit" fform="upload-form">Submit</button>

    </form>

    <a href="/courses">Back</a>

@endsection
