<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    use HasFactory;


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
