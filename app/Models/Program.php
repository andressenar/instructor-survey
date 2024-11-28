<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
<<<<<<< HEAD
    protected $fillable=[
        'name'
    ];
=======

    protected $fillable = [
        'code',
        'name',
    ];

>>>>>>> 823d9be2625c3e6cc038acca0aa506a82cf72489
    public function courses ()
    {
        return $this->hasMany(Course::class, 'id');
    }
}
