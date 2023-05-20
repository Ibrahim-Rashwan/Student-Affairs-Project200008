<?php

namespace App\Models;

use App\Models\Course;
use App\Models\Department;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'level'
    ];

    // protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return  $this->belongsToMany(Course::class, 'subscriptions')->
            using(Subscription::class)->
            as('subscription')->
            withPivot('mark')->
            withTimestamps();
    }

    public function toString()
    {
        return "{$this->id}-{$this->user->name}";
    }

    public function link()
    {
        return "<a href=\"/students/{$this->id}\">{$this->toString()}</a>";
    }

}
