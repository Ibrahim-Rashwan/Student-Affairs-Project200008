@extends('layouts.master')

@section('content')

    <form action="/departments/{{$department->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        <label>
            Name:
            <input type="text" name="name" value={{$department->name}} />
        </label>

        <label>
            Code:
            <input type="text" name="code" value={{$department->code}} />
        </label>

        <button type="submit">Submit</button>
    </form>

    <a href="/departments">Back</a>

@endsection
