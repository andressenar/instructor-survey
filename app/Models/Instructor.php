<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    public function user ()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class, 'id');
    }

    public function courses ()
    {
        return $this->belongsToMany(Course::class, 'id');
    }
}
