<?php
    $user = $student->user;
    $departments = App\Models\Department::all();
?>


@extends('layouts.app')

@section('content')

    <h1>Edit Student:</h1>

    <form action="/students/{{$student->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        @include('inc.users.edit')


        <div class="my-3">

        <label class="form-label">
            Department:
            <select class="form-select" name="department_id">
                @foreach ($departments as $department)
                    <option value={{$department->id}}
                        <?php if ($student->department_id == $department->id) { echo "selected"; }?>>
                        {{$department->name}} ({{$department->code}})
                    </option>
                @endforeach
            </select>
        </label>
        </div>



        <div class="my-3">
            <label class="form-label">
                level:
                <input type="number" class="form-control" name="level" value="{{$student->level}}" />
            </label>

        </div>


        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" id="submit-button" fform="upload-form">Edit</button>
            <a class="btn btn-secondary" href="/students/">Back</a>
        </div>

    </form>


@endsection
