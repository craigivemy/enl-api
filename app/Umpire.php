<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Umpire extends Model
{
    protected $guarded = [];

    /**
     * Return this umpire's team
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
