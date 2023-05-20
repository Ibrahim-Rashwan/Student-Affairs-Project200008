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
        <div class="wy-3">
                <label class="form-label w-100">
                    Name:
                    <input class="form-control" type="text" name="name" value={{$course->name}} />
                </label>
        <div class="wy-3"></div>
                <label class="form-label w-100">
                    Code:
                    <input class="form-control" type="text" name="code" value={{$course->code}} />
                </label>
        </div>

        <div class="wy-3">
                <label class="form-label w-100">
                    Number Of Hours:
                    <input class="form-control" type="number" name="number_of_hours" value={{$course->number_of_hours}} />
                </label>
        </div>

        <div class="wy-3">
                <label class="form-label w-100">
                    Department:
                    <select class="form-select" name="department_id">
                        @foreach ($departments as $department)
                            <option value={{$department->id}}
                                <?php if ($course->department_id == $department->id) { echo "selected"; }?>>
                                {{$department->name}} ({{$department->code}})
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="wy-3">

                <label class="form-label w-100">
                    Doctor:
                    <select class="form-select" name="doctor_id">
                        @foreach ($doctors as $doctor)
                            <option value={{$doctor->id}}
                                <?php if ($course->doctor_id == $doctor->id) { echo "selected"; }?>>
                                {{$doctor->user->name}}
                            </option>
                        @endforeach
                    </select>
                </label>
        </div>

        <div class="wy-3">
                <label  class="form-label w-100">
                    Pre-Requisite:
                    <select class="form-select" name="pre_requisite_id">
                        <option value=-1>None</option>
                        @foreach ($courses as $curcourse)
                            <option value={{$curcourse->id}}
                                <?php if ($course->pre_requisite_id == $curcourse->id) { echo "selected"; }?>>
                                {{$curcourse->name}} ({{$curcourse->code}})
                            </option>
                        @endforeach
                    </select>
                </label>
        </div>



        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" >Edit</button>
            <a class="btn btn-secondary" href="/courses/{{$course->id}}">Back</a>
        </div>
    </form>


@endsection
