<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $guarded = [];

    /**
     * Return divisions for this season
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function divisions()
    {
        return $this->belongsToMany('App\Division');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

}
