@extends('layouts.master')

@section('content')

    @if ($courses && count($courses) > 0)

        @foreach ($courses as $course)
            <div>
                <a href="/courses/{{$course->id}}">
                    <h2>{{$course->id}}-{{$course->name}} ({{$course->code}})</h2>
                </a>

                <a href="/courses/{{$course->id}}/edit">Edit</a>

                <form action="/courses/{{$course->id}}" method="POST">
                    <input type="hidden" name="_token" value={{ csrf_token() }} />
                    <input type="hidden" name="_method" value='DELETE' />

                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach

    @else
        <h1>No courses!</h1>
    @endif

    <br>
    <br>

    <a href="/courses/create">Add course</a>

@endsection
