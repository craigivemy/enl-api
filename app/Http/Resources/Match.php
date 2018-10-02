<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Match extends JsonResource
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
            'home_score'    => $this->home_score,
            'away_score'    => $this->away_score,
            'division_id'   => $this->division_id,
            'season_id'     => $this->season_id,
            'home_id'       => $this->home_id,
            'away_id'       => $this->away_id,
            'match_date'    => $this->match_date,
            'round'         => $this->round,
            'played'        => $this->played,
            'walkover'      => $this->walkover,
            'home_adjust'   => $this->home_adjust,
            'away_adjust'   => $this->away_adjust,
            'test'          => 2
        ];
    }

    public function with($request)
    {
        return [
            'status'    => 'success'
        ];
    }

}
