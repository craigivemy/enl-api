<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Club as ClubResource;
use App\Http\Resources\DivisionWithTeams as DivisionResource;
use App\Http\Resources\Season as SeasonResource;

class Team extends JsonResource
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
            'name'              => $this->name,
            'primaryColour'    => $this->primary_colour,
            'secondaryColour'  => $this->secondary_colour,
            'tertiaryColour'   => $this->tertiary_colour,
            'logoUrl'          => $this->logo_url,
            'narrative'         => $this->narrative,
            'deletedAt'         => $this->deleted_at,
            'activeThisSeason'  => $this->whenLoaded('seasons', function() {
                return $this->seasons->count();
            })
        ];

    }
}
