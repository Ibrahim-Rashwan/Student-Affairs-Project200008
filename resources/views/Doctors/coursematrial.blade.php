@extends('Doctors.master')
@section('content')
<h1>Doctors</h1>

<form action="App\Http\Controllers\Doctorscontroller@store" method="post" enctype="multipart/form-data" >
    @csrf
    <input type="file" name="pdf">
    <button type="submit">Upload</button>
</form>


@endsection
