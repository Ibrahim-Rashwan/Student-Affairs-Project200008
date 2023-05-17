<?php
    $user = $student->user;
    $departments = App\Models\Department::all();
?>


@extends('layouts.master')

@section('content')

    <h1>Edit Student:</h1>

    <form action="/students/{{$student->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        @include('inc.users.edit')

        <br>
        <br>

        <label>
            Department:
            <select name="department_id">
                @foreach ($departments as $department)
                    <option value={{$department->id}}
                        <?php if ($student->department_id == $department->id) { echo "selected"; }?>>
                        {{$department->name}} ({{$department->code}})
                    </option>
                @endforeach
            </select>
        </label>

        <br>
        <br>

        <label>
            level:
            <input type="number" name="level" value="{{$student->level}}" />
        </label>

        <br>
        <br>

        <button id="submit-button" type="submit" fform="upload-form">Submit</button>

    </form>

    <a href="/students">Back</a>

@endsection
