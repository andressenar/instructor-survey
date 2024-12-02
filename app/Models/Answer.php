<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'type',
        'qualification',
        'apprentice_id',
        'instructor_id',
        'question_id',
        'course_id'
    ];

    public function apprentice ()
    {
        return $this->belongsTo(Apprentice::class);
    }

    public function instructor ()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function question ()
    {
        return $this->belongsTo(Question::class);
    }
}
