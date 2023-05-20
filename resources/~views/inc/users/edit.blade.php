<label>
    Email:
    <input type="email" name="email" value="{{$user->email}}" />
</label>

<br>
<br>

<label>
    Password:
    <input type="password" name="password" value="{{$user->password}}" />
</label>

<br>
<br>

<label>
    Name:
    <input type="text" name="name" value="{{$user->name}}" />
</label>

<br>
<br>

<label>
    National Number:
    <input type="number" name="national_number" value="{{$user->national_number}}" />
</label>

<br>
<br>

<label>
    Phone:
    <input type="number" name="phone" value="{{$user->phone}}" />
</label>

<br>
<br>

<label>
    Age:
    <input type="number" name="age" value="{{$user->age}}" />
</label>

<br>
<br>

<label>
    Gender:
    <select name="gender">
        <option value='male'
            <?php if ($user->gender == 'male') { echo "selected"; }?>>
            Male
        </option>
        <option value='female'
            <?php if ($user->gender == 'female') { echo "selected"; }?>>
            Female
        </option>
    </select>
</label>
