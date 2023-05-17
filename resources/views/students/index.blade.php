@extends('layouts.master')

@section('content')



    @if ($students && count($students) > 0)

        <a href="/students/create">Add student</a>

        @foreach ($students as $student)
            <?php
                $user = $student->user;
                $id = $student->id;
                $showHeader = false;
            ?>

            <a href="/students/{{$student->id}}"><h2>{{$student->id}}-{{$user->name}}</h2></a>
            @include('inc.users.show_min')

            <p>
                Department:
                <br>
                {{$student->department->name}} ({{$student->department->code}})
            </p>


            <p>
                Level:
                <br>
                {{$student->level}}
            </p>

            <div>
                <a href="/students/{{$student->id}}/edit">Edit</a>

                <form action="/students/{{$student->id}}" method="POST">
                    <input type="hidden" name="_token" value={{ csrf_token() }} />
                    <input type="hidden" name="_method" value='DELETE' />

                    <button type="submit">Delete</button>
                </form>
            </div>

            <hr>
        @endforeach

    @else
        <h1>No students!</h1>
    @endif

    <br>
    <br>

    <a href="/students/create">Add student</a>

@endsection
