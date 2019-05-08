<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function matches()
    {
        return $this->hasMany('App\Fixture');
    }

    public function seasons()
    {
        return $this->belongsToMany('App\Season');
    }

    public function teams() {
        return $this->hasMany('App\Team');
    }

}
