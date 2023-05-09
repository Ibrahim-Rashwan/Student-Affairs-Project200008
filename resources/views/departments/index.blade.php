@extends('layouts.master')

@section('content')

    @if ($departments && count($departments) > 0)

        @foreach ($departments as $department)
            <div>
                <a href="/departments/{{$department->id}}">
                    <h2>{{$department->id}}-{{$department->name}} ({{$department->code}})</h2>
                </a>

                <a href="/departments/{{$department->id}}/edit">Edit</a>

                <form action="/departments/{{$department->id}}" method="POST">
                    <input type="hidden" name="_token" value={{ csrf_token() }} />
                    <input type="hidden" name="_method" value='DELETE' />

                    <button type="submit">Delete</button>
                </form>
            </div>
        @endforeach

    @else
        <h1>No departments!</h1>
    @endif

    <br>
    <br>

    <a href="/departments/create">Add department</a>

@endsection
