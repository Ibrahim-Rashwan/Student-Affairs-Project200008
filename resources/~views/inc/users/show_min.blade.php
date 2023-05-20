@if (isset($showHeader) && $showHeader == true)
    <h2>{{$id}}-{{$user->name}}</h2>
@endif

<p>
    Phone:<br>
    {{$user->phone}}
</p>

<p>
    Age:<br>
    {{$user->age}}
</p>

<p>
    Gender:<br>
    {{$user->gender}}
</p>
