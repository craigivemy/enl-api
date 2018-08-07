<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{


    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    public function seasons()
    {
        return $this->belongsToMany('App\Season');
    }

}
