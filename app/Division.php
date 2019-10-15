<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function matches()
    {
        return $this->hasMany('App\Fixture');
    }

    // new
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_division_team');
    }
    // new
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'season_division_team');
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
