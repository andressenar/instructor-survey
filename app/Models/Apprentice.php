<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{

    public function user ()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function survey ()
    {
        return $this->belongsTo(Survey::class, 'id');
    }

    public function course ()
    {
        return $this->belongsTo(Course::class, 'id');
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class, 'id');
    }


}
