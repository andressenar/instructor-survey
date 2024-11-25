<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Apprentice extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'middle_name',    
        'last_name',
        'second_last_name',
        'identity_document',
        'course_id'
    ];

    // public function user ()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function survey ()
    {
        return $this->belongsTo(Survey::class);
    }

    public function course ()
    {
        return $this->belongsTo(Course::class);
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class);
    }


}
