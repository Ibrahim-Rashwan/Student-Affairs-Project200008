@extends('layouts.app')

@section('content')

<div class="card mb-5">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h1 class="">Students</h1>
        @if (App\Shared\Shared::isAdmin())
        <a class=" text-align-center btn btn-success" href="/students/create">Add student</a>
        @endif
    </div>
</div>

    @if ($students && count($students) > 0)

        @foreach ($students as $student)
            <?php
                $user = $student->user;
                $id = $student->id;
                $showHeader = false;
            ?>
          <div class="card p-3  mb-3">
                <a href="/students/{{$student->id}}">
                    <h2 class="cart-title">
                        @if (App\Shared\Shared::isStudent() && App\Shared\Shared::getActiveUserTypedId() == $student->id)
                            *
                        @endif
                        {{$student->id}}-{{$user->name}}
                        @if (App\Shared\Shared::isStudent() && App\Shared\Shared::getActiveUserTypedId() == $student->id)
                            (You)
                        @endif
                    </h2>
                </a>
                @include('inc.users.show_min')

                <p>
                    Department:
                    {!! $student->department->link() !!}
                </p>


                <p>
                    Level:
                    {{$student->level}}
                </p>

                <div>
                     <div class="d-flex justify-content-between">
                        @if (App\Shared\Shared::isAdmin() || (App\Shared\Shared::isStudent() && App\Shared\Shared::getActiveUserTypedId() == $student->id))
                        <a class="btn btn-primary mx-1" href="/students/{{$student->id}}/edit">Edit</a>
                        @endif

                        @if (App\Shared\Shared::isAdmin())
                        <form action="/students/{{$student->id}}" method="POST">
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
        <h1>No students!</h1>
    @endif

@endsection
