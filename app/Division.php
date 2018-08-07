<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{


    public function seasons()
    {
        return $this->belongsToMany('App\Season');
    }

}
