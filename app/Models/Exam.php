<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'start_time',
        'end_time'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
