<div class="mb-3">
    <label class="form-label w-100 ">
    Email:
    <input  class="form-control" type="email" name="email" value="{{$user->email}}" />
</label>

<div class="mb-3">
    <label class="form-label w-100 ">
    Name:
    <input class="form-control"  type="text" name="name" value="{{$user->name}}" />
</label>
</div>


<div class="mb-3">
    <label class="form-label w-100 ">
    National Number:
    <input class="form-control"  type="number" name="national_number" value="{{$user->national_number}}" />
</label>
</div>



<div class="mb-3">
    <label class="form-label w-100 ">
    Phone:
    <input class="form-control"  type="number" name="phone" value="{{$user->phone}}" />
</label>
</div>


<div class="mb-3">
    <label class="form-label w-100 ">
    Age:
    <input class="form-control"  type="number" name="age" value="{{$user->age}}" />
</label>
</div>



<div class="mb-3">
    <label class="form-label w-100 ">
    Gender:
    <select class="form-select" name="gender">
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
</div>
