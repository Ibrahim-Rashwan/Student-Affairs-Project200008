<?php
    $materials = json_decode($course->materials);
    $exams = json_decode($course->exams);
?>

@extends('layouts.master')

@section('content')

    <h2>{{$course->id}}-{{$course->name}} ({{$course->code}})</h2>

    <p>
        Number of Hours:
        <br>
        {{$course->number_of_hours}}
    </p>

    <section>
        <h3>Meterials:</h3>
        @foreach ($materials as $material)
            {{$material}}
            <a href="/materials/{{$materials}}" download>Download</a>
        @endforeach
    </section>

    <section>
        <h3>Exams:</h3>
    </section>

    <a href="/courses/{{$course->id}}/edit">Edit</a>

    <form action="/courses/{{$course->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='DELETE' />

        <button type="submit">Delete</button>
    </form>

    <a href="/courses">Back</a>

@endsection
