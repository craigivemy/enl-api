<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{


    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function season()
    {
        return $this->belongsTo('App\Season');
    }

    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    // player?
}
