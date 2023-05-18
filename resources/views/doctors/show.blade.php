<?php
    $route = "/doctors/{$doctor->id}";

    $user = $doctor->user;
    $id = $doctor->id;
?>

@extends('layouts.app')

@section('content')

    @include('inc.users.show')

    <hr>

    <section style="margin-left: 5%">
        @if ($doctor->courses && count($doctor->courses) > 0)
            <h3>Courses:</h3>
            @foreach ($doctor->courses as $course)
                <a href="/courses/{{$course->id}}">{{$course->id}}-{{$course->name}} ({{$course->code}})</a>
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

    <a href="/doctors">Back</a>

@endsection
