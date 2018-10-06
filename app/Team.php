<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    /**
     * Return the players for this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany('App\Player');
    }

    /**
     * Return the umpires for this team
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function umpires()
    {
        return $this->hasMany('App\Umpire');
    }

    /**
     * Return this team's club
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function club()
    {
        return $this->belongsTo('App\Club');
    }

}
