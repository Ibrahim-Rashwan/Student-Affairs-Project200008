
@extends('layouts.app')

@section('content')

    <h1>Add Exam to:</h1>
    {!! $course->toString() !!}

    <form action="/courses/{{$course->id}}/exams" method="POST" enctype="multipart/form-data" class="mt-5">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        <label class="form-label" for="file">
            File:
        </label>
        <input id="file" class="form-control" type="file" accept=".pdf,.doc,.docx,.odt,.ppt,.pptx,.odp" required name="file" />

        <br>
        <br>

        <label class="form-label">
            Starts at:
            <input class="form-control" type="datetime" name="start_time" required value="{{now()}}" />
        </label>

        <br>
        <br>

        <label class="form-label">
            Ends at:
            <input class="form-control" type="datetime" name="end_time" required value="{{now()}}" />
        </label>

        <br>
        <br>

        <label class="form-label">
            Can display score:
            <input type="checkbox" name="can_display_score" checked value="1">
        </label>

        <br>
        <br>

        <button class="btn btn-success" type="submit">Submit</button>

    </form>

@endsection
