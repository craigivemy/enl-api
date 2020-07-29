<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Season extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_season_team');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'division_season_team');
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_season_team');
    }


//    /**
//     * Return divisions for this season
//     *
//     * @return BelongsToMany
//     */
//    public function divisions()
//    {
//        return $this->belongsToMany('App\DivisionWithTeams');
//    }
//
//    public function teams()
//    {
//        return $this->belongsToMany('App\Team');
//    }

}
