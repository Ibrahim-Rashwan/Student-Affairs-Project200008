<?php
    $departments = App\Models\Department::all();
    $doctors = App\Models\Doctor::all();
    $courses = App\Models\Course::all();
?>

@extends('layouts.app')

@section('content')

    <h1>Edit Course:</h1>

    <form action="/courses/{{$course->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        <label>
            Name:
            <input type="text" name="name" value={{$course->name}} />
        </label>

        <label>
            Code:
            <input type="text" name="code" value={{$course->code}} />
        </label>

        <br>
        <br>

        <label>
            Number Of Hours:
            <input type="number" name="number_of_hours" value={{$course->number_of_hours}} />
        </label>

        <br>
        <br>

        <label>
            Department:
            <select name="department_id">
                @foreach ($departments as $department)
                    <option value={{$department->id}}
                        <?php if ($course->department_id == $department->id) { echo "selected"; }?>>
                        {{$department->name}} ({{$department->code}})
                    </option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <label>
            Doctor:
            <select name="doctor_id">
                @foreach ($doctors as $doctor)
                    <option value={{$doctor->id}}
                        <?php if ($course->doctor_id == $doctor->id) { echo "selected"; }?>>
                        {{$doctor->user->name}}
                    </option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <label>
            Pre-Requisite:
            <select name="pre_requisite_id">
                <option value=-1>None</option>
                @foreach ($courses as $curcourse)
                    <option value={{$curcourse->id}}
                        <?php if ($course->pre_requisite_id == $curcourse->id) { echo "selected"; }?>>
                        {{$curcourse->name}} ({{$curcourse->code}})
                    </option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <button type="submit">Submit</button>
    </form>

    <a href="/courses/{{$course->id}}">Back</a>

@endsection
