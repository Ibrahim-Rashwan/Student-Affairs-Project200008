<?php
    $route = "/students/{$student->id}";

    $user = $student->user;
    $id = $student->id;
?>

@extends('layouts.app')

@section('content')

    <div class="card p-3">
        @include('inc.users.show')

        <p class="mt-3">
            Department:
            {!! $student->department->link() !!}
        </p>


        <p>
            Level:
            {{$student->level}}
        </p>

        <hr>

        <section style="margin-left: 5%">
            @if ($student->courses && count($student->courses) > 0)
                <h3>Courses:</h3>
                @foreach ($student->courses as $course)
                    {!! $course->link() !!}
                    <br>
                    Mark:
                    @if ($course->subscription->mark != null)
                        {{$course->subscription->mark}}
                    @else
                        In progress
                    @endif

                    <hr>
                @endforeach
            @else
                <h3>No Courses...</h3>
                <hr>
            @endif
        </section>

        <form action="/students/{{$student->id}}" method="POST">
            <input type="hidden" name="_token" value={{ csrf_token() }} />
            <input type="hidden" name="_method" value='DELETE' />

            <div class="d-flex align-items-center justify-content-between">
                <div>
                    @if (App\Shared\Shared::isAdmin())
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endif
                    @if (App\Shared\Shared::isAdmin() || (App\Shared\Shared::isStudent() && App\Shared\Shared::getActiveUserTypedId() == $student->id))
                    <a class="btn btn-primary mx-1" href="/students/{{$student->id}}/edit">Edit</a>
                    @endif
                </div>
                <a class="btn btn-secondary" href="/students/">Back</a>
            </div>

        </form>
    </div>

@endsection
