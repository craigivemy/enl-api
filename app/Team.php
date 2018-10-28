<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

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

    public function division() {
        return $this->belongsTo('App\Division');
    }

}
