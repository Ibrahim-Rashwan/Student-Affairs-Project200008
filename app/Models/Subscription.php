<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Subscription extends Pivot
{

    protected $fillableeee = [
        'student_id',
        'course_id'
    ];

}
