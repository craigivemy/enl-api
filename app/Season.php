<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Season extends Model
{
    protected $guarded = [];
    protected $hidden = ['pivot'];


    /**
     * Return divisions for this season
     *
     * @return BelongsToMany
     */
    public function divisions()
    {
        return $this->belongsToMany('App\Division');
    }

    public function teams() // todo - has many through? needs division id not season id on team table?
    {
        return $this->belongsToMany('App\Team');
    }

}
