
@if (count($errors) > 0)
    @foreach ($errors as $error)
        <div class="alert error">{{$error}}</div>
    @endforeach
@endif

@if (session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
@endif

@if (session('error'))
    <div  class="alert alert-danger">{{session('error')}}</div>
@endif

@if (session('delete'))
    <div  class="alert alert-danger">{{session('delete')}}</div>
@endif
