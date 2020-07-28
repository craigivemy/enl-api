<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayedUp extends Model
{
    protected $guarded = [];

    public function player() {
        return $this->hasOne('player');
    }

}
