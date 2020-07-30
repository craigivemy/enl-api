<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Player extends JsonResource
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
            'forename'          => $this->forename,
            'surname'           => $this->surname,
            'team'              => $this->whenLoaded('team'),
            'playedUpCount'     => $this->whenLoaded('playedUps')->count(),
            'playedUps'         => $this->whenLoaded('playedUps')
        ];
    }
}
