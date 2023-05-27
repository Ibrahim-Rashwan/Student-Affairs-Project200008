<?php
    $user = $doctor->user;
?>


@extends('layouts.app')

@section('content')

    <form action="/doctors/{{$doctor->id}}" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />
        <legend>Edit Doctor</legend>

        @include('inc.users.edit')

        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" id="submit-button" fform="upload-form">Edit</button>
            <a class="btn btn-secondary" href="/doctors/{{$doctor->id}}">Back</a>
        </div>


    </form>


@endsection
