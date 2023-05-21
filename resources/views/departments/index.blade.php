@extends('layouts.app')

@section('content')
    <div class="container">


       <div class="card mb-5">

           <div class="card-header d-flex justify-content-between align-items-center">
               <h1 class="">Departemts</h1>
               @if (App\Shared\Shared::isAdmin())
               <a class=" text-align-center btn btn-success" href="/departments/create">Add department</a>
               @endif
           </div>
       </div>
        @if ($departments && count($departments) > 0)

        @foreach ($departments as $department)
        <div class="card p-3 mb-3">
                    <a href="/departments/{{$department->id}}">
                        <h2 class="card-title">{{$department->name}} </h2>
                        <div class="ms-5">
                            <p class="card-text">ID:{{$department->id}}<br>CODE: ({{$department->code}})</p>
                        </div>
                    </a>
                    @if (App\Shared\Shared::isAdmin())
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary mx-1" href="/departments/{{$department->id}}/edit">Edit</a>

                        <form action="/departments/{{$department->id}}" method="POST">
                            <input type="hidden" name="_token" value={{ csrf_token() }} />
                            <input type="hidden" name="_method" value='DELETE' />

                            <button class="btn btn-danger " type="submit">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
            @endforeach

        @else
            <h1>No departments!</h1>
        @endif

        <br>
        <br>


</div>

@endsection
