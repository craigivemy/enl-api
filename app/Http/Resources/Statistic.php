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
            'team_id'           => $this->team_id,
            'season_id'         => $this->season_id,
            'division_id'       => $this->division_id,
            'played'            => $this->played,
            'wins'              => $this->wins,
            'losses'            => $this->losses,
            'draws'             => $this->draws,
            'scored'            => $this->scored,
            'conceded'          => $this->conceded,
            'goal_difference'   => $this->goal_difference,
            'bonus_points'      => $this->bonus_points,
            'points'            => $this->points
        ];
    }

    public function with($request)
    {
        return [
            'status'    => 'success'
        ];
    }

}
