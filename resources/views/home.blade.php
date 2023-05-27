@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-5">
                        {{ __('You are logged in as') }}
                        @if (App\Shared\Shared::isAdmin())
                            Admin
                        @elseif(App\Shared\Shared::isDoctor())
                            Doctor
                        @elseif(App\Shared\Shared::isStudent())
                            Student
                        @endif
                    </div>

                    <?php
                        $showHeader = false;
                        if (App\Shared\Shared::isDoctor()) {
                            $link = $user->doctor->link();
                        } else if (App\Shared\Shared::isStudent()) {
                            $link = $user->student->link();
                        }
                    ?>
                    @if (isset($link))
                        <h2>{!! $link !!}</h2>
                    @else
                        <h2>{{$id}}-{{$user->name}}</h2>
                    @endif
                    <div class="ms-5">
                        @include('inc.users.show')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
