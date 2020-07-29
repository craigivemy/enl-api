<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Player extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];

    /**
     * Return this player's team
     *
     * @return BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'player_season_team');
    }

    public function playedUps() {
        return $this->hasMany('App\PlayedUp');
    }

}
