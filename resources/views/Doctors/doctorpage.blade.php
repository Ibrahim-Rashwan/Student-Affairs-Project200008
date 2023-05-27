@extends('Doctors.master')
@section('content')
<h1>Doctors</h1>
        @if (count($course)>0)
                    @foreach ($course as $c )

                    <table>
                        <tr>
                          <th>{{$c->name}}

                        <a href=" Doctors/{{$c->id}}"><h2>view course</h2></a>
                       </th>
                        </tr>

                      </table>
                    @endforeach


        @endif
@endsection
