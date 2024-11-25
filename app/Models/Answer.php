<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function apprentice ()
    {
        return $this->belongsTo(Apprentice::class, 'id');
    }

    public function instructor ()
    {
        return $this->belongsTo(Instructor::class, 'id');
    }

    public function question ()
    {
        return $this->belongsTo(Question::class, 'id');
    }
}
