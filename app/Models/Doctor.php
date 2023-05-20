<?php

namespace App\Models;

use App\Models\Course;
use App\Shared\Shared;
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

    public function toString()
    {
        return "{$this->id}-{$this->user->name}";
    }

    public function link()
    {
        $isMe = Shared::isDoctor() && Shared::getActiveUserTypedId() == $this->id;
        $prefix = $isMe ? '* ' : '';
        $postfix = $isMe ? ' (You)' : '';

        return "<a href=\"/doctors/{$this->id}\"> {$prefix}{$this->toString()}{$postfix} </a>";
    }

}
