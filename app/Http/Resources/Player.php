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
            'team_id'           => $this->team_id,
            'played_up_count'   => $this->played_up_count
        ];
    }
}
