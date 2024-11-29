<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'second_last_name',
        'identity_document',
    ];

    public function answers ()
    {
        return $this->hasMany(Answer::class);
    }

    public function courses ()
    {
        return $this->belongsToMany(Course::class,'course_instructor', 'instructor_id', 'course_id');
    }

}
