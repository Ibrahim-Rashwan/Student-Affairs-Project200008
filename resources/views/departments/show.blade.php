@extends('layouts.app')

@section('content')
<div class="card p-3">

    {{-- <h2>{{$department->id}}-{{$department->name}} ({{$department->code}})</h2> --}}
    <h2 class="card-title">{{$department->name}} </h2>
    <p class="card-text my-1">ID:{{$department->id}}<br>CODE: ({{$department->code}})</p>

    @if (App\Shared\Shared::isAdmin())
        <form action="/departments/{{$department->id}}" method="POST" class="mb-3 mt-3">
            <input type="hidden" name="_token" value={{ csrf_token() }} />
            <input type="hidden" name="_method" value='DELETE' />

            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a class="btn btn-primary mx-1" href="/departments/{{$department->id}}/edit">Edit</a>
                </div>
                <a class="btn btn-secondary" href="/departments/">Back</a>
            </div>
        </form>
    @endif

    <hr>

    <div class="ms-5">
        <h3 class="mt-3">Courses:</h3>
        <div class="ms-5">
            @foreach ($department->courses as $course)
                {!! $course->link() !!}
                <br>
            @endforeach
        </div>
        <hr>
    </div>

    <div class="ms-5">
        <h3 class="mt-3">Doctors:</h3>
        <div class="ms-5">
            @php
                $doctors = App\Models\Doctor::all();
                $availableDoctors = [];

                foreach ($doctors as $doctor) {
                    foreach($doctor->courses as $course) {
                        if ($course->department_id == $department->id) {
                            array_push($availableDoctors, $doctor);
                            break;
                        }
                    }
                }
            @endphp

            @foreach ($availableDoctors as $doctor)
            {!! $doctor->link() !!}
            <br>
            @endforeach
        </div>
        <hr>
    </div>

    <div class="ms-5">
        <h3 class="mt-3">Students:</h3>
        <div class="ms-5">
            @foreach ($department->students as $student)
            {!! $student->link() !!}
            <br>
            @endforeach
        </div>
    </div>

</div>

@endsection
