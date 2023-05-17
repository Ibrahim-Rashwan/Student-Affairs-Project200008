
@extends('layouts.master')

@section('content')

    <h1>Add Course:</h1>

    <form action="/courses/{{$course->id}}/exams" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        <label>
            File:
            <input type="file" accept=".pdf,.doc,.docx,.odt,.ppt,.pptx,.odp" required name="file" />
        </label>

        <br>
        <br>

        <label>
            Starts at:
            <input type="datetime" name="start_time" required value="{{now()}}" />
        </label>

        <br>
        <br>

        <label>
            Ends at:
            <input type="datetime" name="end_time" required value="{{now()}}" />
        </label>

        <br>
        <br>

        <label>
            Can display score:
            <input type="checkbox" name="can_display_score" checked value="1">
        </label>

        <br>
        <br>

        <button type="submit">Submit</button>

    </form>

@endsection
