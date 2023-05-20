
@extends('layouts.app')

@section('content')

    <form action="/doctors" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <legend>Add Doctor</legend>
        @include('inc.users.create')

        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary" id="submit-button" fform="upload-form">Create</button>
            <a class="btn btn-secondary" href="/doctors/">Back</a>
        </div>


    </form>

@endsection
