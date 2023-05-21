
@extends('layouts.app')

@section('content')

    <h1>Create Student:</h1>

    <form action="/doctors" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />

        @include('inc.users.create')

        <br>
        <br>

        <button id="submit-button" type="submit" fform="upload-form">Submit</button>

    </form>

    <a href="/doctors">Back</a>

@endsection
