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
            'playedUpCount'     => $this->whenLoaded('playedUps', function() {
               return $this->playedUps->count();
            }),
            // todo - create resource for these so can use camelCase
            'playedUps'         => $this->whenLoaded('playedUps'),
            'team'              => $this->whenLoaded('teams')
        ];
    }
}
