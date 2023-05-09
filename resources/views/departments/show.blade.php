@extends('layouts.master')

@section('content')

    <h2>{{$department->id}}-{{$department->name}} ({{$department->code}})</h2>

    <a href="/departments/{{$department->id}}/edit">Edit</a>

    <form action="/departments/{{$department->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='DELETE' />

        <button type="submit">Delete</button>
    </form>

    <a href="/departments">Back</a>

@endsection
