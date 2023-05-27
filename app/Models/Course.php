<?php

namespace App\Models;

use App\Models\Student;
use App\Shared\Shared;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'doctor_id',
        'name',
        'code',
        'number_of_hours',
        'materials'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function pre_requisite()
    {
        return $this->hasOne(Course::class, 'id', 'pre_requisite_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function students()
    {
        return  $this->belongsToMany(Student::class, 'subscriptions')->
            using(Subscription::class)->
            as('subscription')->
            withPivot('mark')->
            withTimestamps();
    }

    public function getSubscriptionState()
    {
        $user = Auth::user();
        $student = $user->student;
        // return $student->courses;
        if (!isset($student)) {
            return false;
        }

        foreach ($student->courses as $subscribedCourse) {
            if ($this->id == $subscribedCourse->id) {
                return $subscribedCourse->subscription->mark;
            }
        }

        return false;
    }

    public function canSubscribe()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!isset($student)) {
            return false;
        }

        if ($this->pre_requisite == null) {
            return true;
        }

        foreach ($student->courses as $subscribedCourse) {
            if ($this->pre_requisite->id == $subscribedCourse->id) {
                return $subscribedCourse->subscription->mark >= Shared::PASS_MARK;
            }
        }

        return false;
    }

    public function toString()
    {
        return "{$this->id}-{$this->name} ({$this->code})";
    }

    public function link()
    {
        return "<a href=\"/courses/{$this->id}\">{$this->toString()}</a>";
    }

}
