<?php
    $route = "/doctors/{$doctor->id}";

    $user = $doctor->user;
    $id = $doctor->id;
?>

@extends('layouts.app')

@section('content')

    <div class="card p-3">
        @include('inc.users.show')

        <hr>

        <section style="margin-left: 5%">
            @if ($doctor->courses && count($doctor->courses) > 0)
                <h3>Courses:</h3>
                @foreach ($doctor->courses as $course)
                    {!! $course->link() !!}
                    <hr>
                @endforeach
            @else
                <h3>No Courses...</h3>
                <hr>
            @endif
        </section>

        <form action="/doctors/{{$doctor->id}}" method="POST">
            <input type="hidden" name="_token" value={{ csrf_token() }} />
            <input type="hidden" name="_method" value='DELETE' />

            <div class="d-flex align-items-center justify-content-between">
                <div>
                    @if (App\Shared\Shared::isAdmin())
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endif

                    @if (App\Shared\Shared::isAdmin() || (App\Shared\Shared::isDoctor() && App\Shared\Shared::getActiveUserTypedId() == $doctor->id))
                    <a class="btn btn-primary mx-1" href="/doctors/{{$doctor->id}}/edit">Edit</a>
                    @endif
                </div>

                <a class="btn btn-secondary" href="/doctors/">Back</a>
            </div>
        </form>

    </div>

@endsection
