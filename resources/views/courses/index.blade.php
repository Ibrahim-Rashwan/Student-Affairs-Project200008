@extends('layouts.app')

@section('content')
<div class="card mb-5">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="">Courses</h1>
        @if (App\Shared\Shared::isAdmin())
        <a class=" text-align-center btn btn-success" href="/courses/create">Add courses</a>
        @endif
    </div>
</div>
    @if ($courses && count($courses) > 0)

        @foreach ($courses as $course)
            <div class="card p-3 mb-3">
                <a href="/courses/{{$course->id}}">
                    <h2>{{$course->toString()}}</h2>
                </a>

                <p>Number of hours: {{$course->number_of_hours}}</p>
                <p>Department: {!! $course->department->link() !!}</p>

                @if (App\Shared\Shared::isAdmin())
                <div class="d-flex justify-content-between mt-3">
                    <a href="/courses/{{$course->id}}/edit" class="btn btn-primary mb-3">Edit</a>

                    <form action="/courses/{{$course->id}}" method="POST" class="d-inline">
                        <input type="hidden" name="_token" value={{ csrf_token() }} />
                        <input type="hidden" name="_method" value='DELETE' />

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
                @endif
            </div>
        @endforeach

    @else
        <h1>No courses!</h1>
    @endif



@endsection
