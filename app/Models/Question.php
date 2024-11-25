<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function survey ()
    {
        return $this->belongsTo(Survey::class, 'id');
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class, 'id');
    }
}
