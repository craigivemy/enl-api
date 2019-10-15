<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Season extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];

    // new
    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'season_division_team');
    }

    // new
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'season_division_team');
    }


//    /**
//     * Return divisions for this season
//     *
//     * @return BelongsToMany
//     */
//    public function divisions()
//    {
//        return $this->belongsToMany('App\Division');
//    }
//
//    public function teams()
//    {
//        return $this->belongsToMany('App\Team');
//    }

}
