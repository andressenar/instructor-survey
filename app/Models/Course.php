<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function apprentices ()
    {
        return $this->hasMany(Apprentice::class, 'id');
    }

    public function municipality ()
    {
        return $this->belongsTo(Municipality::class, 'id');
    }

    public function instructors ()
    {
        return $this->belongsToMany(Instructor::class, 'id');
    }
}
