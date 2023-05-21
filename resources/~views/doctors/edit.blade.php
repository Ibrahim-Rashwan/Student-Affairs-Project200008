<?php
    $user = $doctor->user;
?>


@extends('layouts.app')

@section('content')

    <h1>Edit Student:</h1>

    <form action="/doctors/{{$doctor->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />

        @include('inc.users.edit')

        <br>
        <br>

        <button id="submit-button" type="submit" fform="upload-form">Submit</button>

    </form>

    <a href="/doctors">Back</a>

@endsection
