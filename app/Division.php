<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    // new
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'division_season_team');
    }
    // new
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'division_season_team');
    }

//    public function seasons()
//    {
//        return $this->belongsToMany('App\Season');
//    }
//
//    public function teams() {
//        return $this->hasMany('App\Team');
//    }

}
