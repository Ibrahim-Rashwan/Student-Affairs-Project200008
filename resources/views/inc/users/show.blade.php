@if (isset($showHeader) ? $showHeader : true)
    <h2>{{$id}}-{{$user->name}}</h2>
@endif

<p>
    Email:
    {{$user->email}}
</p>

<p>
    National Number:
    {{$user->national_number}}
</p>

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

<small>email verified at: {{$user->email_verified_at}}</small>
