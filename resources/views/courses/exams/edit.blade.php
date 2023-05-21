
@extends('layouts.app')

@section('content')

    <h1>Edit Exam for:</h1>
    {!! $course->toString() !!}

    <form action="/courses/{{$course->id}}/exams/{{$exam->id}}" method="POST" class="mt-5">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        <label class="form-label" for="name">
            <?php
                $displayName = App\Shared\Shared::getDisplayName($exam->name);
                $name = App\Shared\Shared::getBaseName($displayName);
            ?>
            Name:
        </label>
        <input id="name" class="form-control" type="text" name="name" value="{{$name}}" />

        <br>
        <br>

        <label class="form-label">
            Starts at:
            <input class="form-control" type="datetime" name="start_time" value="{{$exam->start_time}}" />
        </label>

        <br>
        <br>

        <label class="form-label">
            Ends at:
            <input class="form-control" type="datetime" name="end_time" value="{{$exam->end_time}}" />
        </label>

        <br>
        <br>

        <label class="form-label">
            Can display score:
            <input type="checkbox" name="can_display_score" value="{{$exam->can_display_score}}">
        </label>

        <br>
        <br>

        <button class="btn btn-primary" type="submit">Submit</button>

    </form>

@endsection
