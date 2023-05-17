
<?php
    $departments = App\Models\Department::all();
?>

@extends('layouts.master')

@section('content')

    <h1>Create Student:</h1>

    <form action="/students" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        @include('inc.users.create')

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
            level:
            <input type="number" name="level" />
        </label>

        <br>
        <br>

        <button id="submit-button" type="submit" fform="upload-form">Submit</button>

    </form>

    <a href="/students">Back</a>

@endsection
