@extends('layouts.app')

@section('content')

<div class="card  mb-5">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="">Doctors</h1>

        @if (App\Shared\Shared::isAdmin())
            <a class=" text-align-center btn btn-success" href="/doctors/create">Add doctor</a>
        @endif
    </div>
</div>

    @if ($doctors && count($doctors) > 0)


        @foreach ($doctors as $doctor)
            <?php
                $user = $doctor->user;
                $id = $doctor->id;
                $showHeader = false;
            ?>
            <div class="card p-3 mb-3">
                <a href="/doctors/{{$doctor->id}}">
                    <h2 class="card-title">
                        @if (App\Shared\Shared::isDoctor() && App\Shared\Shared::getActiveUserTypedId() == $doctor->id)
                            *
                        @endif
                        {{$user->name}}
                        @if (App\Shared\Shared::isDoctor() && App\Shared\Shared::getActiveUserTypedId() == $doctor->id)
                            (You)
                        @endif
                    </h2>
                </a>
                @include('inc.users.show_min')

                <div>
                    <div class="d-flex justify-content-between">
                            @if (App\Shared\Shared::isAdmin() || (App\Shared\Shared::isDoctor() && App\Shared\Shared::getActiveUserTypedId() == $doctor->id))
                            <a class="btn btn-primary mx-1" href="/doctors/{{$doctor->id}}/edit">Edit</a>
                            @endif

                            @if (App\Shared\Shared::isAdmin())
                            <form action="/doctors/{{$doctor->id}}" method="POST">
                                <input type="hidden" name="_token" value={{ csrf_token() }} />
                                <input type="hidden" name="_method" value='DELETE' />

                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                            @endif
                    </div>

                </div>

            </div>
        @endforeach

    @else
        <h1>No doctors!</h1>
    @endif


@endsection
