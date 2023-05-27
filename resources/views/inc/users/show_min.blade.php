@if (isset($showHeader) ? $showHeader : true)
    <h2>{{$id}}-{{$user->name}}</h2>
@endif

<p>
    Phone:
    {{$user->phone}}
</p>

<p>
    Age:
    {{$user->age}}
</p>

<p>
    Gender:
    {{$user->gender}}
</p>
