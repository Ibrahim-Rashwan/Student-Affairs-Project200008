
@extends('layouts.app')

@section('content')

    <h1>Edit Course:</h1>

    <form id="upload-form" action="/courses/{{$course->id}}/exams/{{$exam->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        <label>
            <?php
                $displayName = App\Shared\Shared::getDisplayName($exam->name);
                $name = App\Shared\Shared::getBaseName($displayName);
            ?>
            Name:
            <input type="text" name="name" value="{{$name}}" />
        </label>

        <br>
        <br>

        <label>
            Starts at:
            <input type="datetime" name="start_time" value="{{$exam->start_time}}" />
        </label>

        <br>
        <br>

        <label>
            Ends at:
            <input type="datetime" name="end_time" value="{{$exam->end_time}}" />
        </label>

        <br>
        <br>

        <label>
            Can display score:
            <input type="checkbox" name="can_display_score" value="{{$exam->can_display_score}}">
        </label>

        <br>
        <br>

        <button type="submit">Submit</button>

    </form>

@endsection
