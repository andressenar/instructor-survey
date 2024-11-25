<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function apprentices ()
    {
        return $this->hasMany(Apprentice::class, 'id');
    }

    public function questions ()
    {
        return $this->hasMany(Question::class, 'id');
    }
}
