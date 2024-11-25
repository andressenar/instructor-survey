<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['survey_id', 'question', 'type', 'options'];

    protected $casts = [
        'options' => 'array', // Para poder manejar las opciones como un array
    ];

    public function survey ()
    {
        return $this->belongsTo(Survey::class);
    }

    public function answers ()
    {
        return $this->hasMany(Answer::class);
    }
}
