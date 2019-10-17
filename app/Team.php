<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];


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

    // new
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'division_season_team');
    }

    // new
    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_season_team');
    }


//    public function division() {
//        return $this->belongsTo('App\Division');
//        // should be belongs to many - for historical data?
//    }
//
//    public function seasons()
//    {
//        return $this->belongsToMany('App\Season')->select('season_id');
//    }
}
