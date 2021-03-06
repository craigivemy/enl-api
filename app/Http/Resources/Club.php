<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Club extends JsonResource
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
            'primaryColour'     => $this->primary_colour,
            'secondaryColour'  => $this->secondary_colour,
            'tertiaryColour'   => $this->tertiary_colour,
            'logoUrl'          => $this->logo_url,
            'narrative'         => $this->narrative
        ];
    }
}
