<h2>{{$id}}-{{$user->name}}</h2>

<p>
    Email:<br>
    {{$user->email}}
</p>

<p>
    National Number:<br>
    {{$user->national_number}}
</p>

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

<small>email verified at: {{$user->email_verified_at}}</small>
