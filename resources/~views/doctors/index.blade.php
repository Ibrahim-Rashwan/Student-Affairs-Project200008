@extends('layouts.app')

@section('content')



    @if ($doctors && count($doctors) > 0)

        <a href="/doctors/create">Add doctor</a>

        @foreach ($doctors as $doctor)
            <?php
                $user = $doctor->user;
                $id = $doctor->id;
                $showHeader = false;
            ?>

            <a href="/doctors/{{$doctor->id}}"><h2>{{$doctor->id}}-{{$user->name}}</h2></a>
            @include('inc.users.show_min')

            <div>
                <a href="/doctors/{{$doctor->id}}/edit">Edit</a>

                <form action="/doctors/{{$doctor->id}}" method="POST">
                    <input type="hidden" name="_token" value={{ csrf_token() }} />
                    <input type="hidden" name="_method" value='DELETE' />

                    <button type="submit">Delete</button>
                </form>
            </div>

            <hr>
        @endforeach

    @else
        <h1>No doctors!</h1>
    @endif

    <br>
    <br>

    <a href="/doctors/create">Add doctor</a>

@endsection
