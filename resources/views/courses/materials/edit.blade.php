
@extends('layouts.app')

@section('content')

    <h1>Edit Material for:</h1>
    <h2>{{$course->id}}-{{$course->name}} ({{$course->code}})</h2>

    <form action="/courses/{{$course->id}}/materials/{{$materialId}}" method="POST" class="mt-3">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="PUT" />

        <input class="form-control mb-3" type="text" name="name" value="{{$materialName}}" />

        <button class="btn btn-primary" type="submit">Submit</button>
    </form>

@endsection
