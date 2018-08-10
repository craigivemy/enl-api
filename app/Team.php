<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    public function players()
    {
        return $this->hasMany('App\Player');
    }

    public function umpires()
    {
        return $this->hasMany('App\Umpire');
    }

    public function club()
    {
        return $this->belongsTo('App\Club');
    }

    // need matches? or filter query param in request?
}
