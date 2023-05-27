
<?php
    $departments = App\Models\Department::all();
?>

@extends('layouts.app')

@section('content')

    <h1>Create Student:</h1>

    <form action="/students/" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        @include('inc.users.create')


        <div class="my-3">
            <label class="form-label my-3">
                Department:
                <select class="form-select" name="department_id">
                    @foreach ($departments as $department)
                        <option value={{$department->id}}>{{$department->name}} ({{$department->code}})</option>
                    @endforeach
                </select>
            </label>
        </div>


      <div class="my-3">
          <label class="form-label ">
              level:
              <input class="form-control" type="number" name="level" />
            </label>
        </div>


        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" id="submit-button" fform="upload-form">Create</button>
            <a class="btn btn-secondary" href="/students/">Back</a>
        </div>

    </form>



@endsection
