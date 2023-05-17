<?php
    $route = "/students/{$student->id}";

    $user = $student->user;
    $id = $student->id;
?>

@extends('layouts.master')

@section('content')

    @include('inc.users.show')

    <p>
        Department:
        <br>
        {{$student->department->name}} ({{$student->department->code}})
    </p>


    <p>
        Level:
        <br>
        {{$student->level}}
    </p>

    <hr>

    <section style="margin-left: 5%">
        @if ($student->courses && count($student->courses) > 0)
            <h3>Courses:</h3>
            @foreach ($student->courses as $course)

                <a href="courses/{{$course->id}}">{{$course->name}} ({{$course->code}})</a>
                <br>
                Mark: {{$course->subscription->mark}}

                <hr>
            @endforeach
        @else
            <h3>No Courses...</h3>
        @endif
    </section>

    <hr>

    <a href="{{$route}}/edit">Edit</a>

    <form action="{{$route}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='DELETE' />

        <button type="submit">Delete</button>
    </form>

    <a href="/students">Back</a>

@endsection
