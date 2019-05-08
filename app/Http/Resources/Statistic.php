<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Statistic extends JsonResource
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
            'id'                => $this->id,
            'teamId'           => $this->team_id,
            'seasonId'         => $this->season_id,
            'divisionId'       => $this->division_id,
            'played'            => $this->played,
            'wins'              => $this->wins,
            'losses'            => $this->losses,
            'draws'             => $this->draws,
            'scored'            => $this->scored,
            'conceded'          => $this->conceded,
            'goalDifference'   => $this->goal_difference,
            'bonusPoints'      => $this->bonus_points,
            'points'            => $this->points
        ];
    }
}
