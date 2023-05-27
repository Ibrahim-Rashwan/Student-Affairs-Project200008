@extends('layouts.app')

@section('content')
    {{-- <h1>Add Department:</h1>

     <form action="/departments/" method="POST">
        <input type="hidden" name="_token" value={{ csrf_token() }} />
        <input type="hidden" name="_method" value='POST' />

        <label>
            Name:
            <input type="text" name="name" value="" />
        </label>

        <label>
            Code:
            <input type="text" name="code" value="" />
        </label>

        <button type="submit">Submit</button>
    </form> --}}

    {{-- create form --}}
    <form action="/departments/" method="POST">
        <input type="hidden" name="_token" value={{csrf_token()}} />
        <input type="hidden" name="_method" value='POST' />
        <legend>Add new Department</legend>
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" name="name" value=""  />

        </div>
        <div class="mb-3">
          <label for="code" class="form-label">Code</label>
          <input type="text" class="form-control" name="code" value="" />
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-secondary" href="/departments/">Back</a>
        </div>
      </form>

@endsection
