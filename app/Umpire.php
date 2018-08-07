<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Umpire extends Model
{


    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
