<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $guarded = [];
    protected $table = 'matches';
    /**
     * Return the division for this match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    /**
     * Return the season for this match
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    public function homeTeam()
    {
        return $this->hasOne('App\Team', 'id', 'home_id');
    }

    public function awayTeam()
    {
        return $this->hasOne('App\Team', 'id','away_id');
    }

}
