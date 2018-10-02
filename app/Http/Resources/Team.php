<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Club as ClubResource;

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
            'primary_colour'    => $this->primary_colour,
            'secondary_colour'  => $this->secondary_colour,
            'tertiary_colour'   => $this->tertiary_colour,
            'logo_url'          => $this->logo_url,
            'narrative'         => $this->narrative,
            'division_id'       => $this->division_id,
            //'club'              => optional($this->club)->name // just testing function
            'club'              => new ClubResource($this->club)
        ];

    }

    public function with($request)
    {
        return [
            'status'    => 'success'
        ];
    }
}