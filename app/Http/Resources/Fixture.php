<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Fixture extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'homeScore'    => $this->home_score,
            'awayScore'    => $this->away_score,
            'divisionId'   => $this->division_id,
            'seasonId'     => $this->season_id,
            'homeId'       => $this->home_id,
            'awayId'       => $this->away_id,
            'matchDate'    => $this->match_date,
            'round'         => $this->round,
            'played'        => (bool) $this->played,
            'walkover'      => (bool) $this->walkover,
            'homeAdjust'   => $this->home_adjust,
            'awayAdjust'   => $this->away_adjust
        ];
    }
}
