
@extends('layouts.app')

@section('content')

    <h1>Edit Material for:</h1>
    <h2>{{$course->id}}-{{$course->name}} ({{$course->code}})</h2>

    <form action="/courses/{{$course->id}}/materials/{{$materialId}}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT" />

        <input type="text" name="name" value="{{$materialName}}" />

        <button type="submit">Submit</button>
    </form>

@endsection
