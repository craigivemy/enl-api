<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{


    // this is quesitonable - should be hasMany? Not according to docs
    public function divisions()
    {
        return $this->belongsToMany('App\Division');
    }

}
