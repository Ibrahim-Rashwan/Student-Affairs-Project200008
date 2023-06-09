@extends('layouts.app')

@section('content')
    <h1>Add Department:</h1>

    <form action="/departments" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='POST' />

        <label>
            Name:
            <input type="text" name="name" value="" />
        </label>

        <label>
            Code:
            <input type="text" name="code" value="" />
        </label>

        <button type="submit">Submit</button>
    </form>

    <a href="/departments">Back</a>

@endsection
