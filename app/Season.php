<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{

    public function divisions()
    {
        return $this->belongsToMany('App\Division');
    }

}
