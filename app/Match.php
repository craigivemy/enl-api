<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    public function season()
    {
        return $this->belongsTo('App\Season');
    }
}
