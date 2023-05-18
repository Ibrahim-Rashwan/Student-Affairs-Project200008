<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;

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

    public function toString()
    {
        return "{$this->id}-{$this->name} ({$this->code})";
    }

}
