@extends('layouts.app')

@section('content')

<form action="/departments/{{$department->id}}" method="POST">
    <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='PUT' />
         <legend>Edit Department</legend>


        {{-- <label>
            Name:
            <input type="text" name="name" value={{$department->name}} />
        </label>

        <label>
            Code:
            <input type="text" name="code" value={{$department->code}} />
        </label> --}}

        {{-- <button type="submit">Submit</button> --}}
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" name="name" value={{$department->name}}  />

        </div>
        <div class="mb-3">
          <label for="code" class="form-label">Code</label>
          <input type="text" class="form-control" name="code" value={{$department->code}} />
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">edit</button>
            <a class="btn btn-secondary" href="/departments/">Back</a>
        </div>
    </form>



@endsection
